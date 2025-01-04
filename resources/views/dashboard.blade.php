<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Projects') }}

            <a href="{{ route('project.create') }}">
                <x-primary-button class="ms-3" wire:navigate>
                    {{ __('Add Project') }}
                </x-primary-button>
            </a>
        </h2>

    </x-slot>
    <div
        class="grid max-w-screen-xl grid-cols-1 gap-10 p-5 mx-auto sm:p-10 md:p-10 grid-col-6 md:grid-cols-4 sm:grid-cols-2">

        @if (empty($projects))
            <div class="grid grid-cols-1 gap-10 md:grid-cols-3 sm:grid-cols-2">
                <h1>No Project</h1>

            </div>
        @else
            @foreach ($projects as $project)
                <x-project-card :$project wire:navigate />
            @endforeach
        @endif
    </div>
    {{ Cache::put('Page', 'Home', 60) }}
</x-app-layout>
