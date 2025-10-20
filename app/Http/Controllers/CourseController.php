<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class CourseController extends Controller
{
    
    public function create()
    {
         $courses=Course::all();
    return view('backend.pages.courses',compact('courses'));
    }

    public function store(Request $request)
    {

      $validate=Validator::make($request->all(),[
        'title' => ['required'],
        'code' => ['required'],
        'unit'=>['required'],
      ]);
       
     if($validate->fails()){
      Alert::info('', $validate->errors()->first());
  return back()->withErrors($validate)->withInput();
  } 

  $check=Course::where('title',$request->title)
  ->where('code',$request->code)->where('unit',$request->unit)->exists();

  if($check===true){
    Alert::info('', 'Course already exist');
    return back()->withInput();
  }
      
  Course::create([
    'title'=>$request->title,
    'code'=>$request->code,
    'unit'=>$request->unit
 ]);          

     Alert::success('', 'Course added successfully');
     return back();
    }


    public function show($id){

      $id=substr($id,10);
      $course=Course::findOrFail($id);
      return view('backend.pages.edit-course',['course'=>$course]);
  

    }

    public function edit(Request $request)
    {
           $validate=Validator::make($request->all(),[
            'id'=>['required'],
            'title' => ['required'],
             'code' => ['required'],
             'unit'=>['required'],
           ],[
            'id.required'=>'No course selected'
           ]
         );

         if($validate->fails()){
            Alert::info('', $validate->errors()->first());
            return back()->withErrors($validate)->withInput();
            } 

            $check=Course::where('title',$request->title)
            ->where('code',$request->code)->where('unit',$request->unit)
            ->where('id','!=',$request->id)->exists();
          
            if($check===true){
              Alert::info('', 'Course already exist');
              return back();
            }
        
    Course::where('id',$request->id)->update([
        'title'=>$request->title,
        'code'=>$request->code,
        'unit'=>$request->unit
     ]);     
    Alert::success('', 'Course updated');
     return redirect()->route('course.add');  
        
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
         $course=Course::findOrFail($id);
          $course->delete();
            Alert::success('','Course Deleted');
            return back();
    }

}
