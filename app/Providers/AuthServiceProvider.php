<?php
/**
 * Assessment Title: Portfolio Part 2
 * Cluster:          SaaS: Part 1 – Front End Development
 * Qualification:    ICT50220 Diploma of Information Technology (Advanced Programming)
 * Name:             YANG WANG
 * Student ID:       20112222
 * Year/Semester:    2024/S2
 *
 * YOUR SUMMARY OF PORTFOLIO ACTIVITY
 * GOES HERE
 */


namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('view user', function (User $user, User $targetUser) {
            // Super-Admin can view all users
            if ($user->hasRole('Super-Admin')) {
                return true;
            }

            // Admin can view non-Admin and non-Super-admin users and their own information
            if ($user->hasRole('Admin') && (!$targetUser->hasAnyRole(['Admin', 'Super-Admin']) || $user->id === $targetUser->id)) {
                return true;
            }

            // Staff can only view Client users and their own information
            if ($user->hasRole('Staff') && (!$targetUser->hasRole(['Admin', 'Staff']) || $user->id === $targetUser->id)) {
                return true;
            }

            // Users can view their own information
            if ($user->id === $targetUser->id) {
                return true;
            }

            return false;
        });

        Gate::define('create user', function (User $user) {
            return $user->hasAnyRole(['Super-Admin', 'Admin', 'Staff']);
        });

        Gate::define('edit, restore and remove user', function (User $user, User $targetUser) {
            if ($user->hasRole('Super-Admin')) {
                return true;
            }

            if ($user->hasRole('Admin') && (!$targetUser->hasAnyRole(['Admin', 'Super-Admin']) || $user->id === $targetUser->id)) {
                return true;
            }

            if ($user->hasRole('Staff') && !$targetUser->hasRole(['Admin', 'Staff'])) {
                return true;
            }

            return false;
        });

        Gate::define('delete user', function (User $user, User $targetUser) {
            if ($user->hasRole('Super-Admin')) {
                return true;
            }

            if ($user->hasRole('Admin') && !$targetUser->hasRole('Admin')) {
                return true;
            }

            if ($user->hasRole('Staff') && !$targetUser->hasRole(['Admin', 'Staff'])) {
                return true;
            }

            return false;
        });

        // add soft deletes feature
        // User restore permission


        // User remove permission
        Gate::define('user-remove', function (User $authUser, User $targetUser) {
            return $authUser->can('user-remove') && $this->canOperateOn($authUser, $targetUser);
        });

        // User recover permission
        Gate::define('user-recover', function (User $authUser, User $targetUser) {
            return $authUser->can('user-recover') && $this->canOperateOn($authUser, $targetUser);
        });

    }
}



