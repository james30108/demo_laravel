<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\File;
use App\Models\PayRefer;
use Validator;

class PayReferController extends BaseController
{
    public static $path = '/images/pay/';

    // Create
    public function create (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pay_person_id' => 'required',
            'pay_person_type' => 'required',
            'pay_name' => 'required',
            'pay_bank' => 'required',
            'pay_type' => 'required',
            'pay_money' => 'required|integer',
            'pay_slip' => 'required|image',
            'pay_create' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // insert
        $input  = $request->all();
        $data['pay_person_id']      = $input['pay_person_id'];
        $data['pay_person_type']    = $input['pay_person_type'];
        $data['pay_name']           = $input['pay_name'];
        $data['pay_bank']           = $input['pay_bank'];
        $data['pay_type']           = $input['pay_type'];
        $data['pay_money']          = $input['pay_money'];
        $data['pay_create']         = $input['pay_create'];
        $data['pay_title']          = isset($input['pay_title'])    ? $input['pay_title']   : null;
        $data['pay_order']          = isset($input['pay_order'])    ? $input['pay_order']   : 0;
        $data['pay_detail']         = isset($input['pay_detail'])   ? $input['pay_detail']  : null;

        if ($request->hasFile('pay_slip')) {
            $image = $request->file('pay_slip');
            $data['pay_slip']   = time() . "_" . rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path(self::$path), $data['pay_slip']);
        }

        $query = PayRefer::create($data);

        // return response
        return $this->sendResponse($query, "บันทึกข้อมูลเรียบร้อย");
    }

    // Store
    public function store (Request $request)
    {
        // get data
        $query = new PayRefer;
        $query = $this->filter($query, $request);

        foreach ($query AS $key => $value) {
            $data[$key] = $value;
            if ($data[$key]['pay_slip'] != "") {
                $data[$key]['pay_slip'] = asset(self::$path . $data[$key]['pay_slip']);
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
        $query = PayRefer::find($request->id);

        if ($query['pay_slip'] != "") {
            $query['pay_slip'] = asset(self::$path . $query['pay_slip']);
        }

        // response
        return $this->sendResponse($query, "ดึงข้อมูลเรียบร้อย");
    }

    // Status
    public function status (Request $request)
    {

        // validate
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'pay_status' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // update and get
        $query = PayRefer::find($request->id);
        $query->update(["pay_status" => $request->pay_status]);
        $success = $query->refresh();

        // return response
        return $this->sendResponse($success, "บันทึกข้อมูลเรียบร้อย");
    }
}
