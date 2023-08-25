@extends('layouts.app')

@section('content')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <button id="addTaskButton" class="breadcrumb-item btn btn-primary">Add Task</button>

                               
               
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

               


                <div class="table-responsive">
                    <table id="datatable-extra" class="table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>User Name</th>
                                <th>Task</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="taskList">
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $task->user->name }}</td> <!-- Display user's name -->
                                    <td>{{ $task->task }}</td>
                                    <td class="task-status">{{ $task->status }}</td>
                                    <td>
                                        @if($task->status == 'done')
                                            <button class="mark-pending" data-task-id="{{ $task->id }}">Mark as Pending</button>
                                        @else
                                            <button class="mark-done" data-task-id="{{ $task->id }}">Mark as Done</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Add Task Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTaskModalLabel">Add Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addTaskForm">
                    <div class="form-group">
                        <label for="task">Task</label>
                        <input type="text" class="form-control" id="task" name="task" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="closeModalButton" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitTask">Submit</button>
            </div>
        </div>
    </div>
</div>

    
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<script>


$(document).ready(function() {

    // Event handler to open the modal
    $('#addTaskButton').click(function() {
        $('#addTaskModal').modal('show'); // Manually open the modal
    });

    // Event handler for the close button
    $('#closeModalButton').click(function() {
        $('#addTaskModal').modal('hide'); // Manually close the modal
    });

    // Event handler for the submit button
    $('#submitTask').click(function() {
        var task = $('#task').val(); // Get the task from the form input

        // Perform AJAX request to submit the task data to your server
        $.ajax({
            url: '/api/todo/add', // Update with your API endpoint
            method: 'POST',
            data: {
                task: task,
                user_id: {{ Auth::user()->id }} // Use Auth::user()->id for user_id
            },
            headers: {
                'API_KEY': apiKey // Include your API_KEY
            },
            success: function(response) {
                // Handle the response here
                if (response.status === 1) {
                    // Close the modal
                    $('#addTaskModal').modal('hide');
                    
                    // Clear the input field
                    $('#task').val('');
                    var status = 'pending';
                    // Append a new row to the table with the task details
                    var newRow = '<tr>' +
                        '<td>' + response.task.id + '</td>' +
                        '<td>{{ Auth::user()->name }}</td>' + // Display user's name
                        '<td>' + response.task.task + '</td>' +
                        '<td class="task-status">' + status + '</td>' +
                        '<td>' +
                            '<button class="mark-done" data-task-id="' + response.task.id + '">Mark as Done</button>' +
                        '</td>' +
                    '</tr>';

                    $('#taskList').append(newRow);
                }
            },
            error: function(error) {
                // Handle any errors here, e.g., display an error message
                console.error(error);
            }
        });
    });



    var apiKey = 'helloatg'; // API_KEY
    // Event handler for marking as done or pending
    $(document).on('click', '.mark-done, .mark-pending', function() {
        var button = $(this);
        var taskId = button.data('task-id');
        var newStatus = button.hasClass('mark-done') ? 'done' : 'pending';
        var requestData = {
            task_id: taskId,
            status: newStatus
        };

        $.ajax({
            url: '/api/todo/status',
            method: 'POST',
            data: requestData,
            headers: {
                'API_KEY': apiKey // Includes the API_KEY in the request header
            },
            success: function(response) {
                // API response contains the updated status 1
                if (response.status === 1) {
                    // Update the status in the UI
                    button.closest('tr').find('.task-status').text(newStatus);
                    // Toggle the class and button text
                    button.toggleClass('mark-done mark-pending');
                    button.text(newStatus === 'done' ? 'Mark as Pending' : 'Mark as Done');
                }
            },
            error: function(error) {
                // Handle error, e.g., display an error message
            }
        });
    });
});


</script>