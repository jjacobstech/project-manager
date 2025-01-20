<?php

namespace App\Models;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
      use HasFactory;
      protected $fillable = ['name', 'description', 'user_id', 'type', 'project_img'];

      public function user()
      {
            return $this->belongsTo(User::class);
      }

      public function tasks()
      {
            return $this->hasMany(Task::class);
      }
}
