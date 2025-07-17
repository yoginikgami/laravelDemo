@extends('layouts.app')

@section('content')

    <div class="container card mt-3 mb-5" style="width:100%">
        @php
            $role = Auth::user();

        @endphp
        <h1 style="text-align: center;" class="mt-3 mb-3"> Student Details</h1>
        <a href="{{ route('student.create') }}" class="btn btn-success mt-4 mb-3 fw-bold" style="width:15%">Add
            Student</a>
             <table id="studentTable" class="table table-striped table-bordered m-2" data-toggle="table" data-search="true"
        data-pagination="true" data-page-size="10" data-page-list="[10, 25, 50, 100, All]" data-sortable="true"
        data-show-columns="true" data-show-export="true" data-show-print = "true" style="width: 100%">
        <thead class="table-dark">
            <tr>
                <th data-field="name" data-sortable="true">Name</th>
                <th data-field="email" data-sortable="true">Email</th>
                <th data-field="class" data-sortable="true">class</th>
                <th data-field="rollNo" data-sortable="true">Roll No</th>
                <th data-field="gender" data-sortable="true">Gender</th>
                <th data-field="dob" data-sortable="true">Date of Birth</th>
                <th data-field="profile_photo">Profile Photo</th>
                <th data-field="address" data-sortable="true">Address</th>
                <th data-field="phone_no" data-sortable="true">Phone No</th>
                <th>View</th>
                @role('Admin')<th>Delete</th>@endrole
            </tr>
        </thead>

            @foreach ($students as $student)
                <tr>
                    <td>{{ $student->user->name }}</td>
                    <td>{{ $student->user->email }}</td>
                    <td>{{ $student->schoolClass->name }} - {{ $student->schoolClass->section }}</td>
                    <td>{{ $student->roll_no }}</td>
                    <td>{{ $student->gender }}</td>
                    <td>{{ \Carbon\Carbon::parse($student->dob)->format('d/m/Y') }}</td>
                    <td>
                        @if ($student->photo)
                            <img src="{{ asset('storage/' . $student->photo) }}" height="100" width="100">
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $student->address }}</td>
                    <td>{{ $student->contact_no }}</td>

                    <td><a href="{{ route('student.edit', $student->id) }}" class="btn btn-success fw-bold">Edit</a>
                    </td>
                    @role('Admin')
                        <td>

                            <form action="{{ route('student.destroy', $student->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this student?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger fw-bold">Delete</button>
                            </form>
                        </td>
                        @endrole

                </tr>
            @endforeach

        </table>

    </div>
@endsection
