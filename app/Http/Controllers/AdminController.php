<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use Image;
use Helpers;

use App\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class AdminController extends Controller
{
    public function login(Request $request)
    {

      if(Auth::user()) {
          return redirect('admin/dashboard');
      }else {
        if($request->isMethod('post')) {
          $data = $request->all();

          if(Auth::attempt(['username' => $data['username'],'password'=>$data['password'], 'level' => 'admin' ])) {

            return redirect('/admin/dashboard');

          }else {

            return redirect()->back()->with('flash_message_error','Invalid username and password');
          }


        }

      }



      return view('admin.login');
    }

    public function dashboard() {
      return view('admin.dashboard');
    }

    public function logout() {
      Session::flush();
      return redirect('/admin')->with('flash_message_success', 'Logged Out Successfully');
    }

    public function profile(Request $request) {

      if($request->isMethod('post')) {
        $data = $request->all();

        // IMAGE

        if($request->hasFile('image')) {
          $image_tmp = Input::file('image');
          if($image_tmp->isValid()) {
            $extension = $image_tmp->getClientOriginalExtension();
            $filename = Helpers::generateRandomString(10).'.'.$extension;
            $image_path = 'images/backend/user/'.$filename;

            Image::make($image_tmp)->resize(300,300)->save($image_path);

          }
        }else {
          $image = User::where(['id' => Auth::user()->id])->select('image')->first();
          $filename = $image->image;
        }

        // WITH UPDATE NEW PASSWORD
        if(!empty($data['cur_password'])) {
          if(empty($data['new_password'])) {
            return redirect()->back()->with('flash_message_error','New Password must not empty');

          }else {
            $checkPassword = User::where(['id' => Auth::user()->id])->first();
            if(Hash::check($data['cur_password'],$checkPassword->password)) {
              $password = bcrypt($data['new_password']);
              User::where(['id' => Auth::user()->id])->update(['name' => $data['name'],
                                                              'username' => $data['username'],
                                                              'email' => $data['email'],
                                                              'password' => $password,
                                                              'image' => $filename
                                                            ]);
            return redirect()->back()->with('flash_message_success','Successfully Updated!');

          }else {
            return redirect()->back()->with('flash_message_error','Incorrect current Password!');

          }

          }
        // WITHOUT NEW PASSWORD
      }else {
        User::where(['id' => Auth::user()->id])->update(['name' => $data['name'],
                                                        'username' => $data['username'],
                                                        'email' => $data['email'],
                                                        'image' => $filename
                                                      ]);

        return redirect()->back()->with('flash_message_success','Successfully Updated!');

      }



      }

      return view('admin.profile');
    }



}
