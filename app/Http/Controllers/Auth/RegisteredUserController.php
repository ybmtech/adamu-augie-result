<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Level;
use App\Models\Profile;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use RealRashid\SweetAlert\Facades\Alert;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $levels=Level::all();
        $departments=Department::all();
        return view('backend.pages.auth.register',compact('levels','departments'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validate=Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'admission_number'=>['required'],
            'phone'=>['required','unique:'.Profile::class],
            'level'=>['required'],
            'department'=>['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
         ]);
          
        if($validate->fails()){
         Alert::info('', $validate->errors()->first());
     return back()->withErrors($validate)->withInput();
     } 

     $check=User::where('username',$request->admission_number)->exists();

     if($check===true){
      Alert::info('', 'There is student with the given admission number');
      return back()->withInput();
     }

        $user = User::create([
            'name' => $request->name,
            'username'=>$request->admission_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Profile::create(
            [
                'user_id'=>$user->id,
                'level_id'=>$request->level,
                'department_id'=>$request->department,
                'admission_no'=>$request->admission_number,
                'phone'=>$request->phone,
            ]
        );
      
        $user->assignRole('student');
        
        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
