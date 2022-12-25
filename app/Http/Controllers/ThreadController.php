<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Validator;
use App\Models\Thread;
use App\Models\ThreadType;

class ThreadController extends Controller
{
    public static $path = '/images/threads/';

    // Create
    public function create (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'thread_title'      => 'required|max:100|unique:system_thread,thread_title,NULL,id',
            'thread_intro'      => 'required|max:150',
            'thread_detail'     => 'required',
            'thread_type'       => 'required',
            'thread_image_cover' => 'required|image',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        // insert
        $data['thread_title']   = $request->thread_title;
        $data['thread_intro']   = $request->thread_intro;
        $data['thread_detail']  = $request->thread_detail;
        $data['thread_type']    = $request->thread_type;

        if ($request->hasFile('thread_image_cover')) {
            $image                      = $request->file('thread_image_cover');
            $data['thread_image_cover'] = time() . "_" . rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path(self::$path), $data['thread_image_cover']);
        }
        if ($request->hasFile('thread_image')) {
            $i = 0;
            foreach ($request->file('thread_image') as $image) {
                $i++;
                $data['thread_image_' . $i] = time() . "_" . rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path(self::$path), $data['thread_image_' . $i]);
                if ($i == 5) break;
            }
        }

        // create and update
        $query = Thread::create($data);
        ThreadType::find($request->thread_type)->increment("thread_type_count");

        // return response
        return $this->sendResponse($query, "บันทึกข้อมูลเรียบร้อย");

    }

    // Store
    public function store (Request $request)
    {
        // get data
        $query = new Thread;
        $query = $this->filter($query, $request);

        foreach ($query AS $key => $value) {
            $data[$key] = $value;
            if ($data[$key]['thread_image_cover'] != "") {
                $data[$key]['thread_image_cover'] = asset(self::$path . $data[$key]['thread_image_cover']);
            }
            for ($i=1; $i <= 5; $i++) {
                if ($data[$key]['thread_image_' . $i] != "") {
                    $data[$key]['thread_image_' . $i] = asset(self::$path . $data[$key]['thread_image_' . $i]);
                }
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

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        //  detail
        $query = Thread::find($request->id);

        if ($query['thread_image_cover'] != "") {
            $query['thread_image_cover'] = asset(self::$path . $query['thread_image_cover']);
        }
        for ($i=1; $i <= 5; $i++) {
            if ($query['thread_image_' . $i] != "") {
                $query['thread_image_' . $i] = asset(self::$path . $query['thread_image_' . $i]);
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
            'id'            => 'required',
            'thread_title'  => 'required|max:100|unique:system_thread,thread_title,' . $request->id . ',id',
            'thread_intro'  => 'required|max:150',
            'thread_detail' => 'required',
            'thread_type'   => 'required',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        // update and get
        $query = Thread::find($request->id);

        // If change thread type
        if ($query->thread_type != $request->thread_type) {
            ThreadType::find($query->thread_type)->decrement("thread_type_count");
            ThreadType::find($request->thread_type)->increment("thread_type_count");
        }

        $query->update([
            "thread_title"  => $request->thread_title,
            "thread_intro"  => $request->thread_intro,
            "thread_detail" => $request->thread_detail,
            "thread_type"   => $request->thread_type,
        ]);
        $success = $query->refresh();

        // return response
        return $this->sendResponse($success, "บันทึกข้อมูลเรียบร้อย");
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
        $query = Thread::find($request->id);
        $thread_status = $query->thread_status == 0 ? 1 : 0;
        $query->update(["thread_status" => $thread_status]);
        $success = $query->refresh();

        // return response
        return $this->sendResponse($success, "บันทึกข้อมูลเรียบร้อย");
    }

    // Highlight
    public function highlight (Request $request)
    {

        // validate
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        // update and get
        $query = Thread::find($request->id);
        $thread_highlight = $query->thread_highlight == 0 ? 1 : 0;
        $query->update(["thread_highlight" => $thread_highlight]);
        $success = $query->refresh();

        // return response
        return $this->sendResponse($success, "บันทึกข้อมูลเรียบร้อย");
    }

    // Delete Image
    public function deleteImage (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id'                => 'required',
            'thread_image_name' => 'required'
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        // get data
        $query = Thread::select($request->thread_image_name)->find($request->id);

        // delete old file
        if(File::exists(public_path(self::$path . "/" . $query[$request->thread_image_name]))){
            File::delete(public_path(self::$path . "/" . $query[$request->thread_image_name]));
        }

        // update
        $query = Thread::find($request->id)->update([$request->thread_image_name => null]);

        // return response
        return $this->sendResponse($query, "บันทึกข้อมูลเรียบร้อย");
    }

    // Edit Image
    public function updateImage (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id'                => 'required',
            'thread_image_name' => 'required',
            'thread_image_file' => 'required|image'
        ]);

        if($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        // get data
        $query = Thread::select($request->thread_image_name)->find($request->id);

        // delete old file
        if(File::exists(public_path(self::$path . "/" . $query[$request->thread_image_name]))){
            File::delete(public_path(self::$path . "/" . $query[$request->thread_image_name]));
        }

        // update
        if ($request->hasFile('thread_image_file')) {
            $image = $request->file('thread_image_file');
            $data['thread_image_file'] = time() . "_" . rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path(self::$path), $data['thread_image_file']);
        }
        $query = Thread::find($request->id)->update([$request->thread_image_name => $data['thread_image_file']]);

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
        $query = Thread::find($request->id);
        ThreadType::find($query->thread_type)->decrement("thread_type_count");

        if(File::exists(public_path(self::$path . "/" . $query->thread_image_cover))){
            File::delete(public_path(self::$path . "/" . $query->thread_image_cover));
        }
        if(File::exists(public_path(self::$path . "/" . $query->thread_image_1))){
            File::delete(public_path(self::$path . "/" . $query->thread_image_1));
        }
        if(File::exists(public_path(self::$path . "/" . $query->thread_image_2))){
            File::delete(public_path(self::$path . "/" . $query->thread_image_2));
        }
        if(File::exists(public_path(self::$path . "/" . $query->thread_image_3))){
            File::delete(public_path(self::$path . "/" . $query->thread_image_3));
        }
        if(File::exists(public_path(self::$path . "/" . $query->thread_image_4))){
            File::delete(public_path(self::$path . "/" . $query->thread_image_4));
        }
        if(File::exists(public_path(self::$path . "/" . $query->thread_image_5))){
            File::delete(public_path(self::$path . "/" . $query->thread_image_5));
        }

        $query->delete();

        // return response
        return $this->sendResponse("Success", "บันทึกข้อมูลเรียบร้อย");
    }
}
