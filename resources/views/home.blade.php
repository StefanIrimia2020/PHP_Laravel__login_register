@extends('layouts.app')

@section('content')

<h1 >Home Page</h1>

<div class="form-group row mb-0">
    <div class="col-md-6 offset-md-4">
        
           <p><a href={{"ajax"}}>Ajax - Dashboard</a></p> 
           <p><a href={{"dashboard"}}>Dashboard</a></p>
                   
    </div>

    
@endsection
