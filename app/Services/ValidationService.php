<?php

namespace App\Services;

use App\Rules\IsUnixTimestamp;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class ValidationService
{
    public function storeValidate(array $details): MessageBag
    {
        $rules = [
            "mykey" => "required|max:255|string",
            "value" => "required|max:65535|string",
        ];

        return Validator::make($details, $rules)->errors();
    }

    public function getValidate(array $details): MessageBag
    {
        $rules = [
            "timestamp" => [new IsUnixTimestamp],
        ];

        return Validator::make($details, $rules)->errors();
    }

    public function getKeyValuePair(array $details)
    {
        $key = array_key_first($details);
        $value = $details[$key];
        return [
            'mykey' => $key,
            'value' => $value,
        ];
    }
}