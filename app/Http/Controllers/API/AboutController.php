<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class AboutController extends Controller
{
    public function edit()
    {
        return About::orderBy('id', 'DESC')->first();
    }
    public function update(Request $request, About $about)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
        ]);
        if ($about->photo != $request->photo) {
            $strpos = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . "." . $ex;
            $img = Image::make($request->photo)->resize(700, 500);
            $upload_path = public_path() . "/img/upload/";
            $image = $upload_path . $about->photo;
            $img->save($upload_path . $name);

            if (File::exists($image)) {
                @unlink($image);
            } else {
                $name = $about->photo;
            }
        }
        if ($about->cv != $request->cv) {
            $strpos = strpos($request->cv, ';');
            $sub = substr($request->cv, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $nameCv = time() . "." . $ex;
            $img = Image::make($request->cv)->resize(700, 500);
            $upload_path = public_path() . "/img/upload/";
            $image = $upload_path . $about->cv;
            $img->save($upload_path . $nameCv);

            if (File::exists($image)) {
                @unlink($image);
            } else {
                $nameCv = $about->cv;
            }
        }

        $about->name = $request->name;
        $about->email = $request->email;
        $about->phone = $request->phone;
        $about->address = $request->address;
        $about->description = $request->description;
        $about->tagline = $request->tagline;
        $about->photo = $name;
        $about->cv = $nameCv;
        $about->save();
    }
}
