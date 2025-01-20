<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            // image upload
            $project_img = $request->file('project_img');
            $imgName = null;
            if (!$project_img == null) {
                  $imgExtension = $project_img->getClientOriginalExtension();
                  $name = explode(' ', $request->project_name);
                  $imgName = time() . Str::random(25) . '.' . $imgExtension;

                  Storage::disk('custom')->putFileAs('project_images/', $project_img, $imgName, );
            }

            // project info
            $name = $request->project_name;
            $description = $request->description;
            $type = $request->type;
            $user_id = Auth::id();



            Project::create([
                  'name' => $name,
                  'description' => $description,
                  'user_id' => $user_id,
                  'type' => $type,
                  'project_img' => $imgName
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

            return to_route('dashboard', ['project' => $id])->with('message', 'updated');

      }

      public function update(Request $request, string $id)
      {

            $project = Project::where('id', '=', $id)->first();

            $id = $project->id;
            $current_img = $project->project_img;

            // image upload
            $project_img = $request->file('project_img');
            $imgName = null;


            if (!$project_img == null) {
                  $imgExtension = $project_img->getClientOriginalExtension();
                  $name = explode(' ', $request->project_name);
                  $imgName = time() . Str::random(25) . '.' . $imgExtension;

                  $file_exist = Storage::disk('custom')->exists('project_images/' . $project_img);
//     return $file_exist;
                  // if ($file_exist) {
                  //   let db = mongoose.connection    $delete = Storage::delete('project_images/' . $project_img);

                  //       return $delete;

                  //       Storage::disk('custom')->putFileAs('project_images/', $project_img, $imgName, );
                  }
return $file_exist;



            // $name = $request->project_name;
            // $description = $request->description;
            // $type = $request->type;




            // return $request->all();

            // $project = $project->update(attributes: [
            //       'name' => $name,
            //       'description' => $description,
            //       'type' => $type,
            //       'project_img' => $imgName
            // ]);

            // return to_route('project.show', ['project' => $id])->with('message', 'updated');

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
