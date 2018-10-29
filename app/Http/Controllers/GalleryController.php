<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Image;
use Helpers;

use App\Gallery;


class GalleryController extends Controller
{
    //
    public function add(Request $request) {

      if($request->isMethod('post')) {
        $data = $request->all();
        $gallery = new Gallery;
        $gallery->image_title = $data['title'];

        // print_r($data);die;

        if($request->hasFile('file')) {
          $image_tmp = Input::file('file');
          if($image_tmp->isValid()) {
            $extension = $image_tmp->getClientOriginalExtension();
            $filename = Helpers::generateRandomString(10) . "-" . Helpers::generateRandomString(10). '.' .$extension;
            $large_image_path = 'images/backend/gallery/large/' . $filename;
            $medium_image_path = 'images/backend/gallery/medium/' . $filename;
            $small_image_path = 'images/backend/gallery/small/' . $filename;

            Image::make($image_tmp)->save($large_image_path);
            Image::make($image_tmp)->resize(600,300)->save($medium_image_path);
            Image::make($image_tmp)->resize(300,300)->save($small_image_path);
            $gallery->image_name = $filename;
            $gallery->image_url = $filename;

          }



        }
        $gallery->save();
        return redirect('/admin/gallery/list')->with('flash_message_success','Successfully Added!');



      }


      return view('admin.gallery.add_image');
    }

    public function delete($id = null) {
      $gallery = Gallery::where(['id' => $id])->delete();
      return redirect()->back()->with('flash_message_success','Successfully Deleted!');
    }

    public function list() {
      $galleries = Gallery::get();

      return view('admin.gallery.gallery_list')->with(compact('galleries'));
    }

}
