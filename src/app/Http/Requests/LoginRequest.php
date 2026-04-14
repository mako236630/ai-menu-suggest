<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;
use App\Models\User;
use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;

class LoginRequest extends FortifyLoginRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "email" => "required|email",
            "password" => "required|string|min:8",
        ];
    }

    public function withValidator(Validator $validator)
    {
        if ($validator->failed()) {
            return;
        }

        $validator->after(function ($validator) {
            $user = User::where('email', $this->email)->first();

        if (!$user || !Hash::check($this->password, $user->password)) {
            $validator->errors()->add('email', 'ログイン情報が登録されていません');
        }
        });
    }

    public function messages(): array
    {
        return [
            "email.required" => "メールアドレスを入力してください",
            "email.email" => "メールアドレスはメール形式で入力してください",
            "password.required" => "パスワードを入力してください",
            "password.min" => "パスワードは8文字以上で入力してください",
        ];
    }
}
