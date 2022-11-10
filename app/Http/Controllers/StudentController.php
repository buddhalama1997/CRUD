<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
class StudentController extends Controller
{
    public function index()
    {
        return view('student.index');
    }
    public function fetchstudent()
    {
        $students = Student::all();
        return response()->json([
            'students'=>$students,
        ]);
    }
    public function store(Request $request){
        //data validation
        $validator = Validator::make($request->all(),[
            'name'=>'required|max:50',
            'email'=>'required|email|max:50',
            'phone'=>'required|max:10',
            'course'=>'required|max:50',
        ]);
        // error message for validation
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }
        else{
            $student = new Student;
            $student->name = $request -> input('name');
            $student->email = $request -> input('email');
            $student->phone = $request -> input('phone');
            $student->course = $request -> input('course');
            $student->save();
            return response()->json([
                'status'=>200,
                'message'=>'New student Added Successfully',
            ]);
        }
        // 

    }
    public function edit($id)
    {
       $student = Student::find($id);
       if($student){
        return response()->json([
            'status'=>200,
            'student'=>$student,
        ]);
       }
       else{
        return response()->json([
            'status'=>404,
            'message'=>'Student not found',
        ]);
       }
    }
    public function update(Request $request, $id)
    {
        //data validation
        $validator = Validator::make($request->all(),[
            'name'=>'required|max:50',
            'email'=>'required|email|max:50',
            'phone'=>'required|max:10',
            'course'=>'required|max:50',
        ]);
        // error message for validation
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }
        else{
            $student = Student::find($id);
            if($student){
                $student->name = $request -> input('name');
                $student->email = $request -> input('email');
                $student->phone = $request -> input('phone');
                $student->course = $request -> input('course');
                $student->save();
                return response()->json([
                'status'=>200,
                'message'=>'Student Updated Successfully',
            ]);
            }
            else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Student not found',
                ]);
               }
            
        }
    }
    public function destroy($id)
    {
        $student = Student::find($id);
        $student->delete();
        return response()->json([
            'status'=>200,
            'message'=>'Student deleted Successfully',
        ]);
    }
}
