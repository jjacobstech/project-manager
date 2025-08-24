<x-app-layout>
    <x-slot name="header" x-data="{ open: true }">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200" x-show="open">
            {{ __('Projects') }}

            <a href="{{ route('project.create') }}" wire:navigate>
                <x-primary-button class="ms-3">
                    {{ __('Add Project') }}
                </x-primary-button>
            </a>
        </h2>

    </x-slot>

        @if ($projects->isEmpty())
            <div class="flex justify-center w-full ">
                <h1 class='mt-40 text-5xl font-bold text-center'>No Project</h1>
            </div>
        @else
            <div class="grid items-center max-w-screen-xl gap-10 p-5 mx-auto sm:p-10 md:p-10 grid-col-6 md:grid-cols-4 sm:grid-cols-2">

            @foreach ($projects as $project)
                <x-project-card :$project wire:navigate />
            @endforeach
      </div>
        @endif

</x-app-layout>
