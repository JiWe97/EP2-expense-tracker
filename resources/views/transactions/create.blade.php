@extends('layouts.custom')

@section('title', 'Add Transaction')

@section('styles')
    @include('layouts.styles')
@endsection

@section('content')
  @livewire('transaction-form')
@endsection
