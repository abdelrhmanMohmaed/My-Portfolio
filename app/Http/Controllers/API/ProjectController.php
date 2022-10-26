<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('id', 'DESC')->get();

        return response()->json([
            'projects' => $projects
        ], 200);
    }
    public function show(Project $project)
    {
        return response()->json([
            'project' => $project
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'link' => 'required',
        ]);

        $project = new Project();
        $project->title = $request->title;
        $project->description = $request->description;
        $project->link = $request->link;

        if ($request->photo) {
            $strpos = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . "." . $ex;
            $img = Image::make($request->photo)->resize(700, 500);
            $upload_path = public_path() . "/img/upload/";
            $image = $upload_path . $project->photo;
            $img->save($upload_path . $name);

            if (File::exists($image)) {
                @unlink($image);
            } else {
                $name = $project->photo;
            }
        }
        $project->photo = $name ?? 'avatarProject.png';
        $project->save();
    }

    public function update(Request $request, Project $project)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'link' => 'required',
        ]);
        $project->title = $request->title;
        $project->description = $request->description;
        $project->link = $request->link;

        if ($project->photo != $request->photo) {
            $strpos = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . "." . $ex;
            $img = Image::make($request->photo)->resize(700, 500);
            $upload_path = public_path() . "/img/upload/";
            $image = $upload_path . $project->photo;
            $img->save($upload_path . $name);

            if (File::exists($image)) {
                if ($project->photo != 'avatarProject.png') {
                    @unlink($image);
                }
            } else {
                $name = $project->photo;
            }
        }

        $project->photo = $name ?? $project->photo;
        $project->save();
    }

    public function delete(Project $project)
    {
        if ($project->photo != 'avatarProject.png') {
            $path =  public_path() . '/img/upload/' . $project->photo;
            File::delete($path);
        }

        return $project->delete();
    }
}
