<?php

namespace App\Http\Controllers;

use App\Pizza;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PizzaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {   
        if(Auth::check()){
            return redirect('dashboard');
        }
        return view('pizza.index');
    }

    public function getpizza()
    {
        $pizzas=Pizza::all();
        return $pizzas;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pizza.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
             
        if($request->hasFile('image')){
            $fileNameToStore= $request->file('image')->getClientOriginalName();
            // Upload Image
            $file=$request->file('image');
            // $path = $request->file('image')->storeAs('public/pizza_images', $fileNameToStore);
            // $pathToFile = Storage::disk('public')->put('uploads/', $fileNameToStore);
            // Storage::disk('public')->put(''.$fileNameToStore,$file);
            $request->file('image')->move(public_path("/img"), $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        // Create Post
        $pizza = new Pizza;
        $pizza->pizza_name = $request->input('pizza_name');
        $pizza->pizza_desc = $request->input('pizza_desc');
        $pizza->price = $request->input('price');
        $pizza->image = $fileNameToStore;
        $pizza->save();

        return redirect('dashboard');
        // return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pizza  $pizza
     * @return \Illuminate\Http\Response
     */
    public function show(Pizza $pizza)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pizza  $pizza
     * @return \Illuminate\Http\Response
     */
    public function edit(Pizza $pizza)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pizza  $pizza
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pizza $pizza)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pizza  $pizza
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pizza $pizza)
    {
        //
    }
}
