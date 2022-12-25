<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Models\Report;
use App\Models\ReportDetail;
use App\Models\Order;
use App\Models\Point;

class ReportController extends Controller
{
    // sale
    public function sale (Request $request)
    {
        $report_round = $this->reportRound (1);

        $sum_price = Order::where([
            ["order_status", ">=", 4],
            ["order_cut_report", 0],
        ])
        ->sum("order_price");

        $orders = Order::where([
            ["order_status", ">=", 4],
            ["order_cut_report", 0],
        ])->get();
        $order_count = $orders->count();

        if ($order_count > 0) {

            $query = Report::create([
                "report_point" => $sum_price,
                "report_count" => $order_count,
                "report_round" => $report_round,
                "report_type" => 1,
            ]);
            $report_id = $query->id;

            // Insert report default's detail
            foreach ($orders as $order) {
                ReportDetail::create([
                    "report_detail_main" => $report_id,
                    "report_detail_link" => $order->id,
                    "report_detail_point" => $order->order_price,
                ]);

                Order::find($order->id)->update(["order_cut_report" => 1]);

            }
            Order::where("order_status", 1)->orWhere("order_status", 2)->update(["order_cut_report" => 1]);
        }

        return $this->sendResponse("Success", "บันทึกข้อมูลเรียบร้อย");
    }

    // commission
    public function commission (Request $request)
    {
        $report_round = $this->reportRound(0);
        $report_min   = $this->rule("report_min");
        $report_style = $this->rule("report_style") ? ["point_type", 1] : ["point_type", "!=", 0];

        // validate
        $validator = Validator::make($request->all(), [
            'report_create' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $query = Point::where([
            $report_style,
            ["point_status", 0],
        ])
        ->select("*", DB::raw('SUM(point_bonus) AS sum_point'))
        ->groupBy('point_member')
        ->having("sum_point", ">=", $report_min)
        ->get();

        $report_point = $query->sum("sum_point");
        $report_count = $query->count();

        $query_2 = Report::create([
            "report_point" => $report_point,
            "report_count" => $report_count,
            "report_round" => $report_round,
            "report_create" => $request->report_create,
        ]);
        $report_id = $query_2->id;


        foreach ($query as $report_detail) {
            ReportDetail::create([
                "report_detail_main" => $report_id,
                "report_detail_link" => $report_detail->point_member,
                "report_detail_point" => $report_detail->sum_point,
            ]);
            Point::where([
                ["point_status", 0],
                ["point_type", 1],
                ["point_member", $report_detail->point_member],
            ])
            ->update(["point_status" => 1]);
        }

        return $this->sendResponse("Success", "บันทึกข้อมูลเรียบร้อย");
    }

    // withdraw
    public function withdraw (Request $request)
    {
        $report_round = $this->reportRound(2);

        // validate
        $validator = Validator::make($request->all(), [
            'report_create' => 'required',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        // get for sum data
        $query = Withdraw::where([
            ["withdraw_cut", 0],
            ["withdraw_status", 1],
        ])
        ->select("*", DB::raw('SUM(withdraw_point) AS sum_point'))
        ->groupBy("withdraw_member")
        ->get();

        $report_point = $query->sum("sum_point");
        $report_count = $query->count();

        if($report_count == 0) return $this->sendError('Error', "ไม่มียอดถอนในรอบนี้");

        // create report
        $query_2 = Report::create([
            "report_point" => $report_point,
            "report_count" => $report_count,
            "report_round" => $report_round,
            "report_create" => $request->report_create,
        ]);
        $report_id = $query_2->id;

        // get for loop
        $query_3 = Withdraw::where([
            ["withdraw_cut", 0],
            ["withdraw_status", 1],
        ])
        ->get();

        foreach ($query_3 as $report_detail) {
            ReportDetail::create([
                "report_detail_main"    => $report_id,
                "report_detail_link"    => $report_detail->withdraw_member,
                "report_detail_point"   => $report_detail->withdraw_point,
            ]);
            Withdraw::find($report_detail->id)->update(["withdraw_cut" => 1]);

        }

        return $this->sendResponse("Success", "บันทึกข้อมูลเรียบร้อย");
    }
}
