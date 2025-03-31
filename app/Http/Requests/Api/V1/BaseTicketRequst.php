<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class BaseTicketRequst extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    
    public function mappedAttributes() {

        $attributeMap = [            
                'data.attributes.title' => 'title',
                'data.attributes.description' => 'description',
                'data.attributes.status' => 'status',
                'data.attributes.createdAt' => 'created_at',
                'data.attributes.updatedAt' => 'updated_at',
                'data.relationships.author.data.id' => 'user_id'
        ];
        
        $attributeToUpdate = [];
        foreach($attributeMap as $key => $attribute) {
            if($this->has($key)) {
                $attributeToUpdate[$attribute] = $this->input($key);
            }
        }
        return $attributeToUpdate;
    }


    public function messages()
    {
        return [
            'data.attributes.status' => 'The data.attributes.status is invalid. Please use A, C, H, X'
        ];
    }
}
