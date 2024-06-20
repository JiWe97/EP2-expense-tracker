@extends('layouts.custom')

@section('title', 'Edit Transaction')


@section('styles')
    @include('layouts.styles')
@endsection

@section('content')
  @livewire('transaction-form', ['transaction' => $transaction])
@endsection
