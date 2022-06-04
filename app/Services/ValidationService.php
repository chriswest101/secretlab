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
            "mykey" => "required|max:255",
            "value" => "required|max:65535",
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
}