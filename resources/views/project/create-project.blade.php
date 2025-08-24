<x-app-layout>
      @csrf
    <div class="flex justify-center w-full">
        <div
            class="w-full px-6 py-4 mt-20 overflow-hidden bg-teal-900 shadow-md justify-self-center sm:max-w-md dark:bg-gray-800 sm:rounded-lg">
            <form class="space-y-4" method="POST" action="{{ route('project.store') }}" enctype="multipart/form-data">
                @csrf
                <div>
                    <x-input-label for="project_name" :value="__('Project Title')" />
                    <x-text-input type="text" name="project_name" id="project_name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                        placeholder="The Adams Project" required />
                </div>
                <div>
                    <x-input-label for="description"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" :value="__('Description')" />
                    <textarea max="10" type="text" name="description" id="description"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-teal-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                        required> </textarea>
                </div>


                <div>
                    <x-input-label for="Type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        :value="__('Project Type')" />
                    <input type="text" name="type" id="type"
                        placeholder="e.g Media, Product Launch, Design, Development, Rebrand"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                        required />
                </div>

                <div>
                    <x-input-label for="description" :value="__('Project Image')"
                        class="block mb-2 text-sm font-medium text-gray-900" />
                    <input type="file" accept="image/*" name="project_img" id="description"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                </div>

                <div class="mt-3">
                    <x-primary-button>
                        Create Project
                    </x-primary-button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
