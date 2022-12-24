<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Admin;
use Validator;

class AdminController extends BaseController
{
    // Store
    public function store (Request $request)
    {
        // get data
        $query = new Admin;
        $query = $this->filter($query, $request);

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

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        // detail
        $query = Admin::find($request->id);

        // response
        return $this->sendResponse($query, "ดึงข้อมูลเรียบร้อย");
    }

    // Update
    public function update (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id'                => 'required',
            'admin_user'        => 'required|min:6|max:15|unique:system_admin,admin_user,' . $request->id . ',id',
            'admin_name'        => 'required|max:20|unique:system_admin,admin_name,' . $request->id . ',id',
            'admin_permission'  => 'required|array',
            'admin_status'      => 'required',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        // update
        Admin::find($request->id)->update([
            "admin_user"    => $request->admin_user,
            "admin_name"    => $request->admin_name,
            "admin_status"  => $request->admin_status,
            "admin_permission" => $request->admin_permission,
        ]);

        // return response
        return $this->sendResponse("Success", "บันทึกข้อมูลเรียบร้อย");
    }

    // Update Password
    public function UpdatePassword (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id'                => 'required',
            'admin_password'    => 'required',
            'admin_password_new'=> 'required|min:6|max:20|confirmed',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        $password = bcrypt($request->admin_password_new);
        Admin::find($request->id)->update(["password" => $password]);

        // return response
        return $this->sendResponse("Success", "บันทึกข้อมูลเรียบร้อย");
    }

    // Setting language
    public function language (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        // get data and set status
        $query      = Member::find($request->id);
        $admin_lang = $query->admin_lang == 0 ? 1 : 0;
        $query->update(["admin_lang" => $admin_lang]);

        // return response
        return $this->sendResponse($query, "เปลี่ยนภาษาเรียบร้อย");
    }
}
