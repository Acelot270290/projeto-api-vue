<?php
// StoreKpiRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKpiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'variacao_percentual' => 'nullable|numeric',
        ];
    }
}
