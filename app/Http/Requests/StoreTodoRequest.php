<?php

namespace App\Http\Requests;

use App\Models\Todo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTodoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('todo_create');
    }

    public function rules()
    {
        return [
            'due_date' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
        ];
    }
}