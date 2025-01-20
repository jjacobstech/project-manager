<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full">

            <h2 class="inline float-right text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">

                <a href="{{ route('task.show', ['task' => $task->id]) }}">
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
            class="justify-center w-full px-6 py-4 mt-10 overflow-hidden bg-teal-900 shadow-md sm:max-w-md sm:rounded-lg">
            <form class="space-y-4" method="POST" action="{{ route('task.update', ['task' => $task->id]) }}">
                @csrf
                @method('PATCH')
                <div>
                    <x-input-label for="task_name" :value="__('Task Title')" />
                    <x-text-input type="text" name="task_name" id="task_name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                        placeholder="Create new link" value="{{ $task->name }}" required />
                </div>

                <div>
                    <x-input-label for="task_description" :value="__('Task Description')" />
                    <textarea name="task_description" id="task_description"
                        class="bg-gray-50 border text-gray-900 text-sm   h-40  block w-full p-2.5   dark:placeholder-gray-400  border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        placeholder="Today in going to Create new link" required>{{ $task->description }}</textarea>
                </div>
                <div>
                    <x-input-label for="priority" :value="__('Priority')" />
                    <span class='text-white'><input
                            class="mr-2 bg-green-500 border border-green-900 rounded-lg hover:bg-green-100 focus:ring-green-500 focus:border-green-500 p-2.5 dark:bg-green-600 dark:border-green-500 checked:bg-green-500 hover:checked:bg-green-500"
                            type="radio" name="priority" value="low" id=""
                            {{ $task->priority == 'low' ? 'checked' : '' }}>Low</span>
                    <span class='text-white'><input
                            class="mr-2 bg-yellow-500 border border-yellow-300  rounded-lg focus:ring-yellow-500 hover:bg-yellow-100 focus:border-yellow-500 p-2.5 dark:bg-yellow-600 dark:border-yellow-500 checked:bg-yellow-500 hover:checked:bg-yellow-500"
                            type="radio" name="priority" value="medium" id=""
                            {{ $task->priority == 'medium' ? 'checked' : '' }}>Medium</span>
                    <span class='text-white'><input
                            class="mr-2 bg-red-500 border border-red-500 rounded-lg focus:ring-red-500 focus:border-red-500 p-2.5 dark:bg-red-600 dark:border-red-500 hover:bg-red-100 checked:bg-red-500 hover:checked:bg-red-500"
                            type="radio" name="priority" value="high" id=""
                            {{ $task->priority == 'high' ? 'checked' : '' }}>High</span>
                </div>
                <div>
                    <input type="hidden" name="project_id" id="project_id" value="{{ session('project_id') }}" />
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
