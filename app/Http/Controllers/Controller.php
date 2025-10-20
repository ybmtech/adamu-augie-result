<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Semester;
use App\Models\Session;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
        $this->middleware(['auth','role:examiner'])->only(['settings','update_app_settings']);
    }
       /**
     * Display the user dashboard view.
     *
     * @return \Illuminate\View\View
     */
    public function create(){
      return view('backend.pages.index');
    }
    
  

   public function settings(){
    $sessions=Session::all();
    $semesters=Semester::all();
    $courses=Course::all();
    return view('backend.pages.settings',compact('sessions','semesters','courses'));
   }

   public function update_app_settings(Request $request){

    $validate=Validator::make($request->all(),[
      'semester'=>['required'],
      'session'=>['required'],
  ]
   );
   
   if($validate->fails()){
      Alert::info('', $validate->errors()->first());
      return back()->withErrors($validate)->withInput();
      } 
       
        //update session
      Session::where('active','yes')->update(['active'=>'no']);
      Session::where('id',$request->session)->update(['active'=>'yes']);

      //update semester
     Semester::where('active','yes')->update(['active'=>'no']);
     Semester::where('id',$request->semester)->update(['active'=>'yes']);
      Alert::success('', 'App setting updated successfully');
      return back();
   }



}
