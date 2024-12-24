<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatusSynchronizeRequest extends FormRequest
{
    public function prepareForValidation()
    {
        $this->replace([
            "lead_id" => $this->leads['status'][0]['id'] ?? null,
            "old_status_id" => $this->leads['status'][0]['old_status_id'] ?? null,
            "status_id" => $this->leads['status'][0]['status_id'] ?? null
        ]);
    }

    public function rules(): array
    {
        return [
            'lead_id' => ['required'],
            'old_status_id' => ['required'],
            'status_id' => ['required']
        ];
    }
}
