@extends('layouts.app')
<style>
    .cards {
        width: 90%;
        max-width: 100%;
        margin: auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(30%, 1fr));
        grid-gap: 20px;
    }
</style>
@section('content')
    <home-component></home-component>
@endsection
