<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBigAffectationRequest extends FormRequest
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
            'utilisateur_id' => 'required|exists:utilisateurs,id',
            'materiel_ids' => 'required|array|min:1',
            'materiel_ids.*' => 'exists:materiels,id'
        ];
    }

    public function messages(): array
    {
        return [
            'utilisateur_id.required' => 'L\'utilisateur est requis',
            'utilisateur_id.exists' => 'L\'utilisateur sélectionné n\'existe pas',
            'materiel_ids.required' => 'Au moins un matériel doit être sélectionné',
            'materiel_ids.array' => 'Les matériels doivent être sous forme de tableau',
            'materiel_ids.min' => 'Au moins un matériel doit être sélectionné',
            'materiel_ids.*.exists' => 'Un ou plusieurs matériels sélectionnés n\'existent pas'
        ];
    }
}
