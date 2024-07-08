<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadExcelRequest extends FormRequest
{
    public function rules()
    {
        return [
            'file' => 'required|mimes:xlsx'
        ];
    }
}
