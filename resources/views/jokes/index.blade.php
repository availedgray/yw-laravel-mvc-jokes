<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Yang Wang's {{ __('Joke DB') }}
        </h2>
    </x-slot>


    <article class="-mx-4">
        <header
            class="bg-zinc-700 text-zinc-200 rounded-t-lg -mx-4 -mt-8 p-8 text-2xl font-bold flex flex-row items-center">
            <h2 class="grow">
                Jokes (List)
            </h2>
            <div class="order-first">
                <i class="fa-solid fa-user min-w-8 text-white"></i>
            </div>
            <x-primary-link-button href="{{ route('jokes.create') }}"
                                   class="bg-zinc-200 hover:bg-zinc-900 text-zinc-800 hover:text-white">
                <i class="fa-solid fa-user-plus "></i>
                <span class="pl-4">Add Joke</span>
            </x-primary-link-button>

            {{--            add trash area--}}
            <a href="{{ route('jokes.trash') }}"
               class="bg-zinc-500 hover:bg-zinc-900 text-white hover:text-white mx-2 py-2 px-4 text-center rounded-md text-sm
                    @if($trashedCount>0)
                    text-white hover:bg-black bg-zinc-500
                    @else
                    text-white hover:bg-black bg-zinc-200
                    @endif
                    duration-300 ease-in-out transition-all space-x-2">
                <i class="fa fa-trash font-xl"></i>
                {{ $trashedCount }} {{ __('Deleted') }}
            </a>
        </header>

                    @auth
                        {{--            <x-flash-message :data="session()"/>--}}
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

                <section class="min-w-full items-center bg-zinc-50 border border-zinc-600 rounded overflow-hidden">

                    <table class="min-w-full text-left text-sm font-light text-surface dark:text-white">
                        <thead
                            class="border-b border-neutral-200 bg-zinc-800 font-medium text-white dark:border-white/10">
                        <tr>
                            <th scope="col" class="px-6 py-4">Title</th>
                            <th scope="col" class="px-6 py-4">Joke Text</th>
                            <th scope="col" class="px-6 py-4">Author</th>
                            <th scope="col" class="px-6 py-4">Category</th>
                            <th scope="col" class="px-6 py-4">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $joke)
                            <tr class="border-b border-zinc-300 dark:border-white/10">
                                <td class="whitespace-nowrap px-6 py-4">{{ $joke->title }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ $joke->text }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ $joke->author->name ?? 'Unknown Author' }}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{ $joke->category->name ?? 'Uncategorized' }}</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <form action="{{ route('jokes.destroy', $joke) }}"
                                          method="POST"
                                          class="flex gap-4">
                                        @csrf
                                        @method('DELETE')

                                    <x-primary-link-button href="{{ route('jokes.show', $joke) }}"
                                                           class="bg-zinc-800">
                                        <span>Show </span>
                                        <i class="fa-solid fa-eye pr-2 order-first"></i>
                                    </x-primary-link-button>

                                    <x-primary-link-button href="{{ route('jokes.edit', $joke) }}"
                                                           class="bg-zinc-800">
                                        <span>Edit </span>
                                        <i class="fa-solid fa-edit pr-2 order-first"></i>
                                    </x-primary-link-button>

                                    <x-secondary-button type="submit"
                                                        class="bg-zinc-200">
                                        <span>Delete</span>
                                        <i class="fa-solid fa-times pr-2 order-first"></i>
                                    </x-secondary-button>

                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                        <tfoot>
                        <tr class="bg-zinc-100">
                            <td colspan="5" class="px-6 py-2">
                                @if( $data->hasPages() )
                                    {{ $data->links() }}
                                @elseif( $data->total() === 0 )
                                    <p class="text-xl">No jokes found</p>
                                @else
                                    <p class="py-2 text-zinc-800 text-sm">All jokes shown</p>
                                @endif
                            </td>
                        </tr>
                        </tfoot>

                    </table>

                </section>

            </section>

        </div>

    </article>
    </article>
</x-app-layout>
