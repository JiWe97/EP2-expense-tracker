@extends('layouts.custom')

@section('title', 'Edit Transaction')

@section('content')
  @livewire('transaction-form', ['transaction' => $transaction])
@endsection
