<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function all_students()
    {
        $students = Student::paginate(10);

        return response()->json($students);
    }

    public function save_student()
    {
        $student = new Student();

        $student->name = request()->name;
        $student->email = request()->email;
        $student->phone = request()->phone;

        $student->save();

        return 'OK';
    }

    public function edit_student($id)
    {
        $student = Student::find($id);
        return response()->json($student);
    }

    public function update_student()
    {
        $student = Student::find(request()->id);

        $student->name = request()->name;
        $student->email = request()->email;
        $student->phone = request()->phone;

        $student->update();

        return 'OK';
    }

    public function delete_student($id)
    {
        $student = Student::find($id)->delete();

        return "OK";
    }
}
