<?php
namespace App\Trait;

trait CloudSms{
    public function sendSms($message,$phone){
           $userid=env('CLOUD_SMS_USER_ID'); 
           $password=env('CLOUD_SMS_PASSWORD');
        $sender=urlencode(env('CLOUD_SMS_SENDER'));
           $encode_message=urlencode($message);
           $message_type=0;
                       $code='234';
                       $trim_phone=trim($phone);
                       //format contact
                    $format_phone=$trim_phone;
                                        if(substr($trim_phone,0,1)=='0'){
                           $format_phone=$code.substr($trim_phone,-10);
                               }
                   elseif(substr($trim_phone,0,1)=='+'){
                       $format_phone=$code.substr($trim_phone,-10);
                              }
                   $url="http://developers.cloudsms.com.ng/api.php?userid={$userid}&password={$password}&type={$message_type}&destination={$format_phone}&sender={$sender}&message={$encode_message}";
                     if ($f = @fopen($url, "r")) {
                       $response = fgets($f, 255);
                       $trim_response=trim($response);
                       if(101==$trim_response){
                           return true;
                          }
                          else{
                           return false;
                          }
       }
       }

}