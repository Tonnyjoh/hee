<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'auteur' => 'required|string|max:255',
            'date_publication' => 'required|date',
        ];

        if ($this->isMethod('POST')) {
            $rules['slug'] = 'nullable|string|max:255|unique:articles,slug';
        } else {
            $rules['slug'] = 'nullable|string|max:255|unique:articles,slug,' . $this->route('article');
        }

        return $rules;
    }

    /**
     * Messages d'erreur personnalisés
     */
    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre est obligatoire.',
            'titre.max' => 'Le titre ne peut pas dépasser 255 caractères.',
            'contenu.required' => 'Le contenu est obligatoire.',
            'auteur.required' => 'L\'auteur est obligatoire.',
            'auteur.max' => 'Le nom de l\'auteur ne peut pas dépasser 255 caractères.',
            'date_publication.required' => 'La date de publication est obligatoire.',
            'date_publication.date' => 'La date de publication doit être une date valide.',
            'slug.unique' => 'Ce slug est déjà utilisé par un autre article.',
        ];
    }
}
