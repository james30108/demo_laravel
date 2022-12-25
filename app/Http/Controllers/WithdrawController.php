<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Withdraw;
use App\Models\Liner;
use App\Http\Controllers\BaseController as BaseController;
use Validator;

class WithdrawController extends BaseController
{
    // Create
    public function create (Request $request)
    {
        $withdraw_min        = $this->rule("withdraw_min");
        $withdraw_max        = $this->rule("withdraw_max");
        $system_com_withdraw = $this->rule("system_com_withdraw");

        $validator = Validator::make($request->all(), [
            'withdraw_member'   => 'required',
            'withdraw_bank_own' => 'required',
            'withdraw_bank'     => 'required',
            'withdraw_bank_id'  => 'required|integer',
            'withdraw_point'    => 'required|numeric|min:' . $withdraw_min,
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        $withdraw_full_point = $request->withdraw_point >= $withdraw_max && $withdraw_max != 0 ? $withdraw_max : $request->withdraw_point;
        $withdraw_point      = $this->withdrawCalculate ($withdraw_full_point);

        // Check Point
        $query = Liner::where([["liner_member", $request->withdraw_member]])->first();
        if ($request->withdraw_point == 0) return $this->sendError('Error.', "ยอดเงินที่ถอนเป็น 0");
        if ($query->liner_point < $withdraw_full_point) return $this->sendError('Error.', "จำนวนเงินที่ถอนมีไม่เพียงพอ");

        //  Create Withdraw
        Withdraw::create([
            "withdraw_member"   => $request->withdraw_member,
            "withdraw_bank_own" => $request->withdraw_bank_own,
            "withdraw_bank"     => $request->withdraw_bank,
            "withdraw_bank_id"  => $request->withdraw_bank_id,
            "withdraw_bank_own" => $request->withdraw_bank_own,
            "withdraw_point"    => $withdraw_point,
            "withdraw_full_point" => $withdraw_full_point,
        ]);

        $query->update(["liner_status" => 2]);
        $query->decrement("liner_point", $withdraw_full_point);

        if ($system_com_withdraw == 2) $query->decrement("liner_withdraw_count");

        // return response
        return $this->sendResponse("Success", "บันทึกข้อมูลเรียบร้อย");
    }

    // Status
    public function status (Request $request)
    {
        $system_com_withdraw = $this->rule("system_com_withdraw");

        $validator = Validator::make($request->all(), [
            'id'                => 'required',
            'withdraw_status'   => 'required|in:1,2',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        // Get Data
        $query = Withdraw::find($request->id);
        // Check
        if ($query->withdraw_status != 0) return $this->sendError('Error.', "รายการนี้ถูกดำเนินการไปแล้ว");
        // Update
        $query->update(["withdraw_status" => $request->withdraw_status]);
        // Get Liner
        $liner = Liner::where("liner_member", $query->withdraw_member);
        $liner->update(["liner_status" => 1]);

        // If Cancel
        if ($request->withdraw_status == 2) {
            $liner->increment("liner_point", $query->withdraw_full_point);
            if ($system_com_withdraw == 2) $liner->increment("liner_withdraw_count");
        }

        // return response
        return $this->sendResponse("Success", "บันทึกข้อมูลเรียบร้อย");
    }

    // Store
    public function store (Request $request)
    {
        // get data
        $query = new Withdraw;
        $query = $this->filter($query, $request);

        // return response
        return $this->sendResponse($query, "เรียกใช้งานข้อมูลเรียบร้อย");
    }

    // Detail
    public function detail (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        // detail
        $query = Withdraw::find($request->id);

        // Check
        if ($query == null) return $this->sendError('Error.', "ไม่พบข้อมูลในระบบ");

        // response
        return $this->sendResponse($query, "ดึงข้อมูลเรียบร้อย");
    }
}
