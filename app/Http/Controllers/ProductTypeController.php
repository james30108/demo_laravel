<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Validator;
use App\Models\ProductType;

class ProductTypeController extends BaseController
{
    // create
    public function create (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_type_code' => 'required|unique:system_product_type,product_type_code,NULL,id',
            'product_type_name' => 'required|unique:system_product_type,product_type_name,NULL,id',
            // 'product_type_code' => 'required|unique:system_product_type,product_type_code,NULL,id,deleted_at,NULL',
            // 'product_type_name' => 'required|unique:system_product_type,product_type_name,NULL,id,deleted_at,NULL',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // insert
        $input  = $request->all();
        $data['product_type_code'] = $input['product_type_code'];
        $data['product_type_name'] = $input['product_type_name'];
        $data['product_type_detail'] = isset($input['product_type_detail']) ? $input['product_type_detail'] : null;

        $success = ProductType::create($data);

        // return response
        return $this->sendResponse($success, "บันทึกข้อมูลเรียบร้อย");

    }
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
            'id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

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
            'product_type_code' => 'required|unique:system_product_type,product_type_code,' . $request->id . ',id',
            'product_type_name' => 'required|unique:system_product_type,product_type_name,' . $request->id . ',id',
            // 'product_type_code' => 'required|unique:system_product_type,product_type_code,' . $request->id . ',id,deleted_at,NULL',
            // 'product_type_name' => 'required|unique:system_product_type,product_type_name,' . $request->id . ',id,deleted_at,NULL',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // update and get
        $query = ProductType::find($request->id);
        $query->update(["product_type_code" => $request->product_type_code,
            "product_type_name" => $request->product_type_name,
            "product_type_detail" => $request->product_type_detail,
        ]);
        $success = $query->refresh();

        // return response
        return $this->sendResponse($success, "บันทึกข้อมูลเรียบร้อย");
    }

    // Status
    public function status (Request $request)
    {

        // validate
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // update and get
        $query = ProductType::find($request->id);
        $product_type_status = $query->product_type_status == 0 ? 1 : 0;
        $query->update(["product_type_status" => $product_type_status]);
        $success = $query->refresh();

        // return response
        return $this->sendResponse($success, "บันทึกข้อมูลเรียบร้อย");
    }

    // Delete
    public function delete (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // Delete
        $query = ProductType::find($request->id)->delete();

        // return response
        return $this->sendResponse($query, "ลบข้อมูลเรียบร้อย");
    }
}
