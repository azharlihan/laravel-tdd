@extends('layouts.app')

@section('content')
    <h1 class="page-header text-center">Tasks Management</h1>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 mt-4">
                <h2>Tasks</h2>
                <ul class="list-group mt-4">
                    @foreach ($tasks as $task)
                        <li class="list-group-item">
                            <a href="{{ url('tasks') }}?action=edit&id={{ $task->id }}" id="edit_task_{{ $task->id }}" class="float-end">
                                edit
                            </a>
                            {{ $task->name }} <br>
                            {{ $task->description }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-4 mt-4">
                <h2>New Task</h2>

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul class="list-unstyled mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ url('tasks') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="control-label">Name</label>
                        <input id="name" name="name" class="form-control" type="text">
                    </div>
                    <div class="form-group">
                        <label for="description" class="control-label">Description</label>
                        <textarea id="description" name="description" class="form-control"></textarea>
                    </div>
                    <div class="form-group mt-3">
                        <input type="submit" value="Create Task" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
