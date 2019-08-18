@extends('layouts.app')

@section('content')

<!-- Vue component -->
<div id="app">
    <task-component></task-component>
</div>

<!-- JavaScripts -->
<script src="{{ mix('js/app.js') }}"></script>
@endsection
