
@extends('backend.layout')
@section('backend_contains')
   @canany(['user_create'])
       <h1>Hello...</h1>
   @endcanany
   <h1>nothing found!</h1>
@endsection