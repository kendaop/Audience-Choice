@extends('layouts.app')

@section('title', 'Ballot')

@section('body')
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <form action="/submitBallot" id="ballot" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="access-code-id" value="{{session('accessCodeId')}}">
                <input type="hidden" id="timestamp" name="timestamp">
                <input type="hidden" id="hash" name="hash">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    @foreach($categories as $category)
                        @include('category', [
                            'squashed' => $squashed
                        ])
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-xs-2 col-xs-offset-5">
                        <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection