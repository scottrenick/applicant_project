@extends('layout')

@section('content')
    <p>ID: {{ $contact['id'] }}</p>
    <p>Name: {{ $contact['name'] }}</p>
    <p>Email: {{ $contact['email'] }}</p>
@stop
