<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Tracking;
use App\Models\Order;
use App\Models\Contact;

class TrackingController extends Controller
{
    // create
    public function create (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tracking_name'     => 'required|unique:system_tracking,tracking_name,NULL,id',
            'tracking_link'     => 'required|numeric',
            'tracking_weight'   => 'required|numeric',
            'tracking_price'    => 'required|numeric',
            'tracking_max_weight'   => 'required|numeric',
            'tracking_max_price'    => 'required|numeric',
            'tracking_detail'   => 'required|max:200',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        // insert
        $query = Tracking::create([
            "tracking_name"         => $request->tracking_name,
            "tracking_link"         => $request->tracking_link,
            "tracking_weight"       => $request->tracking_weight,
            "tracking_price"        => $request->tracking_price,
            "tracking_max_weight"   => $request->tracking_max_weight,
            "tracking_max_price"    => $request->tracking_max_price,
            "tracking_detail"       => $request->tracking_detail,
        ]);

        // return response
        return $this->sendResponse($query, "บันทึกข้อมูลเรียบร้อย");

    }
    // Store
    public function store (Request $request)
    {
        // get data
        $query = new Tracking;
        $query = $this->filter($query, $request);

        // return response
        return $this->sendResponse($query, "เรียกใช้งานข้อมูลเรียบร้อย");

    }

    // Detail
    public function detail (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        //  detail
        $success = Tracking::find($request->id);

        // response
        return $this->sendResponse($success, "ดึงข้อมูลเรียบร้อย");
    }

    // Update
    public function update (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id'                => 'required',
            'tracking_name'     => 'required|unique:system_tracking,tracking_name,' . $request->id . ',id',
            'tracking_link'     => 'required|numeric',
            'tracking_weight'   => 'required|numeric',
            'tracking_price'    => 'required|numeric',
            'tracking_max_weight'   => 'required|numeric',
            'tracking_max_price'    => 'required|numeric',
            'tracking_detail'   => 'required|max:200',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        // get
        $query = Tracking::find($request->id)->update([
            "tracking_name"         => $request->tracking_name,
            "tracking_link"         => $request->tracking_link,
            "tracking_weight"       => $request->tracking_weight,
            "tracking_price"        => $request->tracking_price,
            "tracking_max_weight"   => $request->tracking_max_weight,
            "tracking_max_price"    => $request->tracking_max_price,
            "tracking_detail"       => $request->tracking_detail,
        ]);

        // return response
        return $this->sendResponse($query, "บันทึกข้อมูลเรียบร้อย");
    }

    // Status
    public function status (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        // update and get
        $query = Tracking::find($request->id);
        $tracking_status = $query->tracking_status == 0 ? 1 : 0;
        $query->update(["tracking_status" => $tracking_status]);
        $success = $query->refresh();

        // return response
        return $this->sendResponse($success, "บันทึกข้อมูลเรียบร้อย");
    }

    // Delete
    public function delete (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        // Delete
        $query = Tracking::find($request->id)->delete();

        // return response
        return $this->sendResponse($query, "ลบข้อมูลเรียบร้อย");
    }

    // Send Tracking to Order
    public function send (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'order_id'          => 'required',
            'order_track_name'  => 'required',
            'order_track_id'    => 'required',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        // Send
        $query = Order::find($request->order_id);
        $query->update([
            "order_track_name"  => $request->order_track_name,
            "order_track_id"    => $request->order_track_id,
        ]);

        Contact::create([
            "contact_person_id"     => $query->order_person_id,
            "contact_person_type"   => 3,
            "contact_name"          => "System Tracking",
            "contact_title"         => "ทำการจัดส่งสินค้าเรียบร้อย",
            "contact_detail"        => $query->id,
        ]);

        // return response
        return $this->sendResponse($query, "ลบข้อมูลเรียบร้อย");
    }
}
