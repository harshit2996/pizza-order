<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders=Order::all();
        foreach ($orders as $order) {
            $order->order=json_decode($order->order);
        }
        return $orders;
    }

    public function user()
    {   

        $orders=Order::all()->where('user_id',Auth::id());
        foreach ($orders as $order) {
            // $order->order=json_decode($order->order);
        }
        return $orders;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $order=$request->get('order');
        if(Auth::check()){
            $user=Auth::user();
            return view('order.create')->with(['order'=>$order,'user'=>$user]);
        }
        else{
            $user=User::find(0);
            return view('order.create')->with(['order'=>$order,'user'=>$user]);
            
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $address= $request->get('house').', '.$request->get('street').', '.$request->get('city').', Zip Code: '.$request->get('zipcode');
        $order=new Order;
        $order->order=($request->get('order'));
        if(Auth::id()){

            $order->user_id= Auth::id();
        }
        $order->address=$address;
        $order->bill=$request->get('bill');
        $order->name=$request->get('name');
        $order->email=$request->get('email');
        $order->phone=$request->get('phone');


        $order->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    public function tempstore(Request $request)
    {
        // dd($request->all());
        $order=$request->get('order');
        // dd(json_decode($order));
        return redirect()->route('order.create')->with('order', $order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
