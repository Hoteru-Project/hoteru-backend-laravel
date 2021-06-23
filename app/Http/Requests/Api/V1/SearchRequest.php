<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "checkIn"  => ["required", "string", "date_format:Y-m-d"],
            "checkOut" => ["required", "string", "date_format:Y-m-d"],
            "location" => ["required", "string"],
            "rooms"    => ["required", "integer", "min:1"],
            "filter"   => ["string"],
            "sorting"  => ["integer"],
        ];
    }
}
