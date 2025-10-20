<?php

namespace App\Notifications;

use App\Models\Semester;
use App\Models\Session;
use App\Models\StudentCourse;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResultNotification extends Notification
{
    use Queueable;

    public $student;
    public $course;
    public $semester;
    public $session_id;
    public $semester_name;
    public $session_name;
    public $logo;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $student,$course,$semester,$session)
    {
        $this->student=$student;
        $this->course=$course;
        $this->semester=$semester;
        $this->session_id=$session;
        $this->semester_name=Semester::find($semester)->name;
        $this->session_name=Session::find($session)->name;
          $logoPath = public_path('images/aacoe.jpeg');
        if (file_exists($logoPath)) {
            $imageData = file_get_contents($logoPath);
            $base64 = base64_encode($imageData);
            $this->logo = 'data:image/png;base64,' . $base64;
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if($this->course==null){

        $results=StudentCourse::where('status','release')
        ->where('session_id',$this->session_id)
        ->where('semester_id',$this->semester)
        ->where('is_result_sent','0')
        ->where('level_id',$this->student->profile->level_id)
        ->where('user_id',$this->student->id)->get();
        }
        else{
            $results=StudentCourse::where('status','release')
         ->where('session_id',$this->session_id)
         ->where('semester_id',$this->semester)
         ->where('course_id',$this->course)
         ->where('is_result_sent','0')
         ->where('level_id',$this->student->profile->level_id)
         ->where('user_id',$this->student->id)->get();
        }
        return (new MailMessage)
                    ->subject('AACOE RESULT')
                    ->view('backend.pages.result-mail',
                    ['results'=>$results,'student'=>$this->student,
                    'semester_name'=>$this->semester_name,
                    'session_name'=>$this->session_name,
                    'logo'=>$this->logo
                ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
