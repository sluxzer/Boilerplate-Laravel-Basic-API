<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;

class StoreUser extends FormRequest
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
        return [
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email',
            'name' => 'required',
            'password' => 'required'
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }

//    public function withValidator(Validator $validator): void
//    {
//        $validator->after(function (Validator $validator) {
//            dd($this->request);
//            if (!$this->validateCaptcha()) {
//                $validator->errors()->add('g-recaptcha-response', 'invalid');
//            }
//        });
//    }


    // Custom response
//    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
//    {
//        $response = new JsonResponse(['data' => [],
//            'meta' => [
//                'message' => 'The given data is invalid',
//                'errors' => $validator->errors()
//            ]], 422);
//
//        throw new \Illuminate\Validation\ValidationException($validator, $response);
//    }
}
