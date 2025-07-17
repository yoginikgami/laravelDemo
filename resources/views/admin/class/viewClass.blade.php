@extends('layouts.app')

@section('content')

    <div class="container card mt-3 mb-5" style="width:80%">
        <h1 style="text-align: center;" class="mt-3 mb-3"> Class</h1>
        <a href="{{ route('schoolclass.create')}}" class="btn btn-success mt-4 mb-3 fw-bold" style="width:15%;">Add Class</a>
         <table id="classTable" class="table table-striped table-bordered m-2" data-toggle="table" data-search="true"
        data-pagination="true" data-page-size="10" data-page-list="[10, 25, 50, 100, All]" data-sortable="true"
        data-show-columns="true" data-show-export="true" data-show-print = "true" style="width: 100%">
        <thead class="table-dark">
            <tr>
                <th data-field="class" data-sortable="true">Class</th>
                <th data-field="section" data-sortable="true">Section</th>
                <th>View</th>
                <th>Delete</th>
            </tr>
        </thead>
        {{--  <table class="table table-striped table-bordered" style="width: 90%">
            <tr>
                <th>Class</th>
                <th>Section</th>
                <th>View</th>
                <th>Delete</th>
            </tr>  --}}
                @foreach ($schoolClass as $class)
                <tr>
                    <td>{{ $class->name}}</td>
                    <td>{{ $class->section}}</td>
                    <td><a href="{{ route('schoolclass.edit', $class->id)}}" class="btn btn-success fw-bold">Edit</a></td>
                    <td>
                    <form action="{{ route('schoolclass.destroy', $class->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this class?');">
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
