<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Yang Wang's {{ __('Joke DB') }}
        </h2>
    </x-slot>


    <article class="-mx-4">
        <header class="bg-zinc-700 text-zinc-200 rounded-t-lg -mx-4 -mt-8 p-8 text-2xl font-bold mb-8">
            <h2>Welcome</h2>
            <p class="text-sm">{{ now() }}</p>
        </header>

        <div class="flex flex-col flex-wrap my-4 mt-8">
            {{--placeholders only at this time--}}
        </div>

    </article>

</x-app-layout>
