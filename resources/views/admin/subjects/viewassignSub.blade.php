@extends('layouts.app')

@section('content')

    <div class="container card mt-3 mb-5" style="width:100%">
        <h1 style="text-align: center;" class="mt-3 mb-3"> Assign Subject List</h1>
        <a href="{{ route('subject.create')}}" class="btn btn-success mt-4 mb-3 fw-bold" style="width:15%">Add Subject</a>
         <table id="subjectTable" class="table table-striped table-bordered m-2" data-toggle="table" data-search="true"
        data-pagination="true" data-page-size="10" data-page-list="[10, 25, 50, 100, All]" data-sortable="true"
        data-show-columns="true" data-show-export="true" data-show-print = "true" style="width: 100%">
        <thead class="table-dark">
            <tr>
                <th data-field="Subname" data-sortable="true">Subject Name</th>
                <th data-field="class_section" data-sortable="true">Class & Section</th>
                <th data-field="name" data-sortable="true">Teacher Name</th>
                <th data-field="qualification" data-sortable="true">Qualification</th>
                <th data-field="profile_photo">Profile Photo</th>
                <th>View</th>
                <th>Delete</th>
            </tr>
        </thead>
            @foreach ($subjcts as $subject)
            <tr>
                <td>{{$subject->name}}</td>
                <td>{{$subject->schoolClass->name}} - {{$subject->schoolClass->section}}</td>
                <td>{{$subject->teacher->user->name}}</td>
                <td>{{$subject->teacher->qualification}}</td>
                <td>
                    <img src="{{ asset('storage/' . $subject->teacher->profile_photo) }}" height="100px" width="100px" alt="Profile Photo">
                </td>

                <td><a href="{{ route('subject.edit', $subject->id) }}" class="btn btn-success fw-bold">Edit</a></td>
                <td>
                    <form action="{{ route('subject.destroy', $subject->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this assign class and subject ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger fw-bold">Delete</button>
                    </form>
                </td>
                </tr>
                @endforeach
        </table>
    </div>
@endsection
