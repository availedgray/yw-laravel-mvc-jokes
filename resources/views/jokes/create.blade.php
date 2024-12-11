<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Yang Wang's {{ __('Joke DB') }}
        </h2>
    </x-slot>

    <article class="-mx-4">
        <header class="bg-zinc-700 text-zinc-200 rounded-t-lg -mx-4 -mt-8 p-8 text-2xl font-bold flex flex-row items-center">
            <h2 class="grow">Add Joke</h2>
            <div class="order-first">
                <i class="fa-solid fa-plus min-w-8 text-white"></i>
            </div>
        </header>

        @auth
            <x-flash-message
                message="{{ session('success') }}"
                icon="fa-check-circle"
                type="Success"
                fgColour="text-green-500"
                bgColour="bg-green-500"
                fgText="text-green-700"
                bgText="bg-green-100"
            />
        @endauth

        <div class="flex flex-col flex-wrap my-4 mt-8">
            <section class="grid grid-cols-1 gap-4 px-4 mt-4 sm:px-8">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <label class="w-1/6 font-bold">Whoops!</label> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <section class="min-w-full items-center bg-zinc-50 border border-zinc-600 rounded overflow-hidden">
                    <form action="{{ route('jokes.store') }}" method="POST" class="flex flex-col gap-4">
                        @csrf

                        <div class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                            <header class="border-b border-neutral-200 bg-zinc-800 font-medium text-white dark:border-white/10">
                                <p class="col-span-1 px-6 py-4">Enter Joke Details</p>
                            </header>

                            <section class="py-4 px-6 border-b border-neutral-200 bg-white font-medium text-zinc-800 dark:border-white/10">

                                {{-- Joke Title --}}
                                <div class="flex flex-col my-2">
                                    <x-input-label for="title">Joke Title</x-input-label>
                                    <x-text-input id="title" name="title" value="{{ old('title') }}" />
                                    <x-input-error :messages="$errors->get('title')" class="mt-2"/>
                                </div>

                                {{-- Category --}}
                                <div class="flex flex-col my-2">
                                    <x-input-label for="category_id">Category</x-input-label>
                                    <select id="category_id" name="category_id" class="rounded-md shadow-sm border-gray-300">
                                        <option value="" selected>-- Select a category --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('category_id')" class="mt-2"/>
                                </div>

                                <div class="flex flex-col my-2">
                                    <x-input-label for="text">Joke Content</x-input-label>
                                    <textarea id="text" name="text" rows="5" class="rounded-md shadow-sm border-gray-300"></textarea>
                                    <x-input-error :messages="$errors->get('text')" class="mt-2"/>
                                </div>

                            </section>

                            <footer class="flex gap-4 px-6 py-4 border-b border-neutral-200 font-medium text-zinc-800 dark:border-white/10">
                                <x-primary-link-button href="{{ route('jokes.index') }}" class="bg-zinc-800">
                                    Cancel
                                </x-primary-link-button>
                                <x-primary-button type="submit" class="bg-zinc-800">
                                    Save
                                </x-primary-button>
                            </footer>
                        </div>
                    </form>
                </section>
            </section>
        </div>
    </article>
</x-app-layout>
