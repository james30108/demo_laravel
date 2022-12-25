<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Comment;
use Validator;

class CommentController extends BaseController
{
    public static $path = '/images/comments/';

    // create
    public function create (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment_direct'        => 'required',
            'comment_person_id'     => 'required',
            'comment_person_type'   => 'required',
            'comment_type'          => 'required',
            'comment_link'          => 'required',
            'comment_title'         => 'required|max:100',
            'comment_detail'        => 'required',
            'comment_image_cover'   => 'image',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        $comment_image_cover        = "";
        if ($request->hasFile('comment_image_cover')) {
            $image                  = $request->file('comment_image_cover');
            $comment_image_cover    = time() . "_" . rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path(self::$path), $comment_image_cover);
        }

        // insert
        Comment::create([
            "comment_direct"        => $request->comment_direct,
            "comment_person_id"     => $request->comment_person_id,
            "comment_person_type"   => $request->comment_person_type,
            "comment_type"          => $request->comment_type,
            "comment_link"          => $request->comment_link,
            "comment_title"         => $request->comment_title,
            "comment_detail"        => $request->comment_detail,
            "comment_image_cover"   => $comment_image_cover,
        ]);

        // return response
        return $this->sendResponse("Success", "บันทึกข้อมูลเรียบร้อย");

    }
    // Store
    public function store (Request $request)
    {
        // get data
        $query = new Comment;
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
        $query = Comment::find($request->id);

        // response
        return $this->sendResponse($query, "ดึงข้อมูลเรียบร้อย");
    }

    // Status
    public function status (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        // get data
        $query = Comment::find($request->id);
        // check status
        if ($query->comment_status == 1) return $this->sendError('Error.', "ข้อความนี้ถูกอ่านไปแล้ว");
        // update
        $query->update(["comment_status" => 1]);
        // return response
        return $this->sendResponse($query, "บันทึกข้อมูลเรียบร้อย");
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
        $query = Comment::find($request->id)->delete();

        // return response
        return $this->sendResponse($query, "ลบข้อมูลเรียบร้อย");
    }
}
