<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperinceController extends Controller
{
    public function index()
    {
        $experiences = Experience::orderBy('id', 'DESC')->get();
        return response()->json([
            'experiences' => $experiences
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'company' => 'required',
            'period' => 'required',
            'position' => 'required',
        ]);

        $experince = new Experience();
        $experince->company = $request->company;
        $experince->period = $request->period;
        $experince->position = $request->position;
        $experince->save();
    }

    public function update(Request $request, Experience $experince)
    {
        $this->validate($request, [
            'company' => 'required',
            'period' => 'required',
            'position' => 'required',
        ]);
        $experince->company = $request->company;
        $experince->period = $request->period;
        $experince->position = $request->position;
        $experince->save();
    }

    public function delete(Experience $experience)
    { 
        return $experience->delete();
    }
}
