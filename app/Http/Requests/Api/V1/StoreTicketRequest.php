<?php

namespace App\Http\Requests\Api\V1;

use App\Permissions\V1\Abilities;
use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends BaseTicketRequst
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'data.attributes.title' => 'required|string',
            'data.attributes.description' => 'required|string',
            'data.attributes.status' => 'required|string|in:A,C,H,X',
            'data.relationships.author.data.id' => 'required|integer|exists:users,id'
        ];

        $user = $this->user();

        if ($this->routeIs('tickets.store')) {
            if ($user->tokenCan(Abilities::CreateOwnTicket)) {
                $rules['data.relationships.author.data.id'] .= '|size:' . $user->id;
            }
        }

        return $rules;
    }

    protected function prepareForValidation() {
        if ($this->routeIs('authors.tickets.store')) {
            $this->merge([
                'author' => $this->route('author')
            ]);
        }
    }

}
