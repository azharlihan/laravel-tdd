@extends('layouts.app')

@section('content')
    <h1 class="page-header text-center">Tasks Management</h1>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 mt-4">
                <h2>Tasks</h2>
                <ul class="list-group mt-4">
                    @foreach ($tasks as $task)
                        <li class="list-group-item {{ $task->is_done ? 'task-done' : '' }}">
                            <form action="{{ url("tasks/$task->id") }}" method="post" class="float-end" onsubmit="return confirm('Are U sure to delete this task?')">
                                @csrf @method('DELETE')
                                <input type="submit" value="X" id="delete_task_{{ $task->id }}" class="btn btn-link btn-xs p-0">

                                <a href="{{ url('tasks') }}?action=edit&id={{ $task->id }}" id="edit_task_{{ $task->id }}" class="float-end">
                                    edit
                                </a>
                            </form>

                            <form action="{{ url('tasks/' . $task->id . '/toggle') }}" method="post">
                                @csrf @method('PATCH')
                                <input type="submit" value="{{ $task->name }}" id="toggle_task_{{ $task->id }}" class="btn btn-link p-0">
                            </form>

                            {{ $task->description }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-4 mt-4">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul class="list-unstyled mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (!is_null($editableTask) and request('action') == 'edit')
                    <h2>Edit Task</h2>

                    <form id="edit_task_{{ $editableTask->id }}" action="{{ url("tasks/$editableTask->id") }}" method="post">
                        @csrf @method('patch')
                        <div class="form-group">
                            <label for="name" class="control-label">Name</label>
                            <input id="name" name="name" class="form-control" type="text">
                        </div>
                        <div class="form-group">
                            <label for="description" class="control-label">Description</label>
                            <textarea id="description" name="description" class="form-control"></textarea>
                        </div>
                        <div class="form-group mt-3">
                            <input type="submit" value="Update Task" class="btn btn-primary">
                        </div>
                    </form>
                @else
                    <h2>New Task</h2>

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
                @endif
            </div>
        </div>
    </div>
@endsection
