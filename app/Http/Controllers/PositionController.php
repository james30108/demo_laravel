<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\File;
use App\Models\Position;
use Validator;

class MemberController extends BaseController
{

    public static $path = '/images/positions/';

    // Create
    public function create (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'position_name'         => 'required|unique:system_position,position_name,NULL,id',
            'position_image'        => 'required|image',
            'position_match_level'  => 'required|integer|unique:system_position,position_match_level,NULL,id',
            'position_commission'   => 'required|float|unique:system_position,position_commission,NULL,id',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $position_image = $request->file('position_image');
        $data['product_image_cover']   = time() . "_" . rand() . '.' . $position_image->getClientOriginalExtension();
        $position_image->move(public_path(self::$path), $data['position_image']);


        //  detail
        Position::create([
            "position_name" => $request->position_name,
            "position_image" => $position_image,
            "position_match_level" => $request->position_match_level,
            "position_commission" => $request->position_commission
        ]);

        // response
        return $this->sendResponse("Success", "บันทึกข้อมูลเรียบร้อย");
    }

    // Store
    public function store (Request $request)
    {
        $query = Position::all();

        foreach ($query AS $key => $value) {
            $data[$key] = $value;
            if ($data[$key]['position_image'] != "") {
                $data[$key]['position_image'] = asset(self::$path . $data[$key]['position_image']);
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
            'id'                    => 'required',
            'position_name'         => 'required|unique:system_position,position_name,' . $request->id . ',id',
            'position_image'        => 'required|image',
            'position_match_level'  => 'required|integer|unique:system_position,position_match_level,' . $request->id . ',id',
            'position_commission'   => 'required|float|unique:system_position,position_commission,' . $request->id . ',id',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $query          = Product::select($request->position_image)->find($request->id);
        $position_image = $query->position_image;

        if ($request->hasFile('position_image')) {
            // get data

            // delete old file
            if (File::exists(public_path(self::$path . "/" . $query[$request->position_image]))) {
                File::delete(public_path(self::$path . "/" . $query[$request->position_image]));
            }

            $position_image = $request->file('position_image');
            $data['product_image_cover']   = time() . "_" . rand() . '.' . $position_image->getClientOriginalExtension();
            $position_image->move(public_path(self::$path), $data['position_image']);
        }

        //  detail
        Position::find($request->id)->update([
            "position_name" => $request->position_name,
            "position_image" => $position_image,
            "position_match_level" => $request->position_match_level,
            "position_commission" => $request->position_commission
        ]);

        // response
        return $this->sendResponse("Success", "บันทึกข้อมูลเรียบร้อย");
    }
}
