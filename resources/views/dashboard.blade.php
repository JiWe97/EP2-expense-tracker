@extends('layouts.custom')

@include('layouts.styles')

@section('content')
<div class="dashboard-header">
    <h1 class="text-2xl font-bold">Total Balance: € {{ $totalBalance }}</h1>
    <div class="dashboard-top-right">
        <a href="{{ route('transactions.create') }}" class="dashboard-btn dashboard-btn-primary dashboard-icon-button">+</a>
        <a href="{{ route('transactions.import') }}" class="dashboard-btn dashboard-btn-primary dashboard-icon-button">
            <i class="fas fa-upload"></i>
        </a>
    </div>
</div>

<!-- Transaction History Section -->
<div class="dashboard-mb-4">
    @livewire('transaction-search')
</div>
@endsection
