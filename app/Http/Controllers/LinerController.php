<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Liner;
use Validator;

class LinerController extends BaseController
{
    // Update direct code
    public function direct (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id'           => 'required',
            'liner_direct' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if ($request->id == $request->liner_direct) {
            return $this->sendError('Error', "คุณใส่รหัสตัวเอง");
        }

        //  Update
        $liner = Liner::find($request->id)->update(["liner_direct" => $request->liner_direct]);

        // response
        return $this->sendResponse($liner, "บันทึกข้อมูลเรียบร้อย");

    }

    // Update type
    public function type (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id'         => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        //  Update
        $liner = Liner::find($request->id);
        $liner_type = $liner->liner_type == 0 ? 1 : 0 ;
        $liner->update(["liner_type" => $liner_type]);

        // response
        return $this->sendResponse($liner, "บันทึกข้อมูลเรียบร้อย");

    }

    // Update status
    public function status (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        //  Update
        $liner = Liner::find($request->id);
        $liner_status = $liner->liner_status == 0 ? 1 : 0 ;
        $liner->update(["liner_status" => $liner_status]);

        // response
        return $this->sendResponse($liner, "บันทึกข้อมูลเรียบร้อย");

    }
}
