<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Member;
use App\Models\Liner;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function member_register (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'member_name' => 'required|unique:App\Models\Member,member_name',
            'member_email' => 'required|email|unique:App\Models\Member,member_email',
            'member_code_id' => 'required|unique:App\Models\Member,member_code_id',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // insert system_member
        $input  = $request->all();
        $query  = Member::latest()->first();
        $plus   = isset($query->member_code) ? $query->member_code + 1 : 1;
        if 		($plus <= 9) {$zero="000000";}
        elseif 	($plus <= 99) {$zero="00000";}
        elseif 	($plus <= 999) {$zero="0000";}
        elseif 	($plus <= 9999) {$zero="000";}
        elseif 	($plus <= 99999) {$zero="00";}
        elseif 	($plus <= 999999) {$zero="0";}
        else 	{$zero="";}
        $member['member_code']          = $zero . $plus;
        $member['member_name']          = $input['member_name'];
        $member['member_email']         = $input['member_email'];
        $member['password']             = bcrypt($input['password']);
        $member['member_title_name']    = $input['member_title_name'];
        $member['member_tel']           = $input['member_tel'];
        $member['member_bank']          = $input['member_bank'];
        $member['member_bank_own']      = $input['member_bank_own'];
        $member['member_bank_id']       = $input['member_bank_id'];
        $member['member_code_id']       = $input['member_code_id'];
        $member['member_token_line']    = isset($input['member_token_line']) ? $input['member_token_line'] : null;
        $member = Member::create($member);

        // insert system_liner
        $liner['liner_member']          = $member->id;
        $liner['liner_direct']          = isset($input['liner_direct']) ? $input['liner_direct'] : 0;
        if ($liner['liner_direct'] != 0) {
            $array = array($liner['liner_direct']);
            while ($array) {
                $array_end 	= end($array);
                $query 		= Liner::where("liner_member", $array_end)->first();
                $query->increment("liner_count");
                $query->increment("liner_count_day");
                $query->increment("liner_count_month");

                array_push($array, $query->liner_direct);

                if ($query->liner_direct == 0) { break; }
            }
        }
        Liner::create($liner);

        // address
        $address['address_person_id'] 	= $member->id;
        $address['address_detail'] 	    = isset($input['address_detail']) 	? $input['address_detail'] 		: false;
        $address['address_province'] 	= isset($input['address_province']) ? $input['address_province'] 	: false;
        $address['address_amphure'] 	= isset($input['address_amphure']) 	? $input['address_amphure'] 	: false;
        $address['address_district'] 	= isset($input['address_district']) ? $input['address_district'] 	: false;
        $address['address_zipcode'] 	= isset($input['address_zipcode']) 	? $input['address_zipcode'] 	: false;

        $address_2['address_person_id'] = $member->id;
        $address_2['address_detail'] 	= isset($input['address_detail']) 	? $input['address_detail'] 		: false;
        $address_2['address_province'] 	= isset($input['address_province']) ? $input['address_province'] 	: false;
        $address_2['address_amphure'] 	= isset($input['address_amphure']) 	? $input['address_amphure'] 	: false;
        $address_2['address_district'] 	= isset($input['address_district']) ? $input['address_district'] 	: false;
        $address_2['address_zipcode'] 	= isset($input['address_zipcode']) 	? $input['address_zipcode'] 	: false;
        $address_2['address_type'] 	    = 1;

        if ($address['address_detail'] != false) Address::create($address);
        if ($address_2['address_detail'] != false) Address::create($address_2);

        return $this->sendResponse("Register Success", 'User register successfully.');
    }

    public function member_login (Request $request)
    {
        if(Auth::attempt(['member_email' => $request->member_email, 'password' => $request->password])){
            // check
            $user = Auth::user();
            if ($user->member_status == 1) return $this->sendError('You are Baned.', ['error'=>'You are Baned']);

            // success
            $success['token'] =  $user->createToken('member-token', ['member'])->plainTextToken;
            $success['name'] =  $user->member_name;

            return $this->sendResponse($success, 'Member login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    public function member_me (Request $request)
    {
        $member = Auth::user();
        return [
            'member_id' => $member,
        ];
    }

    public function member_logout (Request $request)
    {
        Auth::user()->tokens("member-token")->delete();
        return $this->sendResponse("Logout", 'Member logout successfully.');
    }

    public function admin_register (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admin_name' => 'required|unique:App\Models\Admin,admin_name',
            'admin_user' => 'required|unique:App\Models\Admin,admin_user',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input              = $request->all();

        // insert system_member
        $admin['admin_user'] = $input['admin_user'];
        $admin['password']   = bcrypt($input['password']);
        $admin['admin_name'] = $input['admin_name'];
        $admin = Admin::create($admin);

        return $this->sendResponse("Register Success", 'Admin register successfully.');
    }

    public function admin_login (Request $request)
    {
        if(Auth::guard('admin')->attempt(['admin_user' => $request->admin_user, 'password' => $request->password])){
            // check
            $user = Auth::guard('admin')->user();
            // success
            $success['token'] =  $user->createToken('admin-token', ["admin"])->plainTextToken;
            $success['name'] =  $user->admin_name;

            return $this->sendResponse($success, 'Admin login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    public function admin_logout (Request $request)
    {
        Auth::user()->tokens("admin-token")->delete();
        return $this->sendResponse("Logout", 'Admin logout successfully.');
    }

    public function admin_me (Request $request)
    {
        $admin = Admin::findOrFail(1)->first();

        return [
            'data' => $admin,
        ];
    }
}
