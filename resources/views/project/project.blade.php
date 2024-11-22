@php
    session(['project_id' => $project->id]);
@endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full mb-3">

            <h2 class="ml-3 text-xl font-semibold leading-tight text-gray-800 truncate dark:text-gray-200">
                {{ __($project->name) }}

            </h2>
            <b> &nbsp; : &nbsp;</b>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 truncate dark:text-gray-200">
                {{ __($project->description) }}

            </h2>

            {{-- <h2
                class="relative float-left text-xl font-semibold leading-tight text-gray-800 truncate dark:text-gray-200 ">
                {{ __($project->type) }}

            </h2> --}}

        </div>
        <div class="flex w-full">

            <h2 class="inline float-right text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">

                <a href="{{ route('dashboard') }}">
                    <x-primary-button class="ml-3">
                        {{ __('Back') }}
                    </x-primary-button>
                </a>
            </h2>

            <h2 class="inline float-right text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">

                <a href="{{ route('task.create') }}" wirre:navigate>
                    <x-primary-button class="ml-3">
                        {{ __('Create Task') }}
                    </x-primary-button>
                </a>
            </h2>
            <h2 class="inline float-right text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">

                <a href="{{ route('project.completed', ['id' => $project->id]) }}">
                    <x-primary-button class="ml-3">
                        {{ __('Completed') }}
                    </x-primary-button>
                </a>
            </h2>
            <h2 class="inline float-right text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">

                <a href="{{ route('project.edit', ['project' => $project->id]) }}">
                    <x-primary-button class="ml-3">
                        {{ __('Edit') }}
                    </x-primary-button>
                </a>
            </h2>

            <h2 class="inline float-right text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">

                <a href="{{ route('project.delete', ['id' => $project->id]) }}">
                    <x-primary-button class="ml-3">
                        {{ __('Delete') }}
                    </x-primary-button>
                </a>
            </h2>
        </div>
    </x-slot>

    <div class="">

        @if ($project->tasks->isEmpty())
            <h1 class='w-full mt-40 text-5xl font-bold text-center'>No Task Added</h1>
        @else
            <div
                class="grid max-w-screen-xl grid-cols-8 gap-10 p-5 mx-auto sm:p-10 md:p-10 md:grid-cols-6 sm:grid-cols-4">

                @foreach ($project->tasks as $project->task)
                    <div class="w-full px-6 ">
                        <div class="border">
                            <p class="uppercase truncate border-0">{{ $project->task->name }}
                            </p>

                            <a href="{{ route('task.show', ['task' => $project->task->id]) }}">
                                <p class="text-sm text-gray-500">
                                    @if ($project->task->priority == 'low')
                                        <p
                                            class='inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-green-500 border border-transparent rounded-md dark:bg-gray-200 dark:text-gray-800 hover:bg-green-300 hover:text-black dark:hover:bg-white focus:bg-green-700 dark:focus:bg-white active:bg-green-700 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800'>
                                            {{ $project->task->status }}
                                        </p>
                                    @elseif ($project->task->priority == 'medium')
                                        <button
                                            class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-yellow-500 border border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:border-gray-500 dark:text-gray-300 hover:bg-yellow-300 hover:text-black dark:hover:bg-gray-700 focus:outline-none active:bg-yellow-700 dark:focus:ring-offset-gray-800 disabled:opacity-25">
                                            {{ $project->task->status }}
                                        </button>
                                    @else
                                        <button
                                            class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-600 border border-transparent rounded-md hover:bg-red-300 hover:text-black active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-100 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                            {{ $project->task->status }}
                                        </button>
                                    @endif
                                </p>
                            </a>
                        </div>
                        <a href="{{ route('task.show', ['task' => $project->task->id]) }}">
                            <button
                                class="inline-flex items-center h-5 px-4 py-2 mt-3 text-xs font-semibold tracking-widest text-gray-700 uppercase transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm hover:bg-black hover:text-white focus:ring-0 dark:bg-gray-800 dark:border-gray-500 dark:text-gray-300 dark:hover:bg-gray-700 focus:outline-none focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25">
                                View
                            </button>

                        </a>
                        <a href="{{ route('task.update', ['task' => $project->task->id]) }}">
                            <button
                                class="inline-flex items-center h-5 px-4 py-2 mt-3 text-xs font-semibold tracking-widest text-gray-700 uppercase transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm hover:bg-black hover:text-white focus:ring-0 dark:bg-gray-800 dark:border-gray-500 dark:text-gray-300 dark:hover:bg-gray-700 focus:outline-none focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25">
                                Done
                            </button>

                        </a>
                        <a href="{{ route('task.delete', ['id' => $project->task->id]) }}" wire:navigate>
                            <button
                                class="inline-flex items-center h-5 px-4 py-2 mt-3 text-xs font-semibold tracking-widest text-gray-700 uppercase transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm hover:bg-black hover:text-white focus:ring-0 dark:bg-gray-800 dark:border-gray-500 dark:text-gray-300 dark:hover:bg-gray-700 focus:outline-none focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25">
                                Delete
                            </button>

                        </a>
                    </div>
                @endforeach
        @endif



    </div>

</x-app-layout>
