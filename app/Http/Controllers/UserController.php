<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Level;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rules;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','role:examiner']);
    }

    //
     /**
     * Display the users view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
      $students=User::whereHas('roles',function($query){
         $query->whereIn('name',['student']);
         })->latest()->get();
         $levels=Level::all();
         $departments=Department::all();
        return view('backend.pages.students',compact('students','levels','departments'));
    }
 
    /**
     * Store user
     *
     *@return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

      $validate=Validator::make($request->all(),[
         'name' => ['required', 'string', 'max:255'],
         'email' => ['required','email', 'max:255', 'unique:'.User::class],
         'admission_number'=>['required'],
         'level'=>['required'],
         'department'=>['required'],
         'phone'=>['required','unique:'.Profile::class],
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
             'admission_no'=>$request->admission_number,
             'department_id'=>$request->department,
             'phone'=>$request->phone,
         ]
     );
   
     $user->assignRole('student');
     
     Alert::success('', 'Student added successfully');
     return back();
    }


    public function show($id){

      $id=substr($id,10);

      $student=User::findOrFail($id);
      $levels=Level::all();
       $departments=Department::all();
      return view('backend.pages.edit-student',compact('student','levels','departments'));
  

    }

    /**
     * Edit user
     *
     *@return \Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request)
    {

           $validate=Validator::make($request->all(),[
            'id'=>['required'],
            'name' => ['required', 'string', 'max:255'],
             'email' => ['required','email', 'max:255','unique:users,email,'.$request->id],
             'admission_number'=>['required'],
             'level'=>['required'],
             'department'=>['required'],
              'phone'=>['required','unique:profiles,phone,'.$request->id.',user_id'],
           ],[
            'id.required'=>'No student selected'
           ]
         );

         if($validate->fails()){
            Alert::info('', $validate->errors()->first());
            return back()->withErrors($validate)->withInput();
            } 

            $check=User::where('username',$request->admission_number)->where('id','!=',$request->id)->exists();

        if($check===true){
         Alert::info('', 'There is student with the given admission number');
         return back()->withInput();
        }
        
     $user = User::where('id',$request->id)->update([
         'name' => $request->name,
         'username'=>$request->admission_number,
         'email' => $request->email,
     ]);

     Profile::where('user_id',$request->id)->update(
         [
             'level_id'=>$request->level,
             'admission_no'=>$request->admission_number,
              'department_id'=>$request->department,
             'phone'=>$request->phone
         ]
     );
                
                Alert::success('', 'Student information updated');
               return redirect()->route('user.lists');  
        
    }

    public function changeStatus(Request $request){
      $validate=Validator::make($request->all(),[
         'user_id'=>['required'],
         'status'=>['required'],
         ]
         );

         if($validate->fails()){
            Alert::info('', $validate->errors()->first());
        return back()->withErrors($validate)->withInput();
        } 
        $id=substr($request->user_id,10);
        $user=User::findOrFail($id);
        

        $status=($request->status=='active') ? "disabled" : "active";

        $user->status=$status;
        $user->save();

        $message=($request->status=='active') ? "Student disabled" : "Student activated";
        Alert::success('',$message);
        return back(); 
    
    }

    public function destroy(Request $request){

      $validate=Validator::make($request->all(),[
          'user_id'=>['required'],
          ]
          );

          if($validate->fails()){
             Alert::info('', $validate->errors()->first());
         return back()->withErrors($validate)->withInput();
         } 
         $id=substr($request->user_id,10);
         $user=User::findOrFail($id);
        
         $role= $user->getRoleNames()[0];
         $user->removeRole($role);
         $delete_user=$user->delete();
         if($delete_user){
            Alert::success('','Student Deleted');
            return back(); 
         
         }
         Alert::info('','Fail to delete student');
         return back();
    }

}
