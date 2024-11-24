<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Yang Wang's {{ __('Joke DB') }}
        </h2>
    </x-slot>

    <div class="space-y-8 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-neutral-900">
                    <p>Use this for flash messages</p>

                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-neutral-900">

                    <table class="table w-full">
                        <thead>
                        <tr class="bg-neutral-500 rounded-t-lg text-neutral-200">
                            <th class="p-2 text-left">Title</th>
                            <th class="p-2 text-left">Text</th>
                            <th class="p-2 text-left">Author</th>
                            <th class="p-2 text-left">Category</th>
                            <th class="p-2 text-right w-48">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $joke)
                            <tr class="text-sm">
                                <td class="px-2">{{ $joke->title }}</td>
                                <td class="px-2">{{ $joke->text }}</td>
                                <td class="px-2">{{ $joke->author->name ?? 'Unknown Author' }}</td>
                                <td class="px-2">{{ $joke->category->name ?? 'Uncategorized' }}</td>
                                <td class="px-2 text-right">
                                    <a class="btn btn-info" href="{{ route('jokes.show',$joke->id) }}">Show</a>
                                    <a class="btn btn-primary" href="{{ route('jokes.edit',$joke->id) }}">Edit</a>
                                    <a class="btn btn-success" href="{{ route('jokes.destroy',$joke->id) }}"> Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="4">{{ $data->links() }}</td>
                        </tr>
                        </tfoot>
                    </table>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
