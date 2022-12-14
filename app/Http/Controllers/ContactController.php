<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Contact;
use Validator;

class ContactController extends BaseController
{
    // create
    public function create (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact_direct'        => 'required',
            'contact_person_id'     => 'required',
            'contact_person_type'   => 'required',
            'contact_name'          => 'required|max:50',
            'contact_email'         => 'required|email',
            'contact_title'         => 'required|max:100',
            'contact_detail'        => 'required',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        // insert
        Contact::create([
            "contact_direct"        => $request->contact_direct,
            "contact_person_id"     => $request->contact_person_id,
            "contact_person_type"   => $request->contact_person_type,
            "contact_name"          => $request->contact_name,
            "contact_email"         => $request->contact_email,
            "contact_title"         => $request->contact_title,
            "contact_detail"        => $request->contact_detail,
        ]);

        // return response
        return $this->sendResponse("Success", "บันทึกข้อมูลเรียบร้อย");

    }
    // Store
    public function store (Request $request)
    {
        // get data
        $query = new Contact;
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

        //  detail
        $query = Contact::find($request->id);

        // response
        return $this->sendResponse($query, "ดึงข้อมูลเรียบร้อย");
    }

    // Status
    public function status (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        // get data
        $query = Contact::find($request->id);
        // check status
        if ($query->contact_status == 1) return $this->sendError('Error.', "ข้อความนี้ถูกอ่านไปแล้ว");
        // update
        $query->update(["contact_status" => 1]);
        // return response
        return $this->sendResponse($query, "บันทึกข้อมูลเรียบร้อย");
    }

    // Delete
    public function delete (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        // Delete
        $query = Contact::find($request->id)->delete();

        // return response
        return $this->sendResponse($query, "ลบข้อมูลเรียบร้อย");
    }
}
