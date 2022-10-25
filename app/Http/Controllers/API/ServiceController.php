<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('id', 'DESC')->get();

        return response()->json([
            'services' => $services
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:services,name',
            'icon' => 'required',
            'description' => 'required',
        ]);

        $service = new Service();
        $service->name = $request->name;
        $service->icon = $request->icon;
        $service->description = $request->description;
        $service->save();
    }

    public function update(Request $request, Service $service)
    {
        $this->validate($request, [
            'name' => 'required|',
            'icon' => 'required',
            'description' => 'required',
        ]);
        $service->name = $request->name;
        $service->icon = $request->icon;
        $service->description = $request->description;
        $service->save();
    }

    public function delete(Service $service)
    {
        return $service->delete();
    }
}
