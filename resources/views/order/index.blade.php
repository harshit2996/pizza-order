@extends('layouts.admindashboard')

@section('content')
<all-orders></all-orders>

@endsection

<script>
  var orders={!! ($orders) !!}
</script>