@extends('layouts.app')

@section('content')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <a href="{{ url('task/create') }}"><button class="breadcrumb-item btn btn-primary">Add Task</button></a>
                
               
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small>Task List</small>
                </div>
            </div>
        </div>
    </div>


    <div class="body-content">
        <div class="card mb-4">
            <div class="card-header">
                
            </div>
            <div class="card-body">

                {{-- @component('backEnd.components.alert')
                @endcomponent --}}


                <div class="table-responsive">
                    <table id="datatable-extra" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User Name</th>
                                <th>Task</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>{{ $task->id }}</td>
                                    <td>{{ $task->user->name }}</td> <!-- Display user's name -->
                                    <td>{{ $task->task }}</td>
                                    <td>{{ $task->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    
@endsection
