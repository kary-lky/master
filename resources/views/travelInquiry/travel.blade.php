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
            <div class="card mt-4">
                <div class="card-header">
                    Search Travel Inquiries
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('travelInquiry.searchResults') }}">
                        <div class="form-group">
                                <label for="searchTerm">Search Term</label>
                                <input type="text" class="form-control" name="searchTerm" id="searchTerm" required>
                                @error('searchTerm')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="searchOption">Search Option</label>
                                <select class="form-control" name="searchOption" id="searchOption">
                                    <option value="destination">Destination</option>
                                    <option value="tags">Tags</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Submit Travel Inquiry
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('travelInquiry.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title" required>
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <select class="form-control" name="tags[]" id="tags" multiple required>
                                <!-- Options for existing tags (if any) -->
                                @if(is_array(old('tags')))
                                    @foreach(old('tags') as $tag)
                                        <option value="{{ $tag }}" selected>{{ $tag }}</option>
                                    @endforeach
                                @endif
                                <!-- Custom tag options -->
                                <option value="Beach">Beach</option>
                                <option value="Mountain">Mountain</option>
                                <option value="City">City</option>
                                <option value="Adventure">Adventure</option>
                                <option value="Historical">Historical</option>
                                <option value="Cultural">Cultural</option>
                                <option value="Family">Family</option>
                                <option value="Honeymoon">Honeymoon</option>
                                <option value="Wildlife">Wildlife</option>
                                <option value="Luxury">Luxury</option>
                                <option value="Backpacking">Backpacking</option>
                                <option value="Cruise">Cruise</option>
                                <option value="Skiing">Skiing</option>
                                <option value="Food">Food</option>
                                <option value="Photography">Photography</option>
                                <option value="Relaxation">Relaxation</option>
                                <option value="Road Trip">Road Trip</option>
                                <option value="Sightseeing">Sightseeing</option>
                                <option value="Water Sports">Water Sports</option>
                                <option value="Hiking">Hiking</option>
                                <option value="Shopping">Shopping</option>
                                <option value="Hotel">Hotel</option>
                                <option value="Resort">Resort</option>
                                <option value="Bed and Breakfast">Bed and Breakfast</option>
                                <option value="Hostel">Hostel</option>
                                <option value="Vacation Rental">Vacation Rental</option>
                                <option value="Camping">Camping</option>
                                <option value="Spa">Spa</option>
                                <option value="All-Inclusive">All-Inclusive</option>
                                <option value="Boutique">Boutique</option>
                                <option value="Business">Business</option>
                            </select>
                            @error('tags')
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
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" name="start_date" id="start_date" required>
                            @error('start_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control" name="end_date" id="end_date" required>
                            @error('end_date')
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

<!-- Include the Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<!-- Include jQuery (required by Select2) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2
        $('#tags').select2({
            tags: true, // Allow custom tags
            tokenSeparators: [',', ' '], // Allow comma and space as tag separators
            createTag: function (params) {
                // Capitalize the first letter of the custom tag
                var term = $.trim(params.term);
                if (term === '') {
                    return null;
                }
                return {
                    id: term,
                    text: term.charAt(0).toUpperCase() + term.slice(1)
                }
            }
        });

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
</script>
@endsection