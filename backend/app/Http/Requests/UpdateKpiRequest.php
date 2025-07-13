<?php
// UpdateKpiRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKpiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => 'sometimes|required|string|max:255',
            'valor' => 'sometimes|required|numeric',
            'variacao_percentual' => 'nullable|numeric',
        ];
    }
}
