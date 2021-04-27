@extends('layouts.app')

@section('content')
<h1>Update users</h1>

<form action="/edit" method="POST"> 
     @csrf
<input type="hidden" name="id" value="{{$data['id']}}">
<input type="text" name="email" value="{{$data['email']}}"> <br/> <br/>
<input type="text" name="phone" value="{{$data['phone']}}"> <br/> <br/>
<button type="submit">Update</button>
</form>


<style>
    .w-5{
        display: none;
    }
</style>
@endsection