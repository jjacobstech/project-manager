<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">

            <a href="{{ route('project.show', ['project' => $task->project_id]) }}">
                <x-primary-button>
                    {{ __('Back') }}
                </x-primary-button>
            </a>

            <a href="{{ route('task.done', ['id' => $task->id]) }}">
                <x-primary-button>
                    {{ __('Done') }}
                </x-primary-button>
            </a>
            <a href="{{ route('task.not_done', ['id' => $task->id]) }}">
                <x-primary-button>
                    {{ __('Not Done') }}
                </x-primary-button>
            </a>
            <a href="{{ route('task.edit_page', ['id' => $task->id]) }}">
                <x-primary-button>
                    {{ __('Edit') }}
                </x-primary-button>
            </a>
            <a href="{{ route('task.delete', ['id' => $task->id]) }}">
                <x-primary-button>
                    {{ __('Delete') }}
                </x-primary-button>
            </a>
        </h2>
    </x-slot>
    <div class="flex justify-center w-full ">

        <div
            class="justify-center w-full px-6 py-4 mt-20 overflow-hidden bg-teal-900 shadow-md sm:max-w-md sm:rounded-lg">

            <div class="mt-5">
                <x-input-label for="task_name" :value="__('Title:')" />
                <p class="text-white">{{ $task->name }}</p>
            </div>
            <div class="mt-5">
                <x-input-label for="task_name" :value="__('Description:')" />
                <p class="text-white">{{ $task->description }}</p>
            </div>
            <div class="mt-5">
                <x-input-label for="task_name" :value="__('Priority:')" />
                @if ($task->priority == 'low')
                    <p
                        class='inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-green-500 border border-transparent rounded-md dark:bg-gray-200 dark:text-gray-800 hover:bg-green-300 hover:text-black dark:hover:bg-white focus:bg-green-700 dark:focus:bg-white active:bg-green-700 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800'>
                        {{ $task->priority }}
                    </p>
                @elseif ($task->priority == 'medium')
                    <button
                        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-yellow-500 border border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:border-gray-500 dark:text-gray-300 hover:bg-yellow-300 hover:text-black dark:hover:bg-gray-700 focus:outline-none active:bg-yellow-700 dark:focus:ring-offset-gray-800 disabled:opacity-25">
                        {{ $task->priority }}
                    </button>
                @else
                    <button
                        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-600 border border-transparent rounded-md hover:bg-red-300 hover:text-black active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-100 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        {{ $task->priority }}
                    </button>
                @endif

            </div>
            <div class="mt-5">
                <x-input-label for="task_name" :value="__('Status')" />
                <p class="text-white">{{ $task->status }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
