<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models;
use Validator;

class ProductTypeController extends BaseController
{
    // Store
    public function store (Request $request)
    {
        // get data
        $query = new ProductType;
        $query = $this->filter($query, $request);

        // return response
        return $this->sendResponse($query, "เรียกใช้งานข้อมูลเรียบร้อย");

    }

    // Detail
    public function detail (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'member_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        //  detail
        $member = Member::where("member_id", $request->member_id)->first();

        // response
        return $this->sendResponse($member, "ดึงข้อมูลเรียบร้อย");
    }

    // Update
    public function update (Request $request)
    {

        // validate
        $validator = Validator::make($request->all(), [
            'member_code' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // update and get
        $member = Member::where("id", $request->member_id)->first();
        $result = $member->update(["member_title_name" => $request->member_title_name,
            "member_code" => $request->member_code,
            "member_tel" => $request->member_tel,
            "member_bank" => $request->member_bank,
            "member_bank_own" => $request->member_bank_own,
            "member_bank_id" => $request->member_bank_id,
            "member_class" => $request->member_class,
            "member_code_id" => $request->member_code_id,
            "member_token_line" => $request->member_token_line
        ]);
        $success = $member->refresh();

        // return response
        return $this->sendResponse($success, "บันทึกข้อมูลเรียบร้อย");
    }

    // Change Password
    public function changePassword (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'member_id' => 'required',
            'member_password' => 'required',
            'member_password_new' => 'required|max:20|confirmed',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
    }

    // Setting Status
    public function active (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'member_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // get data and set status
        $member = Member::where("member_id", $request->member_id)->first();
        $member_status = $member->member_status == 0 ? 1 : 0;
        $result = $member->update(["member_status" => $member_status]);
        $success = $member->refresh();

        // return response
        return $this->sendResponse($success, "แก้ไขสถานะการใช้งานเรียบร้อย");
    }

    // Delete
    public function delete (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'member_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // Delete
        $member = Member::find($request->member_id)->delete();

        // return response
        return $this->sendResponse($member, "ลบข้อมูลเรียบร้อย");
    }
}
