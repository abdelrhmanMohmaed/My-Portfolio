<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('id', 'DESC')->get();

        return response()->json([
            'testimonials' => $testimonials
        ], 200);
    }
    
    public function show(Testimonial $testimonial)
    {
        return response()->json([
            'testimonial' => $testimonial
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'function' => 'required',
            'testimony' => 'required',
            'rating' => 'required',
        ]);

        $testimonial = new Testimonial();
        $testimonial->name = $request->name;
        $testimonial->function = $request->function;
        $testimonial->testimony = $request->testimony;
        $testimonial->rating = $request->rating;

        if ($request->photo) {
            $strpos = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . "." . $ex;
            $img = Image::make($request->photo)->resize(700, 500);
            $upload_path = public_path() . "/img/upload/";
            $image = $upload_path . $testimonial->photo;
            $img->save($upload_path . $name);

            if (File::exists($image)) {
                @unlink($image);
            } else {
                $name = $testimonial->photo;
            }
        }
        $testimonial->photo = $name ?? 'avatarProject.png';
        $testimonial->save();
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $this->validate($request, [
            'name' => 'required',
            'function' => 'required',
            'testimony' => 'required',
            'rating' => 'required',
        ]);
        $testimonial->name = $request->name;
        $testimonial->function = $request->function;
        $testimonial->testimony = $request->testimony;
        $testimonial->rating = $request->rating;

        if ($testimonial->photo != $request->photo) {
            $strpos = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . "." . $ex;
            $img = Image::make($request->photo)->resize(700, 500);
            $upload_path = public_path() . "/img/upload/";
            $image = $upload_path . $testimonial->photo;
            $img->save($upload_path . $name);

            if (File::exists($image)) {
                if ($testimonial->photo != 'avatarProject.png') {
                    @unlink($image);
                }
            } else {
                $name = $testimonial->photo;
            }
        }

        $testimonial->photo = $name ?? $testimonial->photo;
        $testimonial->save();
    }

    public function delete(Testimonial $testimonial)
    {
        if ($testimonial->photo != 'avatarProject.png') {
            $path =  public_path() . '/img/upload/' . $testimonial->photo;
            File::delete($path);
        }

        return $testimonial->delete();
    }
}
