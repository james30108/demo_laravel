<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\File;
use App\Models\Position;
use Validator;

class PositionController extends BaseController
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
            'position_point'        => 'required|numeric|unique:system_position,position_point,NULL,id',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        $image          = $request->file('position_image');
        $position_image = time() . "_" . rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path(self::$path), $position_image);


        //  detail
        Position::create([
            "position_name"         => $request->position_name,
            "position_image"        => $position_image,
            "position_match_level"  => $request->position_match_level,
            "position_point"        => $request->position_point
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
            'position_point'        => 'required|numeric|unique:system_position,position_point,' . $request->id . ',id',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        $query = Position::select("position_image")->find($request->id);

        if ($request->hasFile('position_image')) {
            // get data

            // delete old file
            if (File::exists(public_path(self::$path . "/" . $query->position_image))) {
                File::delete(public_path(self::$path . "/" . $query->position_image));
            }
            $image          = $request->file('position_image');
            $position_image = time() . "_" . rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path(self::$path), $position_image);
        }

        //  detail
        Position::find($request->id)->update([
            "position_name"         => $request->position_name,
            "position_image"        => $position_image,
            "position_match_level"  => $request->position_match_level,
            "position_point"        => $request->position_point
        ]);

        // response
        return $this->sendResponse("Success", "บันทึกข้อมูลเรียบร้อย");
    }
}
