<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Member;

class MemberController extends BaseController
{
    // Store
    public function store (Request $request)
    {
        // get data
        $member = Member::all();

        //  response
        return $this->sendResponse($success, $member);

    }

    // Detail
    public function detail (Request $request)
    {
        //  detail
        $member = Member::where("member_id", $id)->first();

        // response
        return $this->sendResponse($success, $member);
    }

    // Update
    public function update (Request $request)
    {
        // update
        Member::where("member_id", 1)
            ->update(["member_title_name" => $request->member_title_name,
            "member_code" => $request->member_title_name,
            "member_tel" => $request->member_tel,
            "member_bank" => $request->member_bank,
            "member_bank_own" => $request->member_bank_own,
            "member_bank_id" => $request->member_bank_id,
            "member_class" => $request->member_class,
            "member_code_id" => $request->member_code_id,
            "member_token_line" => $request->member_token_line
        ]);

        // return response
        return $this->sendResponse($success, "บันทึกข้อมูลเรียบร้อย");
    }

    // Change Password
    public function changePassword (Request $request)
    {
        //
    }

    // Setting Status
    public function active (Request $request)
    {
        //
    }

    // Delete
    public function delete (Request $request)
    {
        // Delete
        Schema::table("system_member", function (Blueprint $table) {
            $table->softDeletes();
        });

        // return response
        return $this->sendResponse($success, "ลบข้อมูลเรียบร้อย");
    }


}
