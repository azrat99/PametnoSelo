<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('dashboard') }}">
                {{ __('Dashboard') }} - 
                <a href="{{ route('reviews.create') }}">
                    {{ __('Reviews') }}
                </a> 
            </a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-2">
                    <form method="POST" action="{{ route('reviews.store') }}">
                        @csrf
                        <x-input id="worker_id" class="block mt-1 w-full" type="hidden" name="worker_id" value="{{ $post->worker->id }}" min="1" max="5" required autofocus readonly />
                        <div>
                            <x-label for="worker" value="{{ __('Worker') }}" />
                            <x-input id="worker" class="block mt-1 w-full" type="text" name="worker" value="{{ $post->worker->name }}" required autofocus readonly />
                        </div>
                        <div class="mt-4">
                            <x-label for="grade" value="{{ __('Grade') }}" />
                            <x-input id="grade" class="block mt-1 w-full" type="number" name="grade" :value="old('grade')" min="1" max="5" required autofocus />
                        </div>
                        <div class="mt-4">
                            <x-label for="description" value="{{ __('Description') }}" />
                            <textarea id="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="description" rows="5" placeholder="Write your review..." required autofocus></textarea>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Submit Review') }}
                            </x-button>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
    </div> 
</x-app-layout>