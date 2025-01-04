'user_id' => $user_id,
'type' => $type,
'project_img' => $project_img
]);


Storage::put('/uploads/project_images', $project_img);


return to_route('dashboard')->with('message', 'successful');
} catch (\Exception $e) {
return $e->getMessage();
}

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