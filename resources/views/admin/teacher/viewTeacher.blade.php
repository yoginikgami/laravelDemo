@extends('layouts.app')

@section('content')
<div class="card m-2 " ">



<a href="{{ route('teacher.create') }}" class="btn btn-success fw-bold m-3" style="width:15%">Add
            Teacher</a>
    <table id="teacherTable" class="table table-striped table-bordered m-2" data-toggle="table" data-search="true"
        data-pagination="true" data-page-size="10" data-page-list="[10, 25, 50, 100, All]" data-sortable="true"
        data-show-columns="true" data-show-export="true" data-show-print = "true" style="width: 100%">
        <thead class="table-dark">
            <tr>
                <th data-field="name" data-sortable="true">Name</th>
                <th data-field="email" data-sortable="true">Email</th>
                <th data-field="qualification" data-sortable="true">Qualification</th>
                <th data-field="subject" data-sortable="true">Subjects</th>
                <th data-field="phone" data-sortable="true">Phone</th>
                <th data-field="address" data-sortable="true">Address</th>
                <th data-field="profile_photo">Profile Photo</th>
                <th data-field="joined_date" data-sortable="true">Join Date</th>
                <th>View</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($teachers as $teacher)
                <tr>
                    <td>{{ $teacher->user->name }}</td>
                    <td>{{ $teacher->user->email }}</td>
                    <td>{{ $teacher->qualification }}</td>
                    <td>{{ $teacher->subject }}</td>
                    <td>{{ $teacher->phone }}</td>
                    <td>{{ $teacher->address }}</td>
                    <td>
                        @if ($teacher->profile_photo)
                            <img src="{{ asset('storage/' . $teacher->profile_photo) }}" height="60" width="60">
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($teacher->joined_date)->format('d/m/Y') }}</td>

                    <td><a href="{{ route('teacher.edit', $teacher->id) }}" class="btn btn-success fw-bold">Edit</a>

                    {{--  <td><button class="btn btn-success fw-bold edit-btn" data-id="{{ $teacher->id }}">Edit</button>  </td>  --}}
                    <td>
                        <form action="{{ route('teacher.destroy', $teacher->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this teacher?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger fw-bold">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
@endsection
@push('scripts')
    <script>
        $(function() {
            $('#teacherTable').bootstrapTable();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.edit-btn').on('click', function(e) {
                e.preventDefault();
                let teacherId = $(this).data('id');

                $.ajax({
                    url: '/teacher/' + teacherId + '/edit',
                    type: 'GET',
                    success: function(response) {
                        $('#editTeacherContent').html(response); // load form into modal
                        $('#editTeacherModal').modal('show'); // open modal
                    },
                    error: function() {
                        alert('Failed to load teacher data.');
                    }
                });
            });
        });
    </script>
@endpush  

{{-- Modal for editing teacher --}}
{{--  <div class="modal fade" id="editTeacherModal" tabindex="-1" aria-labelledby="editTeacherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <div class="modal-header">
            <h5 class="modal-title">Edit Teacher</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="editTeacherContent" style="background-color: white;">

        </div>
    </div>
</div>  --}}
