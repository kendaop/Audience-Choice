@extends('layouts.app')

@section('title', 'Login')

@section('header-includes')
    <script type="application/javascript">
        $(document).ready(function () {
            $('input#accessCode').on('keypress', function (event) {
                if (null !== String.fromCharCode(event.which).match(/[a-z]/g)) {
                    event.preventDefault();
                    $(this).val($(this).val() + String.fromCharCode(event.which).toUpperCase());
                }
            });
        });
    </script>
@endsection

@section('branding')
    @if ($logoPath)
        <div class="row">
            <div class="col-xs-8 col-xs-offset-2">
                <img class="img-responsive" src="{{$logoPath}}"/>
            </div>
        </div>
        <div class="row">&nbsp;</div>
    @endif
@endsection

@section('notification')
    @if($message)
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 alert alert-{{$messageClass}}">
                <p class="text-center">
                    {{$message}}
                </p>
            </div>
        </div>
    @endif
@endsection

@section('welcome')
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 alert alert-warning">
            <p class="text-center">{!! $welcome !!}</p>
        </div>
    </div>
@endsection

@section('body')
    <form action="/login" method="POST">
        {{ csrf_field() }}
        <div class="form-group">
            <div class="row">
                <div class="col-xs-offset-1 col-sm-offset-4">
                    <label for="accessCodeInput">Access Code</label>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-10 col-sm-4 col-xs-offset-1 col-sm-offset-4">
                    <input type="text" class="form-control" id="accessCode" name="accessCode" placeholder="Access Code">
                </div>
            </div>
        </div>
        <input type="hidden" id="timestamp" name="timestamp">
        <div class="row">
            <div class="col-xs-10 col-sm-4 col-xs-offset-1 col-sm-offset-4">
                <button type="submit" class="btn btn-primary col-xs-12" id="accessCodeSubmit">Vote!</button>
            </div>
        </div>
    </form>
@endsection