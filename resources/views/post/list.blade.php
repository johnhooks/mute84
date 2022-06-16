<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Audio Posts') }}
        </h2>
    </x-slot>

    {{-- <x-audio.visualizer /> --}}

    <div class="py-0 sm:py-12">
        <div class="mx-auto max-w-7xl pb-32 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-lg bg-white">
                <ul role="list" class="divide-y divide-gray-200">
                    @php
                        $now = Carbon\Carbon::now();
                    @endphp
                    @foreach ($posts as $post)
                        <li>
                            <a href="{{ route('posts.show', ['id' => $post->id]) }}">
                                <div class="block hover:bg-gray-50">
                                    <div class="flex items-center px-4 py-4 sm:px-6">
                                        <div class="flex w-full items-center justify-between">
                                            <div class="truncate">
                                                <div class="flex text-sm">
                                                    <p class="truncate font-medium text-indigo-600">{{ $post->title }}
                                                    </p>
                                                </div>
                                                <div class="mt-2 flex">
                                                    <div class="flex items-center text-sm text-gray-500">
                                                        <!-- Heroicon name: solid/user -->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                             class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400"
                                                             viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                  d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                                  clip-rule="evenodd" />
                                                        </svg>
                                                        <p>
                                                            {{ $post->user->name }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-0 ml-5 flex">

                                            </div>
                                            @if ($post->status == 'published')
                                                @php
                                                    $published_at = Carbon\Carbon::parse($post->published_at);
                                                @endphp
                                                <time datetime="{{ $published_at->format('Y-m-d\TH:i') }}"
                                                      class="flex-shrink-0 whitespace-nowrap text-sm text-gray-500">
                                                    Published
                                                    {{ $published_at->diffForHumans($now, ['syntax' => Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW]) }}
                                                </time>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
