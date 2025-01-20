<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    use HasFactory;
    protected $fillable = ['name', 'description', 'priority', 'project_id', 'status'];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
