@extends('layouts.dashboard')

@section('content')
    <pizzas :numitems.sync="numItems" :rightdrawer.sync="rightdrawer"></pizzas>
@endsection

<script>
  var user={!! ($user) !!}
</script>
