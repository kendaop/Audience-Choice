@php

@endphp

@extends('layouts.app')

@section('title', 'Login')

@section('notification')
    {{config('vote.messages.hello')}}
    @if($message)
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3 alert alert-{{$messageClass}}">
                <p>
                    {{$message}}
                </p>
            </div>
        </div>
    @endif
@endsection

@section('container')
    <div><p class="bg-warning">{!! $welcome !!}Enter your Access Code in the box below to vote for your favorite films!</p></div>
    <form action="/login" method="POST">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="accessCodeInput">Access Code</label>
            <input type="text" class="form-control" id="accessCode" name="accessCode" placeholder="Access Code">
        </div>
        <input type="hidden" id="timestamp" name="timestamp">
        <button type="submit" class="btn btn-primary" id="accessCodeSubmit">Vote!</button>
    </form>
@endsection