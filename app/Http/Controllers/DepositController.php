<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Deposit;
use App\Models\Member;
use Validator;

class LinerController extends BaseController
{
    public static $path = '/images/deposit/';

    // Create
    public function create (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'deposit_member'    => 'required',
            'deposit_money'     => 'required|integer',
            'deposit_slip'      => 'image',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        // data
        $data["deposit_member"] = $request->deposit_member;
        $data["deposit_money"]  = $request->deposit_money;
        $data["deposit_bank"]   = $request->deposit_bank;
        $data["deposit_detail"] = $request->deposit_detail;
        $data["deposit_create"] = $request->deposit_date . " " . $request->deposit_time;

        if ($request->hasFile('deposit_slip')) {
            $image = $request->file('deposit_slip');
            $data['deposit_slip']   = time() . "_" . rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path(self::$path), $data['deposit_slip']);
        }

        // create
        Deposit::create($data);

        // response
        return $this->sendResponse("Success", "บันทึกข้อมูลเรียบร้อย");

    }

    // Update Status
    public function status (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id'                => 'required',
            'deposit_status'    => 'required_with:1,2,3',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());


        // Update Data
        $query = Deposit::find($request->id);
        $query->update(["deposit_status" => $request->deposit_status]);

        // If Success
        if ($request->deposit_status == 1) {

            Member::find($query->deposit_member)->increment("member_e_wallet", $query->deposit_money);
        }

        // response
        return $this->sendResponse("Success", "บันทึกข้อมูลเรียบร้อย");

    }

    // Store
    public function store (Request $request)
    {
        // get data
        $query = new Deposit;
        $query = $this->filter($query, $request);

        foreach ($query AS $key => $value) {
            $data[$key] = $value;
            if ($data[$key]['deposit_slip'] != "") {
                $data[$key]['deposit_slip'] = asset(self::$path . $data[$key]['deposit_slip']);
            }
        }

        if (!isset($data)) return $this->sendError('ไม่พบข้อมูบในระบบ', "");

        // return response
        return $this->sendResponse($data, "เรียกใช้งานข้อมูลเรียบร้อย");
    }

    // Detail
    public function detail (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // detail
        $query = Deposit::find($request->id);

        if ($query['deposit_slip'] != "") {
            $query['deposit_slip'] = asset(self::$path . $query['deposit_slip']);
        }

        // response
        return $this->sendResponse($query, "ดึงข้อมูลเรียบร้อย");

    }
}
