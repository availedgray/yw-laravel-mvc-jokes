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

namespace App\Http\Requests;

use App\Models\Joke;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RemoveJokeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();
        $joke = Joke::withTrashed()->find($this->route('joke'));

        if (!$joke) {
            abort(404, 'joke not found');
        }

        return $user->id === $joke->author_id ||
            $user->hasRole('Super-admin') ||
            $user->hasRole('Admin') ||
            $user->hasRole('Staff');
    }

    public function rules(): array
    {
        return [
            //
        ];
    }
}
