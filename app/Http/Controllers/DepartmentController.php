<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class DepartmentController extends Controller
{
    
    public function create()
    {
         $departments=Department::all();
    return view('backend.pages.department',compact('departments'));
    }

    public function store(Request $request)
    {

      $validate=Validator::make($request->all(),[
        'department_name' => ['required']
      ]);
       
     if($validate->fails()){
      Alert::info('', $validate->errors()->first());
  return back()->withErrors($validate)->withInput();
  } 

  $check=Department::where('name',$request->department_name)->exists();

  if($check===true){
    Alert::info('', 'Department already exist');
    return back()->withInput();
  }
      
  Department::create([
    'name'=>$request->department_name,
 ]);          

     Alert::success('', 'Department added successfully');
     return back();
    }


    public function show($id){

      $id=substr($id,10);
      $department=Department::findOrFail($id);
      return view('backend.pages.edit-department',['department'=>$department]);
  

    }

    public function edit(Request $request)
    {
           $validate=Validator::make($request->all(),[
            'id'=>['required'],
            'department_name' => ['required'],
           ],[
            'id.required'=>'No department selected'
           ]
         );

         if($validate->fails()){
            Alert::info('', $validate->errors()->first());
            return back()->withErrors($validate)->withInput();
            } 

            $check=Department::where('name',$request->department_name)->exists();
          
            if($check===true){
              Alert::info('', 'Department already exist');
              return back();
            }
        
    Department::where('id',$request->id)->update([
        'name'=>$request->department_name,
     ]);     
    Alert::success('', 'Department updated');
     return redirect()->route('department.add');  
        
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
         $course=Department::findOrFail($id);
          $course->delete();
            Alert::success('','Department Deleted');
            return back();
    }

}
