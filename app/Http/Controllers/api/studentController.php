<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\student;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class studentController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:student',
            'phone' => 'required|numeric|min:10|unique:student',
            'address' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => bcrypt($request->password),
        ]);

        return response()->json($student, Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
            }

            $student = student::where('email', $request->email)->first();

            if ($student && \Hash::check($request->password, $student->password)) {
                $token = $student->createToken('auth_token')->plainTextToken;
                $cookie = cookie('jwt', $token, 60 * 24);
                return response()->json(['message' => 'Login successful'], Response::HTTP_OK)->withCookie($cookie);
            } else {
                return response()->json(['message' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

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
