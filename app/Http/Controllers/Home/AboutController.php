<?php

namespace App\Http\Controllers\Home;

use App\Models\About;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AboutController extends Controller
{
     public function AboutPage(){
        $aboutpage = About::find(1);
        return view('admin.about_page.about_page_all',compact('aboutpage'));

     } // End Method 

     public function HomeAbout()
     {
        $aboutpage = About::find(1);
        return view('frontend.about_page',compact('aboutpage'));

     }// End Method 

     public function UpdateAbout(Request $request)
    {
        $about_id = $request->id;

        if ($request->file('about_image')) {
            $image = $request->file('about_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            // Inisialisasi ImageManager (pakai GD driver)
            $manager = new ImageManager(new Driver());

            // Baca dan resize gambar
            $img = $manager->read($image);
            $img->resize(523, 605);

            // Simpan file ke folder public/upload/home_about/
            $path = public_path('upload/home_about/' . $name_gen);
            $img->save($path);

            $save_url = 'upload/home_about/' . $name_gen;

            // Update database
            About::findOrFail($about_id)->update([
                'title'              => $request->title,
                'short_title'        => $request->short_title,
                'short_description'  => $request->short_description,
                'long_description'   => $request->long_description,
                'about_image'        => $save_url,
            ]);

            $notification = [
                'message'    => 'About Page Updated with Image Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->back()->with($notification);
        } else {
            // Update tanpa upload gambar
            About::findOrFail($about_id)->update([
                'title'              => $request->title,
                'short_title'        => $request->short_title,
                'short_description'  => $request->short_description,
                'long_description'   => $request->long_description,
            ]);

            $notification = [
                'message'    => 'About Page Updated without Image Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->back()->with($notification);
        }
    }
}
