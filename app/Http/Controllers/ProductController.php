<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Validator;
use App\Models\Product;

class ProductController extends Controller
{
    public static $path = '/images/products/';

    // Create
    public function create (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_code' => 'required|unique:system_product,product_code,NULL,id',
            'product_name' => 'required|unique:system_product,product_name,NULL,id',
            'product_price' => 'required',
            'product_price_member' => 'required',
            'product_point' => 'required',
            'product_image_cover' => 'image',
            // 'product_image' => 'image',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // insert
        $input  = $request->all();
        $data['product_type']        = $input['product_type'];
        $data['product_type2']       = $input['product_type2'];
        $data['product_name']        = $input['product_name'];
        $data['product_code']        = $input['product_code'];
        $data['product_detail']      = $input['product_detail'];
        $data['product_price']       = $input['product_price'];
        $data['product_price_member'] = $input['product_price_member'];
        $data['product_point']       = $input['product_point'];
        $data['product_freight']     = $input['product_freight'];
        $data['product_weight']      = $input['product_weight'];
        $data['product_quantity']    = $input['product_quantity'];
        $data['product_unit']        = isset($input['product_unit']) ? : null;
        $data['product_group']       = isset($input['product_group']) ? : null;
        $data['product_etc']         = isset($input['product_etc']) ? : 0;
        $data['product_etc2']        = isset($input['product_etc2']) ? : 0;

        if ($request->hasFile('product_image_cover')) {
            $image = $request->file('product_image_cover');
            $data['product_image_cover']   = time() . "_" . rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path(self::$path), $data['product_image_cover']);
        }
        if ($request->hasFile('product_image')) {
            $i = 0;
            foreach ($request->file('product_image') as $image) {
                $i++;
                $data['product_image_' . $i] = time() . "_" . rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path(self::$path), $data['product_image_' . $i]);
                if ($i == 5) break;
            }
        }

        $query = Product::create($data);

        // return response
        return $this->sendResponse($query, "บันทึกข้อมูลเรียบร้อย");

    }

    // Store
    public function store (Request $request)
    {
        // get data
        $query = new Product;
        $query = $this->filter($query, $request);

        foreach ($query AS $key => $value) {
            $data[$key] = $value;
            if ($data[$key]['product_image_cover'] != "") {
                $data[$key]['product_image_cover'] = asset(self::$path . $data[$key]['product_image_cover']);
            }
            for ($i=1; $i <= 5; $i++) {
                if ($data[$key]['product_image_' . $i] != "") {
                    $data[$key]['product_image_' . $i] = asset(self::$path . $data[$key]['product_image_' . $i]);
                }
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

        //  detail
        $query = Product::find($request->id);

        if ($query['product_image_cover'] != "") {
            $query['product_image_cover'] = asset(self::$path . $query['product_image_cover']);
        }
        for ($i=1; $i <= 5; $i++) {
            if ($query['product_image_' . $i] != "") {
                $query['product_image_' . $i] = asset(self::$path . $query['product_image_' . $i]);
            }
        }

        // response
        return $this->sendResponse($query, "ดึงข้อมูลเรียบร้อย");
    }

    // Update
    public function update (Request $request)
    {

        // validate
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'product_code' => 'required|unique:system_product,product_code,' . $request->id . ',id',
            'product_name' => 'required|unique:system_product,product_name,' . $request->id . ',id',
            'product_price' => 'required',
            'product_price_member' => 'required',
            'product_point' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // update and get
        $query = Product::find($request->id);
        $query->update(["product_type" => $request->product_type,
            "product_type2" => isset($request->product_type2) ? $request->product_type2 : 0,
            "product_name" => $request->product_name,
            "product_code" => $request->product_code,
            "product_detail" => isset($request->product_detail) ? $request->product_detail : null,
            "product_price" => $request->product_price,
            "product_price_member" => $request->product_price_member,
            "product_point" => $request->product_point,
            "product_freight" => isset($request->product_freight) ? $request->product_freight : 0,
            "product_weight" => isset($request->product_weight) ? $request->product_weight : 0,
            "product_quantity" => isset($request->product_quantity) ? $request->product_quantity : 0,
            "product_group" => isset($request->product_group) ? $request->product_group : null,
            "product_etc" => isset($request->product_etc) ? $request->product_etc : 0,
            "product_etc2" => isset($request->product_etc2) ? $request->product_etc2 : 0,
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
        $query = Product::find($request->id);
        $product_status = $query->product_status == 0 ? 1 : 0;
        $query->update(["product_status" => $product_status]);
        $success = $query->refresh();

        // return response
        return $this->sendResponse($success, "บันทึกข้อมูลเรียบร้อย");
    }

    // Delete Image
    public function deleteImage (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'product_image_name' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // get data
        $query = Product::select($request->product_image_name)->find($request->id);

        // delete old file
        if(File::exists(public_path(self::$path . "/" . $query[$request->product_image_name]))){
            File::delete(public_path(self::$path . "/" . $query[$request->product_image_name]));
        }

        // update
        $query = Product::find($request->id);
        $query->update([$request->product_image_name => null]);
        $success = $query->refresh();

        // return response
        return $this->sendResponse($success, "บันทึกข้อมูลเรียบร้อย");
    }

    // Edit Image
    public function updateImage (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'product_image_name' => 'required',
            'product_image_file' => 'required|image'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // get data
        $query = Product::select($request->product_image_name)->find($request->id);

        // delete old file
        if(File::exists(public_path(self::$path . "/" . $query[$request->product_image_name]))){
            File::delete(public_path(self::$path . "/" . $query[$request->product_image_name]));
        }

        // update
        if ($request->hasFile('product_image_file')) {
            $image = $request->file('product_image_file');
            $data['product_image_file'] = time() . "_" . rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path(self::$path), $data['product_image_file']);
        }
        $query = Product::find($request->id);
        $query->update([$request->product_image_name => $data['product_image_file']]);
        $success = $query->refresh();

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

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // Delete
        $query = Product::find($request->id);

        if(File::exists(public_path(self::$path . "/" . $query->product_image_cover))){
            File::delete(public_path(self::$path . "/" . $query->product_image_cover));
        }
        if(File::exists(public_path(self::$path . "/" . $query->product_image_1))){
            File::delete(public_path(self::$path . "/" . $query->product_image_1));
        }
        if(File::exists(public_path(self::$path . "/" . $query->product_image_2))){
            File::delete(public_path(self::$path . "/" . $query->product_image_2));
        }
        if(File::exists(public_path(self::$path . "/" . $query->product_image_3))){
            File::delete(public_path(self::$path . "/" . $query->product_image_3));
        }
        if(File::exists(public_path(self::$path . "/" . $query->product_image_4))){
            File::delete(public_path(self::$path . "/" . $query->product_image_4));
        }
        if(File::exists(public_path(self::$path . "/" . $query->product_image_5))){
            File::delete(public_path(self::$path . "/" . $query->product_image_5));
        }

        $query->delete();

        // return response
        return $this->sendResponse("Deleted", "ลบข้อมูลเรียบร้อย");
    }
}
