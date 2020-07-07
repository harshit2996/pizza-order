@extends('layouts.app')

@section('content')
  <order-page></order-page>
  
@endsection('content')

<script>
  var final_order={!! ($order) !!}
  
  var user={!! ($user) !!}
</script>
