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

        <a href="{{ route('admin.tasks.create')}}" class="btn btn-primary">Create</a>
        <table class="table table-striped">
            <thead>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Priority</td>
                <td>Assigned To</td>
                <td>Status</td>
                <td colspan="3" style="text-align: center">Action</td>
            </tr>
            </thead>
            <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{$task->id}}</td>
                    <td>{{$task->name}}</td>
                    <td>{{$task->priority}}</td>
                    <td>{{$task->assigned_to}}</td>
                    <td>{{$task->status}}</td>
                    <td style="text-align: center">
                        <a href="{{ route('admin.tasks.edit',$task->id)}}" class="btn btn-primary">Edit</a>
                        <a href="{{ route('admin.tasks.show',$task->id)}}" class="btn btn-primary">Show</a>
                        <form action="{{ route('admin.tasks.destroy', $task->id)}}" method="post"
                              style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $tasks->links() !!}
        <div>
        </div>
    </div>
@endsection