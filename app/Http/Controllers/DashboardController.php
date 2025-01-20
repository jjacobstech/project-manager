<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
      public function index()
      {
            $projects = Project::whereBelongsTo(Auth::user())->get();

            return view('dashboard')->with('projects', $projects);

      }
}