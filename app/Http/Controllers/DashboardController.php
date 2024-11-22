<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $projects = Project::all();

        $projects = $projects->reverse();

        return view('dashboard')->with('projects', $projects);
    }
}