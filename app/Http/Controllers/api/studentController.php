<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\student;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class studentController extends Controller
{
    public function index()
    {
        $students = student::all();

        if ($students) {
            return response()->json($students, Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'No records found'], Response::HTTP_NOT_FOUND);
        }
    }

    public function show($id)
    {
        $student = student::find($id);

        if ($student) {
            return response()->json($student, Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'No records found'], Response::HTTP_NOT_FOUND);
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
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $student = student::create($request->all());
        return response()->json($student, Response::HTTP_CREATED);
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
                return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
            }

            $student->update($request->all());
            return response()->json($student, Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'No records found'], Response::HTTP_NOT_FOUND);
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
                return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
            }

            $student->update($request->all());

            return response()->json($student, Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'No records found'], Response::HTTP_NOT_FOUND);
        }
    } 

    public function destroy($id)
    {
        $student = student::find($id);

        if ($student) {
            $student->delete();
            return response()->json(['message' => 'Record deleted'], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'No records found'], Response::HTTP_NOT_FOUND);
        }
    }
}
