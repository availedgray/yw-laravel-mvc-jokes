<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteJokeRequest;
use App\Http\Requests\RemoveJokeRequest;
use App\Http\Requests\RestoreJokeRequest;
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
        $trashedCount = Joke::onlyTrashed()->latest()->get()->count();

        return view('jokes.index', compact('data', 'trashedCount'));
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

    /**
     * Add soft deletes feature
     */
    public function trash()
    {
        $jokes = Joke::onlyTrashed()->paginate(5);
        return view('jokes.trash', compact(['jokes',]));
    }

    /**
     * restore a soft deleted joke
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
//        dd($joke);
        $joke = Joke::onlyTrashed()->findOrFail($id);

        $joke->restore();

        return redirect()
            ->back()
            ->with('success', "Restored {$joke->title}.");
    }

    /**
     * permanently delete a joke
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($id)
    {
        $joke = Joke::onlyTrashed()->findOrFail($id);
        $joke->forceDelete();

        return redirect()
            ->back()
            ->with('success', "Permanently deleted {$joke->title}.");
    }

    /**
     * recover all joke
     * @return \Illuminate\Http\RedirectResponse
     */
    public function recoverAll()
    {
        $trashCount = Joke::onlyTrashed()->restore();

        return redirect()
            ->back()
            ->with('success', "Successfully recovered $trashCount jokes.");
    }

    /**
     * empty joke trash
     * @return \Illuminate\Http\RedirectResponse
     */
    public function empty()
    {
        $trashCount = Joke::onlyTrashed()->forceDelete();

        return redirect()
            ->back()
            ->with('success', "Successfully emptied trash of $trashCount jokes.");
    }
}
