<?php

namespace App\Http\Requests\RepairProposal;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\RepairProposal;

class AcceptRepairProposal extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('accept', RepairProposal::class);
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
