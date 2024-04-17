@extends('layout')

@section('content')
<style>
#map-canvas {
  height: 300px;
  width: 100%;
  float: right;
}
</style>
<link href="{{ asset('css/create.css') }}" rel="stylesheet">
@if (session('success'))
<div class="alert alert-success">
  {{ session('success') }}
</div>
@endif
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJQqiwokQWGGBEvgP_BMD8_w9TpeC5tjc"></script>
<div class="container my-4">
  <div class="row">
    <div class="col-md-8">
      <div class="card" id="editTravel">
        <div class="card-header">
          Edit Travel Inquiry
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('travelInquiry.update', $travelInquiry->id) }}" id="travelIdea">
            @csrf
            @method('PATCH')
            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" class="form-control input" name="title" id="title" value="{{ $travelInquiry->title }}"
                required>
              @error('title')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="form-group">
              <label for="tags">Tags</label>
              <input type="text" class="form-control input" name="tags" id="tags" value="{{ $travelInquiry->tags }}"
                required>
              @error('tags')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="form-group">
              <label for="destination">Destination</label>
              <input type="text" class="form-control input" name="destination" id="destination"
                value="{{ $travelInquiry->destination }}" required>
              @error('destination')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="form-group">
              <label for="start_date">Start Date</label>
              <input type="date" class="form-control input" name="start_date" id="start_date"
                value="{{ $travelInquiry->start_date }}" required>
              @error('start_date')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="form-group">
              <label for="end_date">End Date</label>
              <input type="date" class="form-control input" name="end_date" id="end_date"
                value="{{ $travelInquiry->end_date }}" required>
              @error('end_date')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <button type="submit" class="btn btn-primary submitBtn">Update Inquiry</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card" id="mapInfo">
        <div class="card-header">
          Map Route Info
        </div>
        <div class="card-body" id="mapBody">
          <div class="row">
            <div class="col-6">
              <label for="mapSearchFrom">From:&nbsp;</label>
              <input type="text" class="form-control input" id="mapSearchFrom">
            </div>
            <div class="col-6">
              <label for="mapSearchTo">To:&nbsp;</label>
              <input type="text" class="form-control input" id="mapSearchTo">
            </div>
          </div>
          <button id="mapSearchSubmit" class="btn btn-primary">Search</button>
          <div id="map-canvas"></div>
        </div>
      </div>
      <div class="card" id="weatherInfo">
        <div class="card-header">
          Weather Info
        </div>
        <div class="card-body" id="weatherBody">

        </div>
      </div>
      <div class="card my-4" id="FlightInfo">
        <div class="card-header">
          Flight Info
        </div>
        <div class="card-body" id="flightBody">
          <span id="orginDest"></span>
          <table class="table" id="flightResult">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Duration</th>
                <th scope="col">Price (EUR)</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>
<script src="/js/editTravel.js"></script>
<script>
$(document).ready(function() {
  var startDateInput = $('#start_date');
  var endDateInput = $('#end_date');

  // Set minimum date to today for start date input
  var today = new Date().toISOString().split('T')[0];
  startDateInput.attr('min', today);

  // Disable end date input until a valid start date is selected
  endDateInput.prop('disabled', true);

  loadMap('Hong Kong', $("#destination").val());
  getWeather();
  getAirport();

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

  $("#mapSearchSubmit").on('click', function() {
    var searchStart = $("#mapSearchFrom").val();
    var searchEnd = $("#mapSearchTo").val();
    loadMap(searchStart, searchEnd);

  });

});
</script>
<style>
.highlight-range {
  background-color: #b3d4fc !important;
}
</style>
@endsection