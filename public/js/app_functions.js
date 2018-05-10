$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

var current_task;

/*************************************************************************
 Edit button logic for changing visual of selected task. 
 ************************************************************************/
function display_edit_resources_for_task(task) {

	current_task = task;

	toggle_form_view("UPDATE");

	$("#task-owner").val(task.owner);
	$("#task-title").val(task.title);
	$("#task-description").val(task.description);

}

/*************************************************************************
 Cancel_Edit button logic for tasks.
 ************************************************************************/

function cancel_edit_of_task() {
 	toggle_form_view("ADD");
}
	
/*************************************************************************
 * Function to update task values. 
 ************************************************************************/
function update_task(url, task=-1, status=-1) {

	var current_task_id;

	// If a task was passed as a parameter use that task to fill data for
	// the ajax call.
	if (task != -1){
		current_task_id = task.id;
		data = {
			'status': status,
			'owner': task.owner,
			'title': task.title,
			'description': task.description
		};
	}
	// Else no task was passed in, use the global task that was stored when
	// a user selected the edit button.
	else {
		current_task_id = current_task.id;
		data = {
			'status': current_task.status,
			'owner': $("#task-owner").val(),
			'title': $("#task-title").val(),
			'description': $("#task-description").val()
		};
	}

	$.ajax({
	
		url: url+"/"+(current_task_id).toString(),
		type: 'post',
		data: data,
		success: function() {
			clear_form_fields();
			location.reload();
		},
		 error: function(jqXHR, textStatus, errorThrown) {
           
            //alert('Error: ' + textStatus + ' ' + errorThrown);
      }
	});

}

/*************************************************************************
 * Clears all inputs within the form.
 ************************************************************************/
function clear_form_fields() {

	$("#task-owner").val("");
	$("#task-title").val("");
	$("#task-description").val("");

}

/*************************************************************************
 * Displays/Hides and updates form contents based on wether a the user
 * is adding a new task or updating an old one.
 ************************************************************************/
function toggle_form_view(desired_view) {

	clear_form_fields();
	if (desired_view == "ADD") {
		$("#div_task_add_and_edit").text("Add Task");
		$("#button_task_submit_update").hide();
		$("#button_task_submit_cancel").hide();
 		$("#button_task_submit_add").show();

	}
	else if (desired_view == "UPDATE") {
		$("#div_task_add_and_edit").text("Update Task");
		$("#button_task_submit_add").hide();
		$("#button_task_submit_update").show();
		$("#button_task_submit_cancel").show();
	}

}