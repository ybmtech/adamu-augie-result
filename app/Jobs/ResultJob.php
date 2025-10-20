<?php

namespace App\Jobs;

use App\Models\Semester;
use App\Models\Session;
use App\Models\StudentCourse;
use App\Models\User;
use App\Notifications\ResultNotification;
use App\Trait\CloudSms;
use Exception;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ResultJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,CloudSms,Batchable;
    public $students;
    public $course,$semester,$session;
      public $semester_name;
    public $session_name;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($students,$course,$semester,$session)
    {
        $this->students=$students;
        $this->course=$course;
        $this->semester=$semester;
        $this->session=$session;
          $this->semester_name=Semester::find($semester)->name;
        $this->session_name=Session::find($session)->name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
             
            $students=User::whereIn('id',$this->students)->get();
            $students->each(function($student)  {
                $student->notify(new ResultNotification($student,$this->course,$this->semester,$this->session));

            $results = StudentCourse::where('status', 'release')
    ->where('session_id', $this->session)
    ->where('semester_id', $this->semester)
    ->where('is_result_sent', '0')
    ->where('level_id', $student->profile->level_id)
    ->where('user_id', $student->id)
    ->with('course') 
    ->get();

$coursesList = $results->map(function($result) {
    return $result->course->code ."-". $result->score;
})->join("\n");

$message = <<<MESSAGE
Dear $student->name,

OFFICIAL $this->session_name $this->semester_name Semester RESULTS

$coursesList

From AACOE
MESSAGE;
  //send sms
          $this->sendSms($message,$student->profile->phone);
            });
            }
            catch(Exception $e){
                
            }
    }
}
