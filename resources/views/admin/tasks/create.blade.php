@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card-header">
            Add Task
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br />
            @endif
                <form method="post" action="{{ route('admin.tasks.store') }}">
                    <div class="form-group">
                        @csrf
                        <label for="name">Task Name:</label>
                        <input type="text" class="form-control" name="name"/>
                    </div>
                    <div class="form-group">
                        <label for="description">Task Description :</label>
                        <textarea  class="form-control" rows="5" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="priority">Task Priority :</label>
                        <select name="priority" class="form-control form-control-lg">
                            @foreach(\App\Models\Repositories\TaskRepository::getAllPossiblePriority() as $priority)
                                <option value={{$priority}}>{{$priority}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="assigned_to">Task Assign To :</label>
                        <select name="assigned_to" class="form-control form-control-lg">
                            @foreach($users as $user_id => $user)
                                <option value="{{$user_id}}">{{$user}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Task</button>
                    <a href="{{ route('admin.tasks.index')}}" class="btn btn-primary">Bake</a>
                </form>
        </div>

    </div>
@endsection