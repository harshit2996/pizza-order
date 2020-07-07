@extends('layouts.app')

@section('content')
		<pizzas :rdrawer.sync="rightdrawer" :nitems.sync="numItems"></pizzas>
@endsection

