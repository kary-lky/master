@extends('layout')

@section('content')
<div class="container my-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    Search Results
                </div>
                <div class="card-body">
                    @if($inquiries->isEmpty())
                        <p>No results found.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Tags</th>
                                    <th>Destination</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inquiries as $inquiry)
                                    <tr>
                                        <td>{{ $inquiry->title }}</td>
                                        <td>{{ $inquiry->tags }}</td>
                                        <td>{{ $inquiry->destination }}</td>
                                        <td>{{ $inquiry->start_date }}</td>
                                        <td>{{ $inquiry->end_date }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
        @if (isset($totalRecords))
            <div class="row">
                <div class="col-md-8 offset-md-2 text-center">
                    <p>Total records found: {{ $totalRecords }}</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection