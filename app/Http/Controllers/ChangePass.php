<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;

class ChangePass extends Controller
{
    //

    public function ChangePassword(){
        return view('admin.body.change_password');
    }
    public function UpdatePassword(Request $request){
        $validatedata = $request->validate([
            'current_password' => 'required',
            'password'    => 'required|confirmed'
        ]);
        $hashedPassword = Auth::user()->password;
        if(Hash::check($request->current_password,$hashedPassword)){
           $user = User::find(Auth::id());
           $user->password = Hash::make($request->password);
           $user->save();
           Auth::logout();
           return redirect()->route('login')->with('success','Password is changed successfully');
            
        }else{
            return redirect()->back()->with('error','Current Password is invalid');
        }

    }
    public function editProfile(){
           if(Auth::user()){
               $user = User::find(Auth::user()->id);
               if($user){
                   return view('admin.body.update_profile',compact('user'));
               }

           }

    }
    public function UpdateProfile(Request $request){
       /* $validatedata = $request->validate([
            'current_password' => 'required',
            'password'    => 'required|confirmed'
        ]);
        */

        $profile_image=$request->file('user_profile_pic');
        if($profile_image){
            $old_image = $request->old_image;
        $name_gen = hexdec(uniqid());
        $img_ext = strtolower($profile_image->getClientOriginalExtension());
        $img_name = $name_gen.'.'.$img_ext;
        $up_location = 'storage/profile-photos';
        $last_image = 'profile-photos/'.$img_name;
        $profile_image->move($up_location,$img_name);
        unlink('storage/'.$old_image);

        }
           $user = User::find(Auth::user()->id);
           $user->name = $request->name;
           $user->email = $request->email;
           if($profile_image){
           $user->profile_photo_path = $last_image;
           }
           $user->save();
           return redirect()->back()->with('success','Profile updated successfully.');
    }


}
