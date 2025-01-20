<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
      /**
       * Display a listing of the resource.
       */
      public function index()
      {
            //
      }

      /**
       * Show the form for creating a new resource.
       */
      public function create()
      {
            $project_id = session('project_id');
            return view('task.create-task', ['project_id' => $project_id]);
      }

      /**
       * Store a newly created resource in storage.
       */
      public function store(Request $request)
      {
            $name = $request->task_name;
            $priority = $request->priority;
            $project_id = $request->project_id;
            $task_description = $request->task_description;

            // return $request->all();

            $task = Task::create([
                  'name' => $name,
                  'description' => $task_description,
                  'priority' => $priority,
                  'project_id' => $project_id
            ]);

            if (!$task) {
                  abort(500);
            }
            return to_route('project.show', $project_id)->with('message', 'Task added');
      }

      /**
       * Display the specified resource.
       */
      public function show(string $id)
      {
            $task = Task::where('id', $id)->first();
            return view('task.view-task', ['task' => $task]);
      }

      /**
       * Show the form for editing the specified resource.
       */
      public function edit_page(string $task)
      {
            $task = Task::where('id', $task)->first();

            return view('task.edit-task', ['task' => $task]);
      }

      public function edit(string $task)
      {
            return "edit  {$task}";
      }

      public function not_done(string $id)
      {

            $task = Task::where('id', '=', $id)->first();

            if (!$task) {
                  abort(500);
            }

            $completed = $task->update([
                  'status' => 'pending'
            ]);

            if ($completed) {
                  return to_route('task.show', ['task'=>$task->id]);
            }
      }

      public function update_status(string $id)
      {

            $task = Task::where('id', '=', $id)->first();

            if (!$task) {
                  abort(500);
            }

            $completed = $task->update([
                  'status' => 'completed'
            ]);

            if ($completed) {
                  return to_route('task.show', ['task'=> $task->id]);
            }

      }
      /**
       * Update the specified resource in storage.
       */
      public function update(Request $request, string $id)
      {

            $task = Task::where('id', '=', $id)->first();

            $name = $request->task_name;
            $priority = $request->priority;
            $description = $request->task_description;

            if (!$task) {
                  abort(500);
            }

            $completed = $task->update([
                  'name' => $name,
                  'description' => $description,
                  'priority' => $priority
            ]);

            if ($completed) {
                  return to_route('task.show', ['task' => $task->id]);
            } else {
                  abort(500);
            }

      }


      /**
       * Remove the specified resource from storage.
       */
      public function destroy(string $id)
      {
            $task = Task::where('id', '=', $id)->first();

            if (!$task) {
                  abort(500);
            }

            $completed = $task->delete();

            if ($completed) {
                  return to_route('project.show', $task->project_id);
            }
      }
}