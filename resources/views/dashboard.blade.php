@extends('layouts.app')

@section('content')
<h1>Users list</h1>

<table border="1">
<tr>
    <td>id</td>
    <td>email</td>
    <td>phone</td>
    <td>verified_at</td>
    <td>Operation</td>
</tr>
@foreach ($users as $user )
<tr>
    <td>{{$user['id']}}</td>
    <td>{{$user['email']}}</td>
    <td>{{$user['phone']}}</td>
    <td>{{$user['email_verified_at']}}</td>
    <td><a href={{"deleteU/".$user['id']}}>Delete</a>
        <a href={{"edit/".$user['id']}}>Edit</a>
    </td>
</tr>
@endforeach
</table>
<br/>
<span>
    {{$users->links()}}
</span>

<style>
    .w-5{
        display: none;
    }
</style>
@endsection




