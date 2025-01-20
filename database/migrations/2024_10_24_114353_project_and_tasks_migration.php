<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
      /**
       * Run the migrations.
       */
      public function up(): void
      {

            Schema::create('projects', function (Blueprint $table) {
                  $table->id();
                  $table->string('name');
                  $table->string('description');
                  $table->string('project_img');
                  $table->unsignedBigInteger('user_id');
                  $table->string('type');

                  $table->enum('status', ['pending', 'completed'])->default('pending');

                  $table->timestamps();

                  $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });

            Schema::create('tasks', function (Blueprint $table) {
                  $table->id();
                  $table->string('name');
                  $table->string('description');
                  $table->enum('priority', ['low', 'medium', 'high']);
                  $table->unsignedBigInteger('project_id');

                  $table->enum('status', ['pending', 'completed'])->default('pending');

                  $table->timestamps();

                  $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            });
      }

      /**
       * Reverse the migrations.
       */
      public function down(): void
      {
            Schema::dropIfExists('projects');
            Schema::dropIfExists('tasks');
      }
};