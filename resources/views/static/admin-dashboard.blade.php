<x-app-layout xmlns="http://www.w3.org/1999/html">
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Yang Wang's {{ __('Joke DB') }}
        </h2>
    </x-slot>

    <article class="-mx-4">
        <header class="bg-zinc-700 text-zinc-200 rounded-t-lg -mx-4 -mt-8 p-8 text-2xl font-bold mb-8">
            <h2>Welcome {{ Auth::user()->name }}</h2>
            <p class="text-sm">{{ now() }}</p>
        </header>
{{--            <section class="p-6 text-neutral-900">--}}
{{--                {{ __("You're logged in!") }}--}}
{{--            </section>--}}
        </article>

        {{--Add colours used in the statistics in a hidden div to fool Tailwindcss--}}
        <div class="bg-red-400 bg-violet-400 bg-sky-400 bg-slate-400 hidden"></div>

        <section class="flex justify-between gap-8 pt-4">

            @foreach($statistics as $name=>$statistic)
                <div class="container mx-auto grow">
                    <a href="{{ $statistic["url"] }}" class="block">
                    <div
                        class=" bg-white max-w-xs mx-auto rounded-lg overflow-hidden shadow-lg hover:shadow-xl
                               transition duration-500 transform hover:scale-100 cursor-pointer min-h-32">
                        <div class="h-16 {{ $statistic["colour"] }} flex items-center justify-between">
                            <p class="mr-0 text-white text-xl font-bold tracking-wider pl-5">{{ $name }}</p>
                        </div>
                        <p class="py-4 text-3xl ml-5">{{ $statistic["data"] }}</p>
                        <!-- <hr > -->
                    </div>
                    </a>
                </div>
            @endforeach

        </section>
    </article>
</x-app-layout>
