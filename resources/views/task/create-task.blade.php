@session('project_id')
    @isset($message)
        {{ $message }}
    @endisset
@endsession
<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full">

            <h2 class="inline float-right text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">

                <a href="{{ route('project.show', ['project' => $project_id]) }}">
                    <x-primary-button>
                        {{ __('Back') }}
                    </x-primary-button>
                </a>
            </h2>
        </div>

    </x-slot>
    <div class="flex justify-center w-full ">
        <div
            class="justify-center w-full px-6 py-4 mt-3 overflow-hidden bg-teal-900 shadow-md sm:max-w-md dark:bg-gray-800 sm:rounded-lg">
            <form class="space-y-4" method="POST" action="{{ route('task.store') }}">
                @csrf
                <div>
                    <x-input-label for="task_name" :value="__('Task Title')" />
                    <x-text-input type="text" name="task_name" :maxlength="30" id="task_name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                        placeholder="Create new link" required />
                </div>

                <div>
                    <x-input-label for="task_description" :value="__('Task Description')" />
                    <textarea type="textarea" name="task_description" id="task_description"
                        class="bg-gray-50 border text-gray-900 text-sm   h-40  block w-full p-2.5   dark:placeholder-gray-400  border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        placeholder="Today in going to Create new link" required></textarea>
                </div>
                <div>
                    <x-input-label for="description" :value="__('Documents')"
                        class="block mb-2 text-sm font-medium text-gray-900" />
                    <input max="10" type="file" multiple name="document[]" id="description"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                </div>
                <div>
                    <x-input-label for="priority" :value="__('Priority')" />
                    <span class="text-white"><input
                            class="mr-2 bg-green-500 border border-green-900 rounded-lg hover:bg-green-100 focus:ring-green-500 focus:border-green-500 p-2.5 dark:bg-green-600 text-green-500 dark:border-green-500 checked:bg-green-500 hover:checked:bg-green-500"
                            type="radio" name="priority" value="low" id="">Low</span>
                    <span class="text-white"><input
                            class="mr-2 bg-yellow-500 border border-yellow-300  rounded-lg focus:ring-yellow-500 hover:bg-yellow-100 focus:border-yellow-500 p-2.5 text-yellow-500 dark:bg-yellow-600 dark:border-yellow-500 checked:bg-yellow-500 hover:checked:bg-yellow-500"
                            type="radio" name="priority" value="medium" id="">Medium</span>
                    <span class="text-white"><input
                            class="mr-2 bg-red-500 border border-red-500 rounded-lg focus:ring-red-500 focus:border-red-500 p-2.5 dark:bg-red-600 dark:border-red-500 hover:bg-red-100 checked:bg-red-500 text-red-500 hover:checked:bg-red-500"
                            type="radio" name="priority" value="high" id="">High</span>
                </div>
                <div>
                    <input type="hidden" name="project_id" id="project_id" value="{{ session('project_id') }}" />
                </div>

                <div class="mt-3">
                    <x-primary-button>
                        Create Task
                    </x-primary-button>
                </div>

            </form>
        </div>

    </div>
</x-app-layout>
