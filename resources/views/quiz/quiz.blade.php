@extends('layouts.app')

@section('title', __('Take quiz'))

@section('content')
    <quiz-component :campaign="{{$campaignId}}"></quiz-component>
@endsection