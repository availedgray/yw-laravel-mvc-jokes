<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Joke;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class StaticController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function home()
    {
        $users = User::count();
        $categories = Category::count();
        $jokes = Joke::count();
        $random_joke = Joke::with(['category', 'author'])->inRandomOrder()->first();

        return view('static.home',compact('users', 'categories', 'jokes', 'random_joke'));
    }

    /**
     * display about view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function about()
    {
        return view('static.about');
    }

    /**
     * display contact view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function contact()
    {
        return view('static.contact');
    }

    /**
     * display admin dashboard
     * @return View
     */
    function admin(): View
    {
        $users = User::count();
        $roles = Role::count();
        $perms = Permission::count();
        $products = Joke::count();

        /* Recursive is a macro that has been added to the App Service Provider */

        $statistics = collect([
            "Users" => ['data' => $users, 'colour' => 'bg-red-400', 'url' => 'users'],
            "Roles" => ['data' => $roles, 'colour' => 'bg-violet-400', 'url' => 'admin/permissions'],
            "Perms" => ['data' => $perms, 'colour' => 'bg-sky-400', 'url' => 'admin/permissions'],
            "Jokes" => ['data' => $products, 'colour' => 'bg-slate-400', 'url' => 'jokes'],
        ]);
        return view('static.admin-dashboard', compact(['statistics']));
    }

//    public function guest()
//    {
//        return view('static.guest-dashboard');
//    }
}
