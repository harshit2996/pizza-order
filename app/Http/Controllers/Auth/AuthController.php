<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\Pizza;
use Auth;
use Redirect;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function authenticate(Request $request)
    {
        $credentials = [
            'email' => $request['email'],
            'password' => $request['password'],
        ];
        
        // return $credentials;
        // Attempt to login the user
        if (Auth::attempt($credentials)) {
            return '';
        }
    
        else{
            return 'Credentials do not match';

        }
    } 

    public function index()
    {
            return view('login');
        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=new User;
        $user->name=$request->get('name');
        $user->email=$request->get('email');
        $password=$request->get('password');
        $password= Hash::make('secret');

        $user->password=$password;
        $user->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function login(User $user){
        if(Auth::check()){
            $user=Auth::user();
            if($user->isAdmin){
                return view('admin');
            }
            else{
                $pizzas=Pizza::all();
                return view('dashboard')->with(['user'=>$user, 'pizzas'=>$pizzas]);
            }
        }
    }

    public function logout(){
        if(Auth::check()){
            Auth::logout();
        }
    }


    public function getUsers(){
        $users=User::all();
        return ($users);
        
    }
}
