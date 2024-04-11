@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Move the Return to Home button to the top and style it -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Dashboard</h2>
                <a href="/travelInquiry/travel" class="btn btn-outline-primary">{{ __('Return to Home') }}</a>
            </div>
            <div class="card">
                <div class="card-header">{{ __('Dashboard Overview') }}</div>
                
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>You are logged in!</p>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection