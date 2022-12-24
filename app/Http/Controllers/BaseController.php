<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Models\Config;
use App\Models\Report;

class BaseController extends Controller
{

    public function reportRound ($report_type)
    {
        $report     = Report::where("report_type", $report_type)->orderBy("report_round", "DESC")->first();
        $report_now = isset($report) ? number_format($report['report_round'] + 1) : 1;
        return $report_now;
    }

    public function rule ($request)
    {
    	$query = Config::where('config_type', $request)->first();
        return $query['config_value'];
    }

    public function moneyCalculate ($request)
    {
        $report_fee1 = $this->rule("report_fee1");
        $report_fee2 = $this->rule("report_fee2");
        $report_max  = $this->rule("report_max");

        $vat_point      = ( $request * $report_fee2 ) / 100;
        $pay            = $request - $vat_point - $report_fee1;
        $pay_format     = $pay > 0 ? number_format($pay, 2) : 0;

        // If pay > max
        if ($report_max != 0 && $pay > $report_max) return number_format($report_max, 2);

        return $pay_format;
    }

    public function withdrawCalculate ($request)
    {
        $withdraw_fee1 = $this->rule("withdraw_fee1");
        $withdraw_fee2 = $this->rule("withdraw_fee2");
        $withdraw_max  = $this->rule("withdraw_max");

        $vat_point      = ( $request * $withdraw_fee2 ) / 100;
        $pay            = $request - $vat_point - $withdraw_fee1;
        $pay_format     = $pay > 0 ? number_format($pay, 2) : 0;

        // If pay > max
        if ($withdraw_max != 0 && $pay > $withdraw_max) return number_format($withdraw_max, 2);

        return $pay_format;
    }

    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }

    public function filter($query, $request)
    {
        // filters
        $filters = $request->filters ? $request->filters : null;
        if ($filters) {
            foreach ($filters as $filter) {
                // if value not null
                if ($filter['value']) {
                    if ($filter['type'] == "like") $filter['value'] = '%' . $filter['value'] . '%';
                    $query = $query->where($filter['field'], $filter['type'], $filter['value']);
                }
            }
        }

        // sorting
        $sorters = $request->sorters ? $request->sorters : null;
        if ($sorters) {
            foreach ($sorters as $sorter) {
                if ($sorter["dir"] == "desc" || $sorter["dir"] == "DESC") {
                    $query = $query->orderBy($sorter["field"], 'DESC');
                } else {
                    $query = $query->orderBy($sorter["field"]);
                }
            }
        }

        // paginate and size
        if ($request->size && $request->page) {
            $query = $query->paginate($request->size);
        }

        return $query->get();
    }

}
