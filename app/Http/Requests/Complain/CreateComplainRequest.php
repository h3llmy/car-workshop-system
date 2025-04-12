<?php

namespace App\Http\Requests\Complain;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Complain;
use Illuminate\Validation\Rule;

class CreateComplainRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Complain::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description' => 'required',
            'repair_proposal_id' => [
                'required',
                Rule::exists('cars', 'id')->where(function ($query) {
                    $query->where('user_id', $this->user()->id);
                }),
            ]
        ];
    }
}
