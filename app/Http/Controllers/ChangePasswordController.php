<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use Redirect;

class ChangePasswordController extends Controller {
    public function showChangePasswordForm() {
        if (Auth::user()) {
            return view('users.change_password');
        }else {
            return redirect('home');
        }
    }

    public function changePassword(Request $request){
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
//            return Redirect::back()->withErrors(["current-password" => $request->get('current-password')]);
            return Redirect::back()->withErrors(["current-password" => "Your current password does not matches with the password you provided. Please try again."]);
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return Redirect::back()->withErrors(["new-password" => "New Password cannot be same as your current password. Please choose a different password."]);
        }
//
        if(strcmp($request->get('new-password'), $request->get('password-confirmation')) != 0){
            //Current password and new password are same
            return Redirect::back()->withErrors(["new-password" => "Password confirmation must be same as your new password. Please try again."]);
        }
//

//
//        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
//        return Redirect::back()->withErrors(["new-password" => "Password changed successfully !"]);
        return Redirect::back()->with("success","Password changed successfully !");
//        return redirect()->back()->with("success","Password changed successfully !");
    }
}
