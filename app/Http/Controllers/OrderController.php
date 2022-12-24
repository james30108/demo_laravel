<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PayRefer;
use App\Http\Controllers\BaseController as BaseController;
use Validator;

class OrderController extends BaseController
{

    public static $path = '/images/pay/';

    // Create
    public function create (Request $request)
    {
        $system_stock       = $this->rule("system_stock");
        $system_e_wallet    = $this->rule("system_e_wallet");

        $validator = Validator::make($request->all(), [
            'order_person_id' => 'required',
            'order_person_type' => 'required',
            'order_name' => 'required',
            'order_tel' => 'required',
            'order_type' => 'required',
            'order_pay_type' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $query = Cart::where([
            ['cart_person_id', $request->order_person_id],
            ['cart_person_type', $request->order_person_type]
        ])
        ->get();

        if ($query->count() == 0) return $this->sendError('ไม่มีสินค้าในตะหร้า');

        $order_price_member = 0;
        $order_price_buyer  = 0;
        $order_quantity     = 0;
        $order_freight      = 0;
        $order_point        = 0;

        foreach ($query as $key => $value) {
            // check stock
            if ($system_stock == 1 && $query[$key]["cart_product_quantity"] > $query[$key]["product"]["product_quantity"]) {
                Cart::find($query[$key]["id"])->delete();
                return $this->sendError('สินค้ามีจำนวนไม่พอ');
            }
            $order_quantity         = $order_quantity       + $query[$key]["cart_product_quantity"];
            $order_price_buyer      = $order_price_buyer    + ($query[$key]["product"]["product_price"] * $query[$key]["cart_product_quantity"]);
            $order_price_member     = $order_price_member   + ($query[$key]["product"]["product_price_member"] * $query[$key]["cart_product_quantity"]);
            $order_freight          = $order_freight        + ($query[$key]["product"]["product_freight"] * $query[$key]["cart_product_quantity"]);
            $order_point            = $order_point          + ($query[$key]["product"]["product_point"] * $query[$key]["cart_product_quantity"]);
        }


        // insert order
        $input          = $request->all();
        $order_price    = $input['order_person_type'] == 0 ? $order_price_member: $order_price_buyer;
        $code           = Order::latest()->first();
        $plus           = isset($code->id) ? $code->id + 1 : 1;
        if 		($plus <= 9) {$zero="000000";}
        elseif 	($plus <= 99) {$zero="00000";}
        elseif 	($plus <= 999) {$zero="0000";}
        elseif 	($plus <= 9999) {$zero="000";}
        elseif 	($plus <= 99999) {$zero="00";}
        elseif 	($plus <= 999999) {$zero="0";}
        else 	{$zero="";}
        $data['order_code']         = "ORDER-" . $zero . $plus;
        $data['order_person_id']    = $input['order_person_id'];
        $data['order_person_type']  = $input['order_person_type'];
        $data['order_price']        = $order_price;
        $data['order_quantity']     = $order_quantity;
        $data['order_name']         = $input['order_name'];
        $data['order_tel']          = $input['order_tel'];
        $data['order_freight']      = $order_freight;
        $data['order_point']        = $order_point;
        $data['order_type']         = $input['order_type'];
        $data['order_pay_type']     = $input['order_pay_type'];
        $data['order_address']      = isset($input['order_address'])    ? $input['order_address']   : null;
        $data['order_district']     = isset($input['order_district'])   ? $input['order_district']  : null;
        $data['order_amphur']       = isset($input['order_amphur'])     ? $input['order_amphur']    : null;
        $data['order_zipcode']      = isset($input['order_zipcode'])    ? $input['order_zipcode']   : null;
        $data['order_track_name']   = isset($input['order_track_name']) ? $input['order_track_name']: null;
        $data['order_track_id']     = isset($input['order_track_id'])   ? $input['order_track_id']  : null;
        $data['order_detail']       = isset($input['order_detail'])     ? $input['order_detail']    : null;

        $order = Order::create($data);

        // insert order detail
        foreach ($query as $key => $value) {
            // Minus in Stock
            if ($system_stock == 1) {
                Product::find($query[$key]["cart_product_id"])->decrement('product_quantity', $query[$key]["cart_product_quantity"]);
            }
            // Insert order detail
            $order_detail['order_detail_main']      = $order->id;
            $order_detail['order_detail_product']   = $query[$key]['cart_product_id'];
            $order_detail['order_detail_quantity']  = $query[$key]['cart_product_quantity'];
            $order_detail['order_detail_price']     = $query[$key]['product']['product_price'];
            $order_detail['order_detail_point']     = $query[$key]['product']['product_point'];
            $order_detail['order_detail_freight']   = $query[$key]['product']['product_freight'];
            $order_detail['order_detail_etc']       = $query[$key]['product']['product_etc'];
            $order_detail['order_detail_etc2']      = $query[$key]['product']['product_etc2'];
            OrderDetail::create($order_detail);
        }

        // delete cart
        Cart::where([
            ['cart_person_id', $request->order_person_id],
            ['cart_person_type', $request->order_person_type]
        ])
        ->delete();

        // E-wallet
        if ($system_e_wallet == 1) {
            Member::find($input['order_person_id'])->decrement("member_e_wallet", $order_price);
        }

        /*
        0 = แบบธรรมดา (โอนจ่าย)
        1 = ผ่านระบบกระเป๋าเงิน
        2 = ซื้อด่วนโดยแอดมิน
        3 = แอดมินซื้อผ่านระบบกระเป๋าเงิน
        4 = ชำระเงินปลายทาง
        5 = ตัดบัญชีธนาคาร
        */

        // insert pay refer
        if ($input['order_pay_type'] == 0) {
            $request['pay_person_id']   = $input['order_person_id'];
            $request['pay_person_type'] = $input['order_person_type'];
            $request['pay_money']       = $order_price;
            $request['pay_order']       = $order->id;
            $pay_refer = new PayReferController;
            $pay_refer->create($request);

            // return response
            return $this->sendResponse("Success", "บันทึกข้อมูลเรียบร้อย");
        }
        elseif ($input['order_pay_type'] == 1 || $input['order_pay_type'] == 2 || $input['order_pay_type'] == 3) {
            // return response
        }
        elseif ($input['order_pay_type'] == 4) {
            // return response
        }
        elseif ($input['order_pay_type'] == 5) {
            // return response
        }
    }

    // Store
    public function store (Request $request)
    {
        // get data
        $query = new Order;
        $query = $this->filter($query, $request);

        foreach ($query AS $key => $value) {
            $data[$key] = $value;
            if ($data[$key]['pay_slip'] != "") {
                $data[$key]['payRefer']['pay_slip'] = asset(self::$path . $data[$key]['payRefer']['pay_slip']);
            }
        }

        if (!isset($data)) return $this->sendError('ไม่พบข้อมูลในระบบ', "");

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
        $query = Order::find($request->id);

        if ($query->payRefer != "") {
            $query->payRefer->pay_slip = asset(self::$path . $query->payRefer->pay_slip);
        }

        // response
        return $this->sendResponse($query, "ดึงข้อมูลเรียบร้อย");
    }

    // Delete
    public function delete (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'order_status' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if ($request->order_status != 1 && $request->order_status != 2) return $this->sendError("ท่านไม่ได้ส่งรายการยกเลิกสินค้าเข้ามา");

        Order::find($request->id)->update(["order_status" => $request->order_status]);
        PayRefer::where("pay_order", $request->id)->update(["pay_status" => $request->order_status]);

        // response
        return $this->sendResponse("Success", "บันทึกข้อมูลเรียบร้อย");
    }
}
