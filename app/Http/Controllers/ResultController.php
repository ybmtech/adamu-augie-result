<?php

namespace App\Http\Controllers;

use App\Jobs\ResultJob;
use App\Models\Course;
use App\Models\Semester;
use App\Models\Session;
use App\Models\StudentCourse;
use App\Models\User;
use App\Notifications\ResultNotification;
use App\Trait\CloudSms;
use Exception;
use Illuminate\Bus\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ResultController extends Controller
{
   use CloudSms;
  private $rows = [];

  public function __construct()
  {
    $this->middleware(['auth','role:examiner']);
  }

  public function add_view(Request $request)
  {
    $sessions=Session::all();
    $semesters=Semester::all();
    $courses=Course::all();
    if(isset($request->course) && isset($request->session) && isset($request->semester)){
      $registered_student_courses=StudentCourse::where('course_id',$request->course)
      ->where('session_id',$request->session)->where('semester_id',$request->semester)->get();
      $seleted_semester=Semester::find($request->semester);
      $seleted_session=Session::find($request->session);
      $seleted_course=Course::find($request->course);
    }
    else{
      $registered_student_courses=[];
      $seleted_semester=null;
      $seleted_session=null;
      $seleted_course=null;
    }
   
    return view('backend.pages.add-result',compact('sessions','semesters','courses','registered_student_courses',
    'seleted_semester','seleted_session','seleted_course'));
    
  }

  public function add(Request $request){

    $student_register_course_id=$request->id;
    $student_register_course_score=$request->score;
    
    collect($student_register_course_id)->each(function($id,$key) use($student_register_course_score) {
      $result=StudentCourse::find($id);
      $result->score=$student_register_course_score[$key];
      $result->grade=$this->grade($student_register_course_score[$key]);
      if($student_register_course_score[$key]!==null && $result->status=="not added"){
        $result->status="pending";
       }
       $result->save();
    });

    Alert::success('','Results Score Added');
    return redirect()->route('result.add.view');

  }

  public function edit(Request $request){
    $validate=Validator::make($request->all(),[
      'id'=>['required'],
      'score'=>['required'],
   ],
   [
       'id.required'=>'select result to delete'
     ]
      );

      if($validate->fails()){
         Alert::info('', $validate->errors()->first());
     return back()->withErrors($validate)->withInput();
     } 
  
     $id=substr($request->id,10);
     $result=StudentCourse::findOrFail($id);
     $result->score=$request->score;
     $result->grade=$this->grade($request->score);

     if($result->status=="not added" && $request->score!==null){
      $result->status="pending";
     }
     $result->save();

     Alert::success('','Done');
     return back(); 
  }

  public function changeStatus(Request $request){
    $validate=Validator::make($request->all(),[
       'id'=>['required'],
       'status'=>['required'],
    ],
    [
        'id.required'=>'select result to delete'
      ]
       );

       if($validate->fails()){
          Alert::info('', $validate->errors()->first());
      return back()->withErrors($validate)->withInput();
      } 
      $id=substr($request->id,10);
      $result=StudentCourse::findOrFail($id);

      $student=$result->user;
      if($request->status=='release') {
      $status="pending";
      $result->status=$status;
      $result->save();
      }
      else{
        $status="release";
      $result->status=$status;
      $result->save();
      $student->notify(new ResultNotification($student,$result->course_id,$result->semester_id,$result->session_id)); 
        
        $semester_name=Semester::find($result->semester_id)->name;
        $session_name=Session::find($result->session_id)->name;
         $course_code=$result->course->code;
         $result_score=$result->score;
$message = <<<MESSAGE
Dear $student->name,
Your  $course_code result for $session_name $semester_name semester score is $result_score 
From AACOE
MESSAGE;
    
          //send sms
        $this->sendSms($message,$student->profile->phone);
        $result->is_result_sent=1;
        $result->save();
      }

      Alert::success('','Done');
      return back(); 
  
  }

  public function destroy(Request $request){

    $validate=Validator::make($request->all(),[
        'id'=>['required'],
    ],[
      'id.required'=>'select result to delete'
    ]
        );

        if($validate->fails()){
           Alert::info('', $validate->errors()->first());
       return back()->withErrors($validate)->withInput();
       } 
       $id=substr($request->id,10);
       $result=StudentCourse::findOrFail($id);
      $result->score=null;
      $result->grade=null;
      $result->status="not added";
      $result->save();

          Alert::success('','Result Deleted');
          return back(); 
       
       
  }

  public function upload()
  {
    $sessions=Session::all();
    $semesters=Semester::all();
    $courses=Course::all();
    return view('backend.pages.upload-result',compact('sessions','semesters','courses'));
    
  }

  public function process_upload(Request $request)
  {
   
    $validate=Validator::make($request->all(),[
      'session'=>['required'],
      'course' => ['required'],
      'semester' => ['required'],
      'result'=>['required','file','mimes:csv,txt'] 
  ]
      );

      if($validate->fails()){
         Alert::info('', $validate->errors()->first());
     return back()->withErrors($validate)->withInput();
     } 

     if ($request->hasFile('result')) {

      $path = $request->file('result')->getPathname();
      $records = array_map('str_getcsv', file($path));
  
      if (! count($records) > 0) {
  
       toast('Csv file uploaded is empty','info','top-right')->showCloseButton(); 
      }
  
      array_shift($records);
      
      foreach ($records as $record) {
        
          // Decode unwanted html entities
          $record =  array_map("html_entity_decode", $record);
  
          // Get the clean data
          $this->rows[] = $this->clear_encoding_str($record);
      }

      foreach($this->rows as $data){

         $admission_no=trim($data[1]);
         $score=trim($data[2]);

         
            
        $student=User::where('username',$admission_no)->first();

         $id=$student->id;
       
         StudentCourse::where('course_id',$request->course)
      ->where('session_id',$request->session)->where('semester_id',$request->semester)
      ->where('user_id',$id)->update([
        'score'=>$score,
        'grade'=>$this->grade($score),
        'status'=>'pending'
      ]);
    
      }
     
      Alert::success('','Result uploaded');
      return back();

     }

     Alert::info('','Please, upload csv file');
     return back();
    
  }


  
  private function clear_encoding_str($value)
  {
      if (is_array($value)) {
          $clean = [];
          foreach ($value as $key => $val) {
              $clean[$key] = mb_convert_encoding($val, 'UTF-8', 'UTF-8');
          }
          return $clean;
      }
      return mb_convert_encoding($value, 'UTF-8', 'UTF-8');
  }
  
  public function manage(Request $request)
  {
    $sessions=Session::all();
    $semesters=Semester::all();
    $courses=Course::all();
    if(isset($request->course) && isset($request->session) && isset($request->semester)){
      $registered_student_courses=StudentCourse::where('course_id',$request->course)
      ->where('session_id',$request->session)->where('semester_id',$request->semester)->get();
      $seleted_semester=Semester::find($request->semester);
      $seleted_session=Session::find($request->session);
      $seleted_course=Course::find($request->course);
    }
    else{
      $registered_student_courses=[];
      $seleted_semester=null;
      $seleted_session=null;
      $seleted_course=null;
    }
   
    return view('backend.pages.manage-result',compact('sessions','semesters','courses','registered_student_courses',
    'seleted_semester','seleted_session','seleted_course'));

  }

  public function general_status(Request $request){
    $validate=Validator::make($request->all(),[
      'semester'=>['required'],
      'session'=>['required'],
      'course'=>['required'],
      'status'=>['required']
   ]
      );

      if($validate->fails()){
         Alert::info('', $validate->errors()->first());
     return back()->withErrors($validate)->withInput();
     } 
         $session=$request->session;
        $semester=$request->semester;
    
       if($request->course=="all"){

      if($request->status=="release"){
      
        StudentCourse::where('session_id',$session)
        ->where('semester_id',$semester)
        ->where('score','!=','')
        ->update([
           'status'=>$request->status
        ]);

           $student_results=StudentCourse::where('session_id',$request->session)
           ->where('semester_id',$request->semester)
           ->where('score','!=','')->get();
           $students=collect($student_results)->map(function($student_result){
            return $student_result->user_id;
          })->unique()->toArray();
          $batch = Bus::batch([
    new ResultJob($students,null,$request->semester,$request->session)
])
->then(function (Batch $batch) use ($semester,$session) {
       StudentCourse::where('session_id',$session)
        ->where('semester_id',$semester)
        ->where('score','!=','')
        ->update([
           'is_result_sent'=>1
        ]);
})
->dispatch();
             
       }
       else{
        StudentCourse::where('session_id',$request->session)
        ->where('semester_id',$request->semester)
        ->update([
           'status'=>$request->status
        ]);
       }
     }
     else{

      if($request->status=="release"){
       StudentCourse::where('course_id',$request->course)
        ->where('session_id',$request->session)->where('semester_id',$request->semester)
        ->where('score','!=','')
        ->update([
           'status'=>$request->status
        ]);

        $student_results=StudentCourse::where('course_id',$request->course)
        ->where('session_id',$request->session)->where('semester_id',$request->semester)
        ->where('score','!=','')->get();
        $students=collect($student_results)->map(function($student_result){
          return $student_result->user_id;
        })->unique()->toArray();
           $batch = Bus::batch([
    new ResultJob($students,$request->course,$request->semester,$request->session)
])
->then(function (Batch $batch) use ($semester,$session) {
       StudentCourse::where('session_id',$session)
        ->where('semester_id',$semester)
        ->where('score','!=','')
        ->update([
           'is_result_sent'=>1
        ]);
})
->dispatch();
      }
       else{
        StudentCourse::where('course_id',$request->course)
        ->where('session_id',$request->session)->where('semester_id',$request->semester)
        ->update([
           'status'=>$request->status
        ]);
       }
     }

    Alert::success('','Done');
          return back(); 

  }

  public function grade($score){

    if($score >=70 ){
      return "A";
    }
    elseif($score >= 60){
      return "B";
    }
    elseif($score >= 50){
      return "C";
    }
    elseif($score >= 45){
      return "D";
    }
    elseif($score == null){
      return null;
    }
    else{
      return "F";
    }

  }
}
