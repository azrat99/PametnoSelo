@php
    use Illuminate\Support\Facades\Blade;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-welcome />
            </div>
        </div>
    </div> --}}

    @php
        $posts = App\Models\Post::get();

        $userReview = App\Models\Review::where('user_id', Auth::user()->id)->first();
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> 
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-3">
                <h1 style="padding-top: 10px; font-weight: bold;" class="font-xl mb-4 text-center">{{ __('All Posts') }}</h1>
                <hr />
                @if (session()->has('success'))
                    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                        <span class="font-medium">{{ session('success') }}</span> 
                    </div>
                @endif
                <div class="grid gap-8 lg:grid-cols-2 p-4">
                    @foreach ($posts as $post)
                        <article class="p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                            <div class="flex justify-between items-center mb-5 text-gray-500">
                                <span class="bg-primary-100 text-primary-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-primary-200 dark:text-primary-800">
                                    <svg class="mr-1 w-3 h-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"></path><path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z"></path></svg>
                                    Article
                                </span>
                                <span class="text-sm">{{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</span>
                            </div>
                            <h2 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $post->title }}</h2>
                            <p class="mb-5 font-light text-gray-500 dark:text-gray-400">{{ $post->description }}</p>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-4">
                                    <img class="w-7 h-7 rounded-full" src="{{ Storage::url($post->user->profile_photo_path) }}" alt="" />
                                    <span class="font-medium dark:text-white">
                                        {{ $post->user->name }}
                                    </span>
                                </div>
                                @if (Auth::user()->is_worker == 1 && $post->worker_id == NULL)
                                    <form action="{{ route('posts.acceptTask', $post) }}" method="POST">
                                        @csrf
                                        <x-button class="ml-4">
                                            {{ __('Accept the job') }}
                                        </x-button>
                                    </form>
                                @endif
                                @if (Auth::user()->is_worker == 1 && $post->worker_id != NULL && $post->status == 0)
                                    <form action="{{ route('posts.finishTask', $post) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <x-button class="ml-4">
                                            {{ __('Finish the job') }}
                                        </x-button>
                                    </form>
                                @endif
                                @if (Auth::user()->is_worker == 1 && $post->status == 1)
                                    {{ __('Job is finished') }}
                                @endif
                                @if (Auth::user()->is_worker != 1 && $post->status == 1 && !$userReview)
                                    <a href="{{ route('reviews.create') }}" class="inline-flex items-center font-medium text-primary-600 dark:text-primary-500 hover:underline">
                                        {{ __('Write a review') }}
                                        <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </a>
                                @endif
                                @if (Auth::user()->is_worker != 1 && $post->status == 1 && $userReview )
                                    <a href="{{ route('reviews.edit', $userReview) }}" class="inline-flex items-center font-medium text-primary-600 dark:text-primary-500 hover:underline">
                                        {{ __('Edit review') }}
                                        <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </a>
                                @endif
                            </div>
                        </article> 
                    @endforeach
                </div>  
            </div>
        </div>
    </div>
</x-app-layout>
