<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Validator;
use App\Models\Product;
use App\Models\Cart;

class CartController extends BaseController
{
    // Store
    public function store (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cart_person_id' => 'required',
            'cart_person_type' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // get data
        $query = Cart::where([
            ['cart_person_id', $request->cart_person_id],
            ['cart_person_type', $request->cart_person_type],
        ])->get();

        // return response
        return $this->sendResponse($query, "เรียกใช้งานข้อมูลเรียบร้อย");

    }

    // Create
    public function create (Request $request)
    {
        $system_stock = $this->rule("system_stock");

        $validator = Validator::make($request->all(), [
            'cart_person_id' => 'required',
            'cart_person_type' => 'required',
            'cart_product_id' => 'required',
            'cart_product_quantity' => 'required|integer',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // check quantity
        $product = Product::find($request->cart_product_id);
        $cart = Cart::where([
                ['cart_person_id', $request->cart_person_id],
                ['cart_person_type', $request->cart_person_type],
                ['cart_product_id', $request->cart_product_id]
            ])
            ->first();
        $cart_product_quantity = $cart != null ? $cart->cart_product_quantity + $request->cart_product_quantity : $request->cart_product_quantity;

        if ($system_stock == 1 &&
            (
                ($cart != null && $cart_product_quantity > $product->product_quantity) ||
                ($cart == null && $cart_product_quantity > $product->product_quantity)
            )
        ) {

            // return response
            return $this->sendError('สินค้ามีจำนวนไม่พอ');
        }
        elseif (
            ($system_stock == 1 &&
                (
                    ($cart != null && $cart_product_quantity <= $product->product_quantity) ||
                    ($cart == null && $cart_product_quantity <= $product->product_quantity)
                )
            ) ||
            $system_stock == 0
        ) {

            // update or insert
            Cart::updateOrCreate(
                [
                    'cart_person_id' => $request->cart_person_id,
                    'cart_person_type' => $request->cart_person_type,
                    'cart_product_id' => $request->cart_product_id
                ],
            )->increment('cart_product_quantity', $request->cart_product_quantity);

            // return response
            return $this->sendResponse("Success", "บันทึกข้อมูลเรียบร้อย");
        }
    }

    // Update
    public function update (Request $request)
    {
        $system_stock = $this->rule("system_stock");

        // validate
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'cart_product_quantity' => 'required|integer',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if ($request->cart_product_quantity > -1) {

            // check quantity
            $cart       = Cart::find($request->id);
            $product    = Product::find($cart->cart_product_id);

            if ($system_stock == 1 &&
                (
                    ($cart != null && $request->cart_product_quantity > $product->product_quantity) ||
                    ($cart == null && $request->cart_product_quantity > $product->product_quantity)
                )
            ) {
                return $this->sendError('สินค้ามีจำนวนไม่เพียงพอ');
            }
            else {
                Cart::find($request->id)->update(['cart_product_quantity' => $request->cart_product_quantity]);
            }
        }
        else {
            Cart::find($request->id)->increment('cart_product_quantity', $request->cart_product_quantity);
        }

        // check zero value
        $cart = Cart::find($request->id);
        if ($cart->cart_product_quantity <= 0) {
            $cart->delete();
        }

        // return response
        return $this->sendResponse("Success", "บันทึกข้อมูลเรียบร้อย");
    }

    // delete
    public function delete (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // delete
        $cart = Cart::find($request->id)->delete();

        // return response
        return $this->sendResponse("Success", "บันทึกข้อมูลเรียบร้อย");
    }

    // delete all
    public function deleteAll (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'cart_person_id' => 'required',
            'cart_person_type' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // delete
        $cart = Cart::where([
            ["cart_person_id", $request->cart_person_id],
            ['cart_person_type', $request->cart_person_type]
        ])
        ->delete();

        // return response
        return $this->sendResponse("Success", "บันทึกข้อมูลเรียบร้อย");
    }
}
