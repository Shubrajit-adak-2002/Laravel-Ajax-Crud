<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\Builder\Stub;

class CRUDController extends Controller
{
    function submit(Request $req)
    {


        $student = new Student();
        $student->name = $req->name;
        $student->email = $req->email;
        $student->phone = $req->phone;

        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $image_Name = time() . "_" . $image->getClientOriginalName();
            $upload = public_path('upload');

            $image->move($upload, $image_Name);
            $student->image = 'upload/' . $image_Name;
        }

        $student->save();
        return response()->json(['res' => 'success']);
    }

    function display()
    {
        return view('display');
    }

    function getStudents()
    {
        $students = Student::all();
        return response()->json(['students' => $students]);
    }

    function edit_student($id)
    {
        $student = Student::find($id);
        return view('edit', compact('student'));
    }

    function update_student(Request $req)
    {
        $student = Student::find($req->id);
        $student->name = $req->name;
        $student->email = $req->email;
        $student->phone = $req->phone;

        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $image_Name = time() . "_" . $image->getClientOriginalName();
            $upload = public_path('upload');

            $image->move($upload, $image_Name);
            $student->image = 'upload/' . $image_Name;
        }

        $student->save();
        return response()->json(['res' => 'success']);
    }

    public function delete_student($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found',
            ], 404);
        }

        $student->delete();

        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully',
        ]);
    }
}
