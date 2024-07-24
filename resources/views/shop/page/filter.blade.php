@extends('layouts.app')

@section('content')
<div class="container mx-auto my-8">
    @if (session('status'))
        <div>
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        </div>
    @endif

    <search api-key="{{config('scout.typesense.client-settings.api_search_key')}}"/>
</div>
@endsection
