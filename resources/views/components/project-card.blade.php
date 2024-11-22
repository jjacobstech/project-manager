<div class="overflow-hidden bg-gray-200 rounded shadow-lg">
    <a href="{{ route('project.show', ['project' => $project->id]) }}"></a>
    <div class="relative">
        <a href="{{ route('project.show', ['project' => $project->id]) }}">
            <img class="w-auto" src="{{ asset('rb_1741.png') }}" alt="project">
            <div
                class="absolute top-0 bottom-0 left-0 right-0 transition duration-300 bg-gray-900 opacity-25 hover:bg-transparent">
            </div>
        </a>

        <a href="{{ route('project.show', ['project' => $project->id]) }}">
            <div
                class="absolute top-0 right-0 flex flex-col items-center justify-center px-4 mt-3 mr-3 text-sm text-white transition duration-500 ease-in-out bg-white rounded-full w-11 h-11 hover:bg-white hover:text-black">
                <span class="text-sm font-bold text-teal-900">
                    <small>
                        {{ Str::title($project->status) }}
                    </small>
                </span>

            </div>
        </a>
    </div>
    <div class="px-6 py-4">
        <a href="{{ route('project.show', ['project' => $project->id]) }}"
            class="inline-block text-lg font-semibold transition duration-500 ease-in-out hover:text-teal-900">{{ $project->name }}</a>
        <p class="text-sm text-gray-500">
            {{ $project->description }}
        </p>
    </div>
    <div class="flex flex-row items-center px-6 py-4">
        <span href="#" class="flex flex-row items-center py-1 mr-1 text-sm text-gray-900 font-regular">
            <svg height="13px" width="13px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512"
                style="enable-background:new 0 0 512 512;" xml:space="preserve">
                <g>
                    <g>
                        <path d="M256,0C114.837,0,0,114.837,0,256s114.837,256,256,256s256-114.837,256-256S397.163,0,256,0z M277.333,256
    c0,11.797-9.536,21.333-21.333,21.333h-85.333c-11.797,0-21.333-9.536-21.333-21.333s9.536-21.333,21.333-21.333h64v-128
    c0-11.797,9.536-21.333,21.333-21.333s21.333,9.536,21.333,21.333V256z"></path>
                    </g>
                </g>
            </svg>
            <span class="ml-1">{{ $project->updated_at->locale('en')->diffForHumans() }}</span></span>
    </div>
</div>
