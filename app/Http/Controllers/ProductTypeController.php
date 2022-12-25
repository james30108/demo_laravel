<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\ProductType;

class ThreadTypeController extends Controller
{
    // create
    public function create (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'thread_type_name' => 'required|max:50|unique:system_thread_type,thread_type_name,NULL,id',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        // insert
        $query = ThreadType::create(["thread_type_name" => $request->thread_type_name]);

        // return response
        return $this->sendResponse($query, "บันทึกข้อมูลเรียบร้อย");

    }
    // Store
    public function store (Request $request)
    {
        // get data
        $query = new ThreadType;
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
        $success = ProductType::find($request->id);

        // response
        return $this->sendResponse($success, "ดึงข้อมูลเรียบร้อย");
    }

    // Update
    public function update (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'thread_type_name' => 'required|unique:system_thread_type,thread_type_name,' . $request->id . ',id',
        ]);
        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        // update and get
        $query = ThreadType::find($request->id)->update(["thread_type_name" => $request->thread_type_name]);
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

        // get data
        $query = ThreadType::find($request->id);
        // check
        if ($query->thread_type_count) return $this->sendError('Error.', "มีกระทู้ในหัวข้อนี้");
        // delete
        $query->delete();

        // return response
        return $this->sendResponse($query, "ลบข้อมูลเรียบร้อย");
    }
}
