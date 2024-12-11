<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use AuthorizesRequests;
    /**
     *  secure user controller
     */
    function __construct(){
        $this->middleware('password.confirm');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::latest()->paginate(5);
        $trashedCount = User::onlyTrashed()->latest()->get()->count();

        return view('users.index',compact('data', 'trashedCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
//        Gate::authorize('create user');
        $this->authorize('create', User::class);

        $currentUser = Auth::user();
        $roles = [];

        if ($currentUser->hasRole('Super-Admin')) {
            $roles = Role::pluck('name', 'name')->all();
        } elseif ($currentUser->hasRole('Admin')) {
            $roles = Role::whereNotIn('name', ['Super-Admin'])->pluck('name', 'name')->all();
        } elseif ($currentUser->hasRole('Staff')) {
            $roles = Role::where('name', 'Client')->pluck('name', 'name')->all();
        }
        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:password_confirmation',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
//        Gate::authorize('view user', $user);
        $this->authorize('view', $user);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user):View
    {
        /*
         * Pluck is used to get just the "name" field from the Roles
         * This then is used to show the possible roles on the admin page
         * and allow the allocation of the role to the user.
         */
//        Gate::authorize('edit, restore and remove user', $user);
        $this->authorize('update', $user);
        $currentUser = Auth::user();
        $roles = [];

        if ($currentUser->hasRole('Super-Admin')) {
            $roles = Role::pluck('name', 'name')->all();
        } elseif ($currentUser->hasRole('Admin')) {
            $roles = Role::whereNotIn('name', ['Super-Admin'])->pluck('name', 'name')->all();
        } elseif ($currentUser->hasRole('Staff')) {
            $roles = Role::where('name', 'Client')->pluck('name', 'name')->all();
        }

        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user):RedirectResponse
    {
        /*
         * Validation may be completed in the method or in a UpdateUserRequest
         *
         * If we have an UpdateUserRequest the rules could be moved
         * into the file and the UpdateUserRequest would replace the
         * Request class in the pub func update().
         *
         * Also if this is done, you need to make sure authorize()
         * returns true. You could also check to see if the user is
         * logged in and return true when they are.
         */
        $this->authorize('update', $user);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'same:password_confirmation',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
//            $input = Arr::except($input, array('password'));
            $input = Arr::except($input, ['password']);
        }

//        $user = User::find($id);
        $user->update($input);
//        DB::table('model_has_roles')->where('model_id', $id)->delete();
//        $user->admin->assignrole($request->input('roles'));
        $user->syncRoles($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
//        User::find($id)->delete();
        $this->authorize('delete', $user);
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }

    /**
     * Add soft deletes feature
     */
    public function trash()
    {
        $users = User::onlyTrashed()->paginate(5);
        return view('users.trash', compact(['users',]));
    }

    /**
     * restore a soft deleted user
     * @param $user
     * @return RedirectResponse
     */
    public function restore($user)
    {
//        $authUser = Auth::user();
//        $targetUser = User::onlyTrashed()->findOrFail($user);
        $user = User::onlyTrashed()->findOrFail($user);

        $this->authorize('restore', $user);

        $user->restore();

        return redirect()
            ->back()
            ->with('success', "Restored {$user->name}.");
    }

    /**
     * permanently delete a user
     * @param $user
     * @return RedirectResponse
     */
    public function remove($user)
    {
//        $authUser = Auth::user();
//        $targetUser = User::onlyTrashed()->findOrFail($user);
//        Gate::authorize('edit, restore and remove user', [$authUser, $targetUser]);
        $this->authorize('forceDelete', $user);

        $user = User::onlyTrashed()->findOrFail($user);
        $user->forceDelete();

        return redirect()
            ->back()
            ->with('success', "Permanently deleted {$user->name}.");
    }

    /**
     * recover all trash users
     * @return RedirectResponse
     */
    public function recoverAll()
    {
        $trashCount = User::onlyTrashed()->restore();

        return redirect()
            ->back()
            ->with('success', "Successfully recovered $trashCount users.");
    }

    /**
     * empty user trash
     * @return RedirectResponse
     */
    public function empty()
    {
        $trashCount = User::onlyTrashed()->forceDelete();

        return redirect()
            ->back()
            ->with('success', "Successfully emptied trash of $trashCount users.");
    }
}
