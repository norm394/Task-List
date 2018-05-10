@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading" id="div_task_add_and_edit">
                    New Task
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')

                    <!-- New Task Form -->
                    <form  name="form_task_add_and_update" action="{{ url('task/-1')}}" method="POST" class="form-horizontal" id="form_task_add_and_edit">
                        {{ csrf_field() }}

                        <!-- Task Owner -->
                        <div class="form-group">
                            <label for="task-Owner" class="col-sm-3 control-label">Owner</label>

                            <div class="col-sm-6">
                                <input type="text" name="owner" id="task-owner" class="form-control" value="{{ old('task') }}">
                            </div>
                        </div>

                        <!-- Task Title -->
                        <div class="form-group">
                            <label for="task-title" class="col-sm-3 control-label">Title</label>

                            <div class="col-sm-6">
                                <input type="text" name="title" id="task-title" class="form-control" value="{{ old('task') }}">
                            </div>
                        </div>

                        <!-- Task Description -->
                        <div class="form-group">
                            <label for="task-description" class="col-sm-3 control-label">Description</label>

                            <div class="col-sm-6">
                                <input type="text" name="description" id="task-description" class="form-control" value="{{ old('task') }}">
                            </div>
                        </div>

                        <!-- Add Task Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default" id="button_task_submit_add">
                                    <i class="fa fa-btn fa-plus"></i>Add Task
                                </button>
                                <button type="button" class="btn btn-default" id="button_task_submit_update" style="display: none" onclick="update_task('{{ url('task')}}')">
                                    <i class="fa fa-btn fa-check"></i>Update Task
                                </button>
                                <button type="button" class="btn btn-default" id="button_task_submit_cancel" style="display: none" onclick="cancel_edit_of_task()">
                                    <i class="fa fa-btn fa-remove"></i>Cancel Edit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current Tasks -->
            @if (count($tasks) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Current Tasks
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped task-table">
                            <thead>
                                <th>Status</th>
                                <th>Owner</th>
                                <th>Task</th>
                                <th>Description</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                    <tr>
                                        <td><div class="dropdown">
                                            <button class="btn btn-{{ $task->status_color }} dropdown-toggle" type="button" data-toggle="dropdown">{{$task->status}}
                                            <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <li><a onclick="update_task('{{ url('task')}}', {{$task}}, 'Active')" href="#">Active</a></li>
                                                <li><a onclick="update_task('{{ url('task')}}', {{$task}}, 'On Hold')" href="#">On Hold</a></li>
                                                <li><a onclick="update_task('{{ url('task')}}', {{$task}}, 'Stuck')" href="#">Stuck</a></li>
                                                <li><a onclick="update_task('{{ url('task')}}', {{$task}}, 'Closed')" href="#">Closed</a></li>
                                            </ul>
                                        </div> </td>

                                        <td class="table-text"><div>{{ $task->owner }}</div></td>
                                        <td class="table-text"><div>{{ $task->title }}</div></td>
                                        <td class="table-text"><div>{{ $task->description }}</div></td>
                                        

                                        <td></td><td></td>

                                        <!-- Task Edit Button -->
                                        <td>                     

                                                <button type="button" class="btn btn-primary" onclick="display_edit_resources_for_task({{ $task }})">
                                                    <i class="fa fa-btn fa-pencil"></i>Edit
                                                </button>
                                       
                                        </td>

                                        <!-- Task Delete Button -->
                                        <td>
                                            <form action="{{ url('task/'.$task->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}

                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fa fa-btn fa-trash"></i>Delete
                                                </button>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection