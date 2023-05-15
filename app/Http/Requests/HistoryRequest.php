<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class HistoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public function validator($factory)
    {
        return $factory->make(
            $this->sanitize(),
            $this->container->call([$this, 'rules']),
            $this->messages()
        );
    }

    public function sanitize()
    {
        $this->merge([
            'cities' => json_decode($this->input('cities'), true) ?? []
        ]);
        return $this->all();
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'cities' => 'required',
            'cities.*.city' => 'required|string',
            'cities.*.position' => 'required|array',
            'cities.*.position.lat' => 'required|numeric|between:-90,90',
            'cities.*.position.lng' => 'required|numeric|between:-180,180',
            'cities.*.humidity' => 'required|integer|between:0,100',
        ];
    }
    
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['errors' => $validator->errors()], 422)
        );
    }
}
