<?php

namespace App\Http\Controllers\Home;

use App\Models\About;
use App\Models\MultiImage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

    public function AboutMultiImage(){

        return view('admin.about_page.multimage');

     }// End Method

    public function StoreMultiImage(Request $request)
    {
        $images = $request->file('multi_image');

        if ($images && is_array($images)) {

            // Inisialisasi ImageManager (pakai GD)
            $manager = new ImageManager(new Driver());

            foreach ($images as $multi_image) {

                $name_gen = hexdec(uniqid()) . '.' . $multi_image->getClientOriginalExtension();

                // Baca dan resize gambar
                $img = $manager->read($multi_image);
                $img->resize(220, 220);

                // Simpan ke folder public/upload/multi/
                $path = public_path('upload/multi/' . $name_gen);
                $img->save($path);

                $save_url = 'upload/multi/' . $name_gen;

                // Simpan ke database
                MultiImage::insert([
                    'multi_image' => $save_url,
                    'created_at'  => Carbon::now(),
                ]);
            }

            $notification = [
                'message'    => 'Multi Image Inserted Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('all.multi.image')->with($notification);
        } else {
            return redirect()->back()->with([
                'message'    => 'No images selected!',
                'alert-type' => 'error',
            ]);
        }
    }

    public function AllMultiImage(){

        $allMultiImage = MultiImage::all();
        return view('admin.about_page.all_multiimage',compact('allMultiImage'));

     }// End Method 

     public function EditMultiImage($id){

        $multiImage = MultiImage::findOrFail($id);
        return view('admin.about_page.edit_multi_image',compact('multiImage'));

     }// End Method 

     public function UpdateMultiImage(Request $request)
    {
        $multi_image_id = $request->id;

        if ($request->file('multi_image')) {
            $image = $request->file('multi_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            // Inisialisasi ImageManager (pakai GD)
            $manager = new ImageManager(new Driver());

            // Baca dan resize gambar
            $img = $manager->read($image);
            $img->resize(220, 220);

            // Simpan ke folder public/upload/multi/
            $path = public_path('upload/multi/' . $name_gen);
            $img->save($path);

            $save_url = 'upload/multi/' . $name_gen;

            // Update database
            MultiImage::findOrFail($multi_image_id)->update([
                'multi_image' => $save_url,
                'updated_at'  => Carbon::now(),
            ]);

            $notification = [
                'message'    => 'Multi Image Updated Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('all.multi.image')->with($notification);
        } else {
            return redirect()->route('all.multi.image')->with([
                'message'    => 'No image selected!',
                'alert-type' => 'error',
            ]);
        }
    }

    public function DeleteMultiImage($id){

        $multi = MultiImage::findOrFail($id);
        $img = $multi->multi_image;
        unlink($img);

        MultiImage::findOrFail($id)->delete();

         $notification = array(
            'message' => 'Multi Image Deleted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

     }// End Method 
}
