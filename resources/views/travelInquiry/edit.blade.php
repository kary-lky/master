@extends('layout')

@section('content')
<link href="{{ asset('css/create.css') }}" rel="stylesheet">
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="container my-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    Edit Travel Inquiry
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('travelInquiry.update', $travelInquiry->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title" value="{{ $travelInquiry->title }}" required>
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <input type="text" class="form-control" name="tags" id="tags" value="{{ $travelInquiry->tags }}" required>
                            @error('tags')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="destination">Destination</label>
                            <input type="text" class="form-control" name="destination" id="destination" value="{{ $travelInquiry->destination }}" required>
                            @error('destination')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" name="start_date" id="start_date" value="{{ $travelInquiry->start_date }}" required>
                            @error('start_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control" name="end_date" id="end_date" value="{{ $travelInquiry->end_date }}" required>
                            @error('end_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Update Inquiry</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var startDateInput = $('#start_date');
        var endDateInput = $('#end_date');

        // Set minimum date to today for start date input
        var today = new Date().toISOString().split('T')[0];
        startDateInput.attr('min', today);

        // Disable end date input until a valid start date is selected
        endDateInput.prop('disabled', true);

        // Update minimum date for end date input based on selected start date
        startDateInput.on('change', function() {
            var startDate = new Date($(this).val());
            var minEndDate = startDate.toISOString().split('T')[0];
            endDateInput.attr('min', minEndDate);
            endDateInput.prop('disabled', false);
        });

        // Highlight the range of days between start and end dates
        endDateInput.on('change', function() {
            var startDate = new Date(startDateInput.val());
            var endDate = new Date($(this).val());

            // Remove any existing range highlight
            $('.highlight-range').removeClass('highlight-range');

            if (startDate <= endDate) {
                var currentDate = new Date(startDate);
                while (currentDate <= endDate) {
                    var dateString = currentDate.toISOString().split('T')[0];
                    var cell = $('.datepicker td[data-date="' + dateString + '"]');
                    cell.addClass('highlight-range');
                    currentDate.setDate(currentDate.getDate() + 1);
                }
            }
        });
    });
</script>
<style>
    .highlight-range {
        background-color: #b3d4fc !important;
    }
</style>
@endsection