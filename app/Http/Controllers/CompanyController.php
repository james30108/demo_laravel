<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Point;
use App\Models\Commission;
use App\Models\PayRefer;
use App\Models\Liner;
use App\Http\Controllers\BaseController as BaseController;
use Validator;

class CompanyController extends BaseController
{
    /*
    - จ่ายคะแนนตามลำดับชั้น แบบปกติ
    */
    // order status
    public function order (Request $request)
    {
        $system_com_number  = $this->rule("system_com_number");
        $system_com_ppm     = $this->rule("system_com_ppm");

        // 1st class commission
        $query = Commission::find(1);
        $bonus_class = $query->commission_point;

        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // Query Data
        $order = Order::find($request->id);

        // Update and Create Default Data
        $order->update(["order_status" => 4]);
        PayRefer::where("pay_order", $request->id)->update(["pay_status" => 1]);

        $member = Member::find($order->order_person_id);
        $member->increment("member_point", $order->order_point);
        $member->increment("member_point_month", $order->order_point);
        Point::create([
            "point_member" => $order->order_person_id,
            "point_bonus" => $order->order_point,
            "point_detail" => "Buy for Point",
            "point_order" => $request->id
        ]);
        if ($member->member_point_month >= $system_com_ppm) {
            Liner::where("liner_member", $order->order_person_id)->update(["liner_status" => 1]);
        }

        // commisison to liner
        $array          = array($member->liner->id);
        while ($array) {

            $array_end  = end($array);
            $liner = Liner::find($array_end);

            if      ($liner->liner_direct != 0) { array_push($array, $liner->liner_direct); }
            else    { break; }

        }

        $count = 1; // จำนวนชั้น
        foreach ($array AS $key => $value) {

            if ($key == 0) { continue; }

            $query          = Liner::find($value);
            $bonus          = ( $order->order_point * $bonus_class ) / 100;
            $point_detail   = "Get Referral bonus from " . $query->member->member_code . " and this number is $count";

            // If not baned
            if ($query->member->member_status == 0) {
                if ($count > $system_com_number || $query->liner_status == 0) { continue; }
                $count++;

                Point::create([
                    "point_member" => $query->liner_member,
                    "point_type" => 1,
                    "point_bonus" => $bonus,
                    "point_detail" => $point_detail,
                    "point_order" => $request->id,
                ]);
                Liner::where("liner_member", $query->liner_member)->increment("liner_point", $bonus);
            }
            else { $count++; }

            if ($count > $system_com_number) { break; }
        }

        // response
        return $this->sendResponse("Success", "ยืนยันคำสั่งซื้อเรียบร้อย");
    }
}
