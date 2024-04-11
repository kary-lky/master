@extends('layout')

@section('content')
<div class="container my-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    Travel Inquiries
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Tags</th>
                                <th>Destination</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($travelInquiries as $travelInquiry)
                            <tr>
                                <td>{{ $travelInquiry->title }}</td>
                                <td>{{ $travelInquiry->tags }}</td>
                                <td>{{ $travelInquiry->destination }}</td>
                                <td>{{ $travelInquiry->start_date }}</td>
                                <td>{{ $travelInquiry->end_date }}</td>
                                <td>
                                    <a href="{{ route('travelInquiry.edit', $travelInquiry->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('travelInquiry.destroy', $travelInquiry->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this inquiry?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection