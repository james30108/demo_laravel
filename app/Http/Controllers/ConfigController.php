<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\File;
use App\Models\Config;
use App\Models\Commission;
use Validator;

class ConfigController extends BaseController
{
    // Store
    public function store (Request $request)
    {
        // get data
        $query = Config::all();
        // return response
        return $this->sendResponse($query, "บันทึกข้อมูลเรียบร้อย");
    }

    // Update
    public function update (Request $request)
    {
        $config = Config::all();

        foreach ($config as $key => $value) {
            if (isset($request[$value->config_type])) {
                Config::where("config_type", $value->config_type)->update(["config_value" => $request[$value->config_type]]);
            }
        }

        // return response
        return $this->sendResponse("Success", "บันทึกข้อมูลเรียบร้อย");

    }

    // Update commission
    public function commission (Request $request)
    {
        $query = Commission::all();

        foreach ($query as $key => $value) {

            $data               = Commission::find($value->id);
            $commission_point   = $request["commission_point1_" . $value->id];
            $commission_point2  = $request["commission_point2_" . $value->id];

            if (isset($commission_point) && $commission_point > 0) {
                $data->update(["commission_point" => $commission_point]);
            }
            if (isset($commission_point2) && $commission_point2 > 0) {
                $data->update(["commission_point2" => $commission_point2]);
            }
        }

        // return response
        return $this->sendResponse("Success", "บันทึกข้อมูลเรียบร้อย");

    }
}
