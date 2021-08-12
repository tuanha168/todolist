@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
    <div class="row justify-content-center mb-3">
        <div class="col-md-10">
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        </div>
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <strong>Add Task</strong>
                    <form method="POST" action="{{ route('task.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="task_name"
                                class="col-md-4 col-form-label text-md-right">{{ __('Task Name') }}</label>

                            <div class="col-md-6">
                                <input id="task_name" type="text"
                                    class="form-control @error('task_name') is-invalid @enderror" name="task_name"
                                    required>

                                @error('task_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add ToDo') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-10 mt-3">
            <div class="card">
                <div class="card-body">
                    @if (count($tasks) < 1) <p>Please Create A Task</p>
                        @else
                        <strong>ToDo List</strong>
                        @foreach ($tasks as $task)
                        <form method="POST" action="{{ route('task.delete') }}">
                            @csrf
                            @method('DELETE')

                            <div class="row mt-2">
                                <input id="task_id" class="form-control" value="{{ $task->task_id }}" hidden
                                    name="task_id">
                                <div class="col-md-9 d-flex align-items-center">
                                    <h4 class="mb-0" style="word-break: break-all">{{ $task->task_name }}</h4>
                                </div>
                                <div class="col-md-3 text-right d-flex">
                                    <button type="button" class="btn btn-primary mr-3" data-bs-toggle="modal"
                                        data-bs-target="#Update">
                                        Update
                                    </button>
                                    <button type="submit" class="btn btn-danger">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </form>
                        @endforeach
                        @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="Update" tabindex="-1" aria-labelledby="UpdateLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('task.update') }}">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="UpdateLabel">{{ __('Update Task') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group row">
                            <label for="task_name"
                                class="col-md-4 col-form-label text-md-right">{{ __('Task Name') }}</label>

                            <div class="col-md-6">
                                <input id="task_name" type="text"
                                    class="form-control @error('task_name') is-invalid @enderror"
                                    value="{{ old('task_name') ?? $update_task }}" name="task_name" required
                                    autofocus />

                                @error('task_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection