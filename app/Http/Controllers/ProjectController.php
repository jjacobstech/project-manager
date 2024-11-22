<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
      /**
       * Display a listing of the resource.
       */
      public function index()
      {
            return view('project');
      }

      /**
       * Show the form for creating a new resource.
       */
      public function create()
      {
            return view('project.create-project');
      }




      /**
       * Store a newly created resource in storage.
       */
      public function store(Request $request)
      {

            $name = $request->project_name;
            $description = $request->description;
            $type = $request->type;
            $user_id = Auth::id();


            $project = Project::create(attributes: [
                  'name' => $name,
                  'description' => $description,
                  'user_id' => $user_id,
                  'type' => $type
            ]);

            return to_route('dashboard')->with('message', 'successful');

      }

      /**
       * Display the specified resource.
       */
      public function show(string $id)
      {
            $project = Project::where('id', '=', $id)->with('tasks')->first();
            if ($project === null) {
                  abort(404);
            }

            return view('project.project', ['project' => $project]);
      }

      /**
       * Show the form for editing the specified resource.
       */
      public function edit(string $id)
      {
            $project = Project::where('id', '=', $id)->first();

            return view('project.edit-project', ['project' => $project]);
      }

      /**
       * Update the specified resource in storage.
       */
      public function complete(string $id)
      {
            $project = Project::where('id', '=', $id)->first();


            $project = $project->update(attributes: [
                  'status' => 'completed'
            ]);

            return to_route('project.show', ['project' => $id])->with('message', 'updated');

      }

      public function update(Request $request, string $id)
      {
            $name = $request->project_name;
            $description = $request->description;
            $type = $request->type;

            $project = Project::where('id', '=', $id)->first();

            $project = $project->update(attributes: [
                  'name' => $name,
                  'description' => $description,
                  'type' => $type
            ]);

            return to_route('project.show', ['project' => $id])->with('message', 'updated');

      }

      /**
       * Remove the specified resource from storage.
       */
      public function delete(string $id)
      {
            $project = Project::where('id', '=', $id)->first();


            $project = $project->delete();

            return to_route('dashboard');
      }
}