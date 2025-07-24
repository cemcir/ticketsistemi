<?php

namespace App\Http\Requests\Ticket;

use App\Http\Requests\BaseRequest;

class TicketUpdateRequest extends BaseRequest
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
            'ticketId'=>['required','integer'],
            'title'=>['required','string'],
            'description'=>['required','string'],
            'priority'=>['required','string']
        ];
    }
}
