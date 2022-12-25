<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Transfer;
use App\Models\Member;
use Validator;

class TransferController extends BaseController
{
    // Create
    public function create (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'transfer_from'  => 'required',
            'transfer_to'    => 'required',
            'transfer_money' => 'required|numeric',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        // check
        $member_from = Member::find($request->transfer_from);
        if ($request->transfer_money > $member_from->member_e_wallet) return $this->sendError('Error', "จำนวนเงินในกระเป๋ามีไม่พอในการโอน");

        // create
        Transfer::create([
            "transfer_from"     => $request->transfer_from,
            "transfer_to"       => $request->transfer_to,
            "transfer_money"    => $request->transfer_money,
            "transfer_status"   => 1,
        ]);

        // Update E-Wallet
        $member_from->decrement("member_e_wallet", $request->transfer_money);
        Member::find($request->transfer_to)->increment("member_e_wallet", $request->transfer_money);

        // response
        return $this->sendResponse("Success", "บันทึกข้อมูลเรียบร้อย");

    }

    // Store
    public function store (Request $request)
    {
        // get data
        $query = new Transfer;
        $query = $this->filter($query, $request);

        // return response
        return $this->sendResponse($query, "เรียกใช้งานข้อมูลเรียบร้อย");
    }
}
