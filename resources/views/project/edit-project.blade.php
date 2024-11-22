<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full">

            <h2 class="inline float-right text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">

                <a href="{{ route('project.show', ['project' => $project->id]) }}">
                    <button
                        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md ms-3 dark:bg-gray-200 dark:text-gray-800 hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-0 focus:ring-indigo-100 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        {{ __('Back') }}
                    </button>
                </a>
            </h2>
        </div>

    </x-slot>
    <div class="flex justify-center w-full ">
        <div
            class="justify-center w-full px-6 py-4 mt-10 overflow-hidden bg-white shadow-md sm:max-w-md dark:bg-gray-800 sm:rounded-lg">
            <form class="space-y-4" method="POST" action="{{ route('project.update', ['project' => $project->id]) }}">
                @csrf
                @method('PATCH')
                <div>
                    <x-input-label for="project_name" :value="__('Project Title')" />
                    <x-text-input type="text" name="project_name" id="project_name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                        placeholder="The Adams Project" value="{{ $project->name }}" required />
                </div>
                <div>
                    <label for="description"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                    <textarea max="10" type="text" name="description" id="description"
                        placeholder="The timeline is in danger and ELSA is after me . . . . . . . . ."
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                        required>{{ $project->description }} </textarea>
                </div>
                <div>
                    <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Project
                        Type</label>
                    <input type="text" name="type" id="type"
                        placeholder="e.g Media, Product Launch, Design, Development, Rebrand"
                        value="{{ $project->type }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                        required />
                </div>

                <div class="mt-3">
                    <x-primary-button>
                        Save
                    </x-primary-button>
                </div>

            </form>
        </div>

    </div>
</x-app-layout>
