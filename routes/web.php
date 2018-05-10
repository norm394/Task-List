<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
use App\Task;
use Illuminate\Http\Request;

/*************************************************************************
 * Display All Tasks
 ************************************************************************/
Route::get('/', function () {
    $tasks = Task::orderBy('created_at', 'asc')->get();

    return view('tasks', [
        'tasks' => $tasks
    ]);
});

/*************************************************************************
 * Add A New Task
 ************************************************************************/
Route::post('/task/{id}', function (Request $request, $id) {

	// Validate that the required fields were filled.
	$validator = Validator::make($request->all(), [
        'owner' => 'required|max:255',
        'title' => 'required|max:255',
    ]);

    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }

    // -1 is Default id, thus a new task is to be created.
	if ($id == -1){

	    $task = new Task;
	    $task->status = "Active";
	    $task->status_color = "primary";
	    $task->owner = $request->owner;
	    $task->title = $request->title;
	    $task->description = $request->description;
	    $task->save();
	}
	// Else check if the id is in the database and update the values if so.
	else {

		$task = Task::findOrFail($id);
		if (!is_null($task)) {

			// Determine the correct status color based upon status text.
			$new_status_color = "primary";
			if ($request->status == "On Hold") {
				$new_status_color = "warning";
			}
			else if ($request->status == "Stuck") {
				$new_status_color = "danger";
			}
			else if ($request->status == "Closed") {
				$new_status_color = "success";
			}

			$task->update([
				'status' => $request->status,
				'status_color' => $new_status_color,
				'owner' => $request->owner,
				'title' => $request->title,
				'description' => $request->description
			]);
			
		}
		echo '';
	}
    return redirect('/');
});

/*************************************************************************
 * Delete An Existing Task
 ************************************************************************/
Route::delete('/task/{id}', function ($id) {
    Task::findOrFail($id)->delete();
    return redirect('/');
});

/*************************************************************************
 * Update An Existing Task
 ************************************************************************/
Route::patch('/task/{id}', function ($id) {
    Task::findOrFail($id)->delete();
    return redirect('/');
});
