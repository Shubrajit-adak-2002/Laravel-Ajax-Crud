<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\Builder\Stub;

class Mycontroller extends Controller
{
    function submit(Request $req){
        $student = new Student();
        $student->name = $req->name;
        $student->email = $req->email;

        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $imageName = time() .'_'. $image->getClientOriginalName();
            $upload = public_path('upload');

            if (!file_exists($upload)) {
                mkdir($upload,0777,true);
            }

            $image->move($upload,$imageName);
            $student->image = 'upload/' . $imageName;
        }

        if ($student->save()) {
            return response()->json(['res'=>'Data Inserted']);
        }
    }

    function display(){
        $students = Student::all();
        return response()->json(['students'=>$students]);
    }

    function edit($id){
        $student = Student::find($id);
        if ($student) {
            return response()->json(['student' => $student]);
        }
    }

    function update(Request $req,$id){
        $student = Student::find($id);

        $student->name = $req->name;
        $student->email = $req->email;

        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $imageName = time() .'_'. $image->getClientOriginalName();
            $upload = public_path('upload');

            if (!file_exists($upload)) {
                mkdir($upload,0777,true);
            }

            $image->move($upload,$imageName);
            $student->image = 'upload/' . $imageName;
        }

        $student->save();
    }

    function delete($id){
        $student = Student::find($id);
        $student->delete();
    }
}
