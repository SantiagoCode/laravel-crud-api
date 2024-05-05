<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\student;
use Illuminate\Support\Facades\Validator;

class studentController extends Controller
{
    public function index()
    {
        $students = student::all();

        if ($students) {
            return response()->json($students, 200);
        } else {
            return response()->json(['message' => 'No records found'], 404);
        }
    }

    public function show($id)
    {
        $student = student::find($id);

        if ($student) {
            return response()->json($student, 200);
        } else {
            return response()->json(['message' => 'No records found'], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:student',
            'phone' => 'required|numeric|min:10|unique:student',
            'address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $student = student::create($request->all());
        return response()->json($student, 201);
    }

    public function update(Request $request, $id)
    {
        $student = student::find($id);

        if ($student) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email|unique:student,email,' . $id,
                'phone' => 'required|numeric|min:10|unique:student,phone,' . $id,
                'address' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $student->update($request->all());
            return response()->json($student, 200);
        } else {
            return response()->json(['message' => 'No records found'], 404);
        }
    }

    public function updatePartial(Request $request, $id)
    {
        $student = student::find($id);

        if($student) {
            $validator = Validator::make($request->all(), [
                'name' => 'string',
                'email' => 'email|unique:student,email,' . $id,
                'phone' => 'numeric|min:10|unique:student,phone,' . $id,
                'address' => 'string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $student->update($request->all());

            return response()->json($student, 200);
        } else {
            return response()->json(['message' => 'No records found'], 404);
        }
    } 

    public function destroy($id)
    {
        $student = student::find($id);

        if ($student) {
            $student->delete();
            return response()->json(['message' => 'Record deleted'], 200);
        } else {
            return response()->json(['message' => 'No records found'], 404);
        }
    }
}
