<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmail;
use App\Models\User;
use App\Models\VerifyUser;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('user.index');
    }
    
    public function pag_conditions()
    {
        return view ('terms.pag_all_terms');
    }
    public function term_cond()
    {
        return view ('terms.terms');
    }
  
    
    public function login()
    {
        return view('auth.login');
    }

  

    public function home()
    {
        return view('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $request->validate(
            [
                'name'              =>      'required|string|max:20',
                'email'             =>      'required|email|max:255|unique:users',
                'phone'             =>      'required|string|min:10',
                'password'          =>      'required|min:6|max:100', //regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'
                'password_confirmation'  => 'required|same:password',
                'terms'=>'required'
               
            ]
        );
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password)
        ]);
        VerifyUser::create([
            'token' => Str::random(60),
            'user_id' => $user->id
        ]);
        
        Mail::to($user->email)->send(new VerifyEmail($user));
        return \redirect()->route('user.login')->with('success', 'Please click on the link sent to your email');
    }

    public function verifyEmail($token)
    {
        $verifiedUser = VerifyUser::where('token', $token)->first();
        if (isset($verifiedUser)) {
            $user = $verifiedUser->user;
            if (!$user->email_verified_at) {
                $user->email_verified_at = Carbon::now();
                $user->save();
                return \redirect(route('user.login'))->with('success', 'Your email has been verified');
            } else {
                return \redirect()->back()->with('info', 'Your email has already been verified');
            }
        } else {
            return \redirect(route('user.login'))->with('error', 'Something went wrong!!');
        }
    }
        
  //..................................Validate user.................................

    public function validateLogin(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            if (Auth::user()->email_verified_at == null) {
                Auth::logout();
                return \redirect(route('user.login'))->with('error', 'Please verify your email to continue');
            }
            return \redirect(route('home'))->with('success', 'Logged In Successfully');
        }
        else{
            return \redirect()->back()->with('error', 'Incorect email or password');
        }
    }
    public function log_out(Request $request)
    {
        Auth::logout();
         return \redirect(route('user.login'));
    }

//--------------------------------get all users from database-ajax pag---------------------
   public function allData()
   {
       $data=User::inRandomOrder()->get();
       return response()->json($data);
   }


  //..................................edit user- ajax pag.................................
  
  public function editData($id)
   {
         $data=User::findORFail($id);
         return response()->json($data);
   }

   public function updateData(Request $request,$id)
   {
    $request->validate(
        [           
            'email'             =>      'required',
            'phone'             =>      'required'
            ]);

            $data = User::findOrFail($id)->update([
                
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
            return response()->json($data);
   }

   //--------------------------------get all users from database-dashboard pag---------------------
   public function lista(){

    $data= User::paginate(5);
    return view('dashboard',['users'=>$data]);
}

      //..................................edit user -dashboard.................................
    public function editUser($id){
        
        $data= User::find($id);
        return view('edit',['data'=>$data]);
    }

       //..................................update user -dashboard.................................
    public function updateUser(Request $req){
        
        $data= User::find($req->id);
        $data->email=$req->email;
        $data->phone=$req->phone;
        $data->save();
        return redirect('dashboard');
    }
 //..................................delete user -dashboard.................................
    public function deleteUser($id){

        $data=User::find($id);
        $data->delete();
        return redirect ('dashboard');
    }

    public function search()
    {

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
