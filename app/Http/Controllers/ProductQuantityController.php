<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductQuantity;

class ProductQuantityController extends Controller
{
    // Create
    public function create (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'product_quantity_old' => 'required',
            'product_quantity_new' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // plus product
        $query = Product::find($request->id);
        $query->increment("product_quantity", $request->product_quantity);

        // insert to product_quantity
        $data['product_quantity_main']  = $request->id;
        $data['product_quantity_old']   = $request->product_quantity_old;
        $data['product_quantity_new']   = $request->product_quantity_new;

        $query_2 = ProductQuantity::create($data);

        // return response
        return $this->sendResponse($query_2, "ลบข้อมูลเรียบร้อย");
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
        $query = Product::where("product_quantity_main", $request->id);

        // response
        return $this->sendResponse($query, "ดึงข้อมูลเรียบร้อย");
    }
}
