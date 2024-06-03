@extends('layouts.app')

@section('content')
    <div class="w-full h-full flex justify-center items-center">
        <h1 class="text-3xl font-bold">Dashboard</h1>
    </div>

    <x-progress-bar></x-progress-bar>

    <a href="{{ route('transaction.create') }}" class="link">Add</a>

@endSection