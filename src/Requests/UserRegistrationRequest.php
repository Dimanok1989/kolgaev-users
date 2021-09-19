<?php

namespace Kolgaev\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $users = config('auth.providers.users.model', \App\Models\User::class);

        return [
            'email' => "required|email|unique:{$users},email",
            'password' => 'required',
            'name' => 'required',
        ];

    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {

        /**
         * @var array $response Is our response data.
         */
        $response = [
            "message" => "Имеются ошибки в данных", // Here I used a custom message.
            "errors" => $validator->errors(), // And do not forget to add the common errors.
        ];

        // Finally throw the HttpResponseException.
        throw new HttpResponseException(response()->json($response, 422));

    }

}
