@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>📊 Admin Dashboard</h1>


        <div class="row mt-4">
            <!-- Total Teachers -->
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3 shadow-sm text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Teachers</h5>
                        <p class="card-text fs-3">{{ $totalTeachers }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Students -->
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3 shadow-sm text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Students</h5>
                        <p class="card-text fs-3">{{ $totalStudents }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Classes -->
            <div class="col-md-4">
                <div class="card text-white bg-secondary mb-3 shadow-sm text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Classes</h5>
                        <p class="card-text fs-3">{{ $totalClasses }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teacher - Class - Subject -->
        <div class="row">
            <div class="col-lg-7 card m-3">
                <h3 class="mt-3 fw-bold text-center">Teacher - Class - Subject</h3>
                <table class="table table-striped mt-2">
                    <thead class="table-light">
                        <tr>
                            <th>Teacher</th>
                            <th>Class</th>
                            <th>Subject</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($teachersWithSubjects as $teacher)
                            @forelse ($teacher->subjects as $subject)
                                <tr>
                                    <td>{{ $teacher->user->name }}</td>
                                    <td>{{ $subject->schoolClass->name ?? 'N/A' }} -
                                        {{ $subject->schoolClass->section ?? 'N/A' }}</td>
                                    <td>{{ $subject->name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td>{{ $teacher->user->name }}</td>
                                    <td colspan="2"><em>No subjects assigned</em></td>
                                </tr>
                            @endforelse
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No teachers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Student Count per Class -->
            <div class="col-lg-4 card m-3">
                <h3 class="mt-3 fw-bold text-center">Student Count per Class</h3>
                <table class="table table-striped mt-2">
                    <thead class="table-light">
                        <tr>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($studentCountsByClass as $class)
                            <tr>
                                <td>{{ $class->name }}</td>
                                <td>{{ $class->section }}</td>
                                <td>{{ $class->student_count }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">No students found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
