<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;

class EdcationController extends Controller
{
    public function index()
    {
        $educations = Education::orderBy('id', 'DESC')->get();
        return response()->json([
            'educations' => $educations
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'institution' => 'required',
            'period' => 'required',
            'degree' => 'required',
            'department' => 'required',
        ]);

        $education = new Education();
        $education->institution = $request->institution;
        $education->period = $request->period;
        $education->degree = $request->degree;
        $education->department = $request->department;
        $education->save();
    }

    public function update(Request $request, Education $education)
    {
        $this->validate($request, [
            'institution' => 'required|',
            'period' => 'required',
            'degree' => 'required',
            'department' => 'required',
        ]);
        $education->institution = $request->institution;
        $education->period = $request->period;
        $education->degree = $request->degree;
        $education->department = $request->department;
        $education->save();
    }

    public function delete(Education $education)
    {
        return $education->delete();
    }
}
