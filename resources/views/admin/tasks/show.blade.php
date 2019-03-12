@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br/>
        @endif

        @if(session()->get('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div><br/>
        @endif
            <a href="{{ route('admin.tasks.index')}}" class="btn btn-primary">Bake</a>

        <table class="table table-striped">

            <thead>
            <tr>
                <td>ID</td>
                <td>{{$task->id}}</td>
            </tr>
            <tr>
                <td>Name</td>
                <td>{{$task->name}}</td>
            </tr>
            <tr>
                <td>Priority</td>
                <td>{{$task->priority}}</td>
            </tr>
            <tr>
                <td>Assigned To</td>
                <td>{{$task->assigned_to}}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>{{$task->status}}</td>
            </tr>
            </thead>

        </table>

            <span>Description:</span>
            <p>
                {{$task->description}}
            </p>
        <div>
        </div>

    </div>
@endsection