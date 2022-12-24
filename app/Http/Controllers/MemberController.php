<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\File;
use App\Models\Member;
use App\Models\Liner;
use App\Models\Address;
use Validator;

class MemberController extends BaseController
{
    public static $path_cover = '/images/member_cover/';
    public static $path_card = '/images/member_card/';
    public static $path_bank = '/images/member_bank/';

    // Store
    public function store (Request $request)
    {
        // get data
        $query = new Member;
        $query = $this->filter($query, $request);

        // return response
        return $this->sendResponse($query, "เรียกใช้งานข้อมูลเรียบร้อย");

    }

    // Detail
    public function detail (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'member_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        //  detail
        $member = Member::where("member_id", $request->member_id)->first();

        // response
        return $this->sendResponse($member, "ดึงข้อมูลเรียบร้อย");
    }

    // Update
    public function updateProfile (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id'                => 'required',
            'member_name'       => 'required|unique:system_member,member_name,' . $request->id . ',id',
            'member_email'      => 'required|unique:system_member,member_email,' . $request->id . ',id',
            'member_code_id'    => 'required|unique:system_member,member_code_id,' . $request->id . ',id',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // update and get
        $member = Member::find($request->id)->first();

        if ($request->hasFile('member_image_cover')) {
            // delete old file
            if(File::exists(public_path(self::$path_cover . "/" . $member->member_image_cover))){
                File::delete(public_path(self::$path_cover . "/" . $member->member_image_cover));
            }
            $member_image_cover = $request->file('member_image_cover');
            $data['member_image_cover'] = "cover_" . time() . "_" . rand() . '.' . $member_image_cover->getClientOriginalExtension();
            $member_image_cover->move(public_path(self::$path_cover), $data['member_image_cover']);
        }
        if ($request->hasFile('member_image_card')) {
            // delete old file
            if(File::exists(public_path(self::$path_card . "/" . $member->member_image_card))){
                File::delete(public_path(self::$path_card . "/" . $member->member_image_card));
            }
            $member_image_card = $request->file('member_image_card');
            $data['member_image_card'] = "card_" . time() . "_" . rand() . '.' . $member_image_card->getClientOriginalExtension();
            $member_image_card->move(public_path(self::$path_card), $data['member_image_card']);
        }

        $data['member_title_name']  = $request->member_title_name;
        $data['member_name']        = $request->member_name;
        $data['member_email']       = $request->member_email;
        $data['member_tel']         = $request->member_tel;
        $data['member_code_id']     = $request->member_code_id;
        $data['member_token_line']  = isset($request->member_token_line) ? $request->member_token_line  : $member->member_token_line;

        $result     = $member->update($data);
        $success    = $member->refresh();

        // return response
        return $this->sendResponse($success, "บันทึกข้อมูลเรียบร้อย");
    }

    // Update Bank
    public function updateBank (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id'                => 'required',
            'member_bank_own'   => 'required|unique:system_member,member_bank_own,' . $request->id . ',id',
            'member_bank_id'    => 'required|unique:system_member,member_bank_id,' . $request->id . ',id',
            'member_image_bank' => 'required|image',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // update and get
        $member = Member::find($request->id)->first();

        if ($request->hasFile('member_image_bank')) {
            // delete old file
            if(File::exists(public_path(self::$path_bank . "/" . $member->member_image_bank))){
                File::delete(public_path(self::$path_bank . "/" . $member->member_image_bank));
            }
            $member_image_bank = $request->file('member_image_bank');
            $data['member_image_bank'] = "bank_" . time() . "_" . rand() . '.' . $member_image_bank->getClientOriginalExtension();
            $member_image_bank->move(public_path(self::$path_bank), $data['member_image_bank']);
        }

        $data['member_bank']        = $request->member_bank;
        $data['member_bank_own']    = $request->member_bank_own;
        $data['member_bank_id']     = $request->member_bank_id;

        $result     = $member->update($data);
        $success    = $member->refresh();

        // return response
        return $this->sendResponse($success, "บันทึกข้อมูลเรียบร้อย");
    }

    // Update Address
    public function updateAddress (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'address_person_id'     => 'required',
            'address_person_type'   => 'required',
            'address_detail'        => 'required',
            'address_district'      => 'required',
            'address_amphure'       => 'required',
            'address_province'      => 'required',
            'address_zipcode'       => 'required',
            'address_type'          => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        Address::updateOrCreate([
            'address_person_id'     => $request->address_person_id,
            'address_person_type'   => $request->address_person_type,
            'address_type'          => $request->address_type,
        ], [
            'address_detail'        => $request->address_detail,
            'address_district'      => $request->address_district,
            'address_amphure'       => $request->address_amphure,
            'address_province'      => $request->address_province,
            'address_zipcode'       => $request->address_zipcode,
        ]);

        if (isset($request->address_type2)) {
            Address::updateOrCreate([
                'address_person_id'     => $request->address_person_id,
                'address_person_type'   => $request->address_person_type,
                'address_type'          => $request->address_type2,
            ], [
                'address_detail'        => $request->address_detail2,
                'address_district'      => $request->address_district2,
                'address_amphure'       => $request->address_amphure2,
                'address_province'      => $request->address_province2,
                'address_zipcode'       => $request->address_zipcode2,
            ]);
        }

        // return response
        return $this->sendResponse("Success", "บันทึกข้อมูลเรียบร้อย");
    }

    // Update Password
    public function updatePassword (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'member_password' => 'required',
            'member_password_new' => 'required|max:20|confirmed',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $member_password = bcrypt($request->member_password_new);
        Member::find($request->id)->update(["password" => $member_password]);

        // return response
        return $this->sendResponse("Success", "บันทึกข้อมูลเรียบร้อย");
    }

    // Setting Status
    public function status (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // get data and set status
        $member = Member::find($request->id);
        $member_status = $member->member_status == 0 ? 1 : 0;
        $result = $member->update(["member_status" => $member_status]);
        $success = $member->refresh();

        // return response
        return $this->sendResponse($success, "แก้ไขสถานะการใช้งานเรียบร้อย");
    }

    // Setting language
    public function language (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // get data and set status
        $member = Member::find($request->id);
        $member_lang = $member->member_lang == 0 ? 1 : 0;
        $result = $member->update(["member_lang" => $member_lang]);
        $success = $member->refresh();

        // return response
        return $this->sendResponse($success, "เปลี่ยนภาษาเรียบร้อย");
    }

    // Setting position
    public function position (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'member_position' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // get data and set status
        $success = Member::find($request->id)->update(["member_position" => $request->member_position]);

        // return response
        return $this->sendResponse($success, "บันทึกข้อมูลเรียบร้อย");
    }

    // Delete
    public function delete (Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'member_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // Delete
        $member = Member::find($request->member_id)->delete();

        // return response
        return $this->sendResponse($member, "ลบข้อมูลเรียบร้อย");
    }
}
