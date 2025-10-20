<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Level;
use App\Models\Semester;
use App\Models\Session;
use App\Models\StudentCourse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class StudentCourseController extends Controller
{
    
    public function create()
    {
    $courses=Course::all();
    $semesters=Semester::all();
    $student_id=auth()->user()->id;
    $level_id=auth()->user()->profile->level_id;
    $student=User::find($student_id);
    $current_session=Session::where('active','yes')->first();
     $student_courses=StudentCourse::where('user_id',$student_id)
     ->where('session_id',$current_session->id)
     ->where('level_id',$level_id)->orderby('semester_id','ASC')->get();
    return view('backend.pages.register-course',compact('courses','semesters','student_courses'));
    }

    public function store(Request $request){

        $validate=Validator::make($request->all(),[
            'course' => ['required'],
            'semester' => ['required']
          ]);

          if($validate->fails()){
            Alert::info('', $validate->errors()->first());
        return back()->withErrors($validate)->withInput();
        } 

        $student_id=auth()->user()->id;
        $level_id=auth()->user()->profile->level_id;
        $current_session=Session::where('active','yes')->first();

        $check=StudentCourse::where('user_id',$student_id)
          ->where('session_id',$current_session->id)
          ->where('semester_id',$request->semester)
          ->where('level_id',$level_id)
          ->where('course_id',$request->course)->exists();

          if($check===true){
            Alert::info('', 'Course already registered');
            return back();
          }

        StudentCourse::create([
            'user_id'=>$student_id,
            'level_id'=>$level_id,
            'session_id'=>$current_session->id,
            'semester_id'=>$request->semester,
            'course_id'=>$request->course
        ]);

        Alert::info('', 'Course registered');
        return back();

    }

    public function destroy(Request $request){

        $validate=Validator::make($request->all(),[
            'id'=>['required'],
            ]
            );
  
            if($validate->fails()){
               Alert::info('', $validate->errors()->first());
           return back()->withErrors($validate)->withInput();
           } 
           $id=substr($request->id,10);
           $course=StudentCourse::findOrFail($id);
            $course->delete();
              Alert::success('','Course Deleted');
              return back();
      }
  

      public function check_result(Request $request){

        $sessions=Session::all();
        $semesters=Semester::all();
        $levels=Level::all();
        $student_id=auth()->user()->id;
        $current_level=auth()->user()->profile->level_id;
        if(isset($request->level) && isset($request->session) && isset($request->semester)){
          $registered_student_courses=StudentCourse::where('status','release')
          ->where('session_id',$request->session)->where('semester_id',$request->semester)
          ->where('level_id',$request->level)->where('user_id',$student_id)->get();
          $seleted_semester=Semester::find($request->semester);
          $seleted_session=Session::find($request->session);
          $seleted_level=Level::find($request->level);
        }
        else{
          $registered_student_courses=[];
          $seleted_semester=null;
          $seleted_session=null;
          $seleted_level=null;
        }
       
        return view('backend.pages.check-result',compact('sessions','semesters','levels','registered_student_courses',
        'seleted_semester','seleted_session','seleted_level','current_level'));


      }

}
