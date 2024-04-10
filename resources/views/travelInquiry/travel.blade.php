@extends('layout')

@section('content')
<link href="{{ asset('css/create.css') }}" rel="stylesheet">

<div class="container my-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            <div class="card">
                <div class="card-header">
                    Submit Travel Inquiry
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('travelInquiry.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" id="username" required>
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" name="phone" id="phone" required>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="destination">Destination</label>
                            <input type="text" class="form-control" name="destination" id="destination" required>
                            @error('destination')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="travel_date">Travel Date</label>
                            <input type="date" class="form-control" name="travel_date" id="travel_date" required>
                            @error('travel_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Submit Inquiry</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#travel_date').datepicker({
        dateFormat: "yy-mm-dd", // 设置日期格式
        changeMonth: true,      // 允许选择月份
        changeYear: true        // 允许选择年份
    });
});
</script>
@endsection