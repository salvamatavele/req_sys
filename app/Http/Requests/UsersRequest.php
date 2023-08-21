<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $user_id = isset(Request::segments()[2]) ? Request::segments()[2] : null;
        return [
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'max:25'],
            'email' => ['required', 'string', 'email', 'max:255', "unique:users,email," . $user_id],
            'password' => $user_id == null ? ['required', 'confirmed', Password::defaults()]:"nullable",
        ];
    }
}
