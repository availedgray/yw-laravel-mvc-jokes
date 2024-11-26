<?php

namespace App\Http\Requests;

use App\Models\Joke;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RestoreJokeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $joke = Joke::withTrashed()->find($this->route('joke'));
        $user = Auth::user();

//        dd($joke);

        if (!$joke) {
            abort(404, 'joke not found');
        }

        return
//            $user->id === $joke->author_id ||
            $user->hasRole('Super-admin') ||
            $user->hasRole('Admin') ||
            $user->hasRole('Staff');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
