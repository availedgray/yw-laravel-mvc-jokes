<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteJokeRequest;
use App\Models\Category;
use App\Models\Joke;
use App\Http\Requests\StoreJokeRequest;
use App\Http\Requests\UpdateJokeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JokeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        if ($keyword) {
            return $this->search($request);
        }

        $data = Joke::with(['category', 'author'])->paginate(5);
        return view('jokes.index', compact('data'));
    }


    /**
     * Search jokes based on keywords
     */
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        if (!$keyword) {
            return redirect()->route('jokes.index')->with('error', 'Please enter a keyword to search.');
        }

        $data = Joke::query()
            ->where('text', 'like', '%' . $keyword . '%')
            ->orWhere('title', 'like', '%' . $keyword . '%')
            ->orWhereHas('category', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->orWhereHas('author', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->paginate(5);

        return view('jokes.index', compact('data'));
    }

        /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('jokes.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJokeRequest $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'category' => 'nullable|string|max:255',
        ]);

        $input = $request->all();

        if (!empty($input['category'])) {
            $category = Category::where('category', $input['category'])->first();
            $input['category_id'] = $category ? $category->id : null;
        } else {
            $input['category_id'] = 1;
        }
        $input['author_id'] = auth()->user()->id;

        Joke::create($input);

        return redirect()->route('jokes.index')
            ->with('success', 'Joke created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Joke $joke)
    {
        return view('jokes.show', compact('joke'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Joke $joke)
    {
        $categories = Category::all();
        return view('jokes.edit', compact('joke', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJokeRequest $request, Joke $joke)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'category' => 'nullable|string|max:255',
        ]);

        $input = $request->all();

        if (!empty($input['category'])) {
            $category = Category::where('category', $input['category'])->first();
            $input['category_id'] = $category ? $category->id : null;
        } else {
            $input['category_id'] = 1;
        }

        $joke->update($input);

        return redirect()->route('jokes.index')
            ->with('success', 'Joke updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteJokeRequest $request, Joke $joke)
    {
        $joke->delete();

        return redirect()->route('jokes.index')
            ->with('success', 'Joke deleted successfully');
    }
}
