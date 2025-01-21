<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class questionRequest extends FormRequest
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
    public function rules()
    {
        $rules = [
            'questionType' => ['required', 'integer', 'in:1,2,3,4'], // Typ pytania
            'questionTitle' => ['required', 'string', 'max:255'], // Treść pytania
            'image' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];

        switch ($this->input('questionType')) {
            case 1: // ABCD (jedna poprawna)
                $rules['questionAnswers'] = ['required', 'string'];
                $rules['questionCorrectAnswer'] = [
                    'required',
                    'integer',
                    function ($attribute, $value, $fail) {
                        $answers = array_filter(array_map('trim', explode("\n", $this->input('questionAnswers'))));
                        if (!isset($answers[$value])) {
                            $fail('Poprawna odpowiedź musi być jedną z wprowadzonych opcji.');
                        }
                    },
                ];
                break;

            case 2: // ABCD (wiele poprawnych)
                $rules['questionAnswers'] = ['required', 'string'];
                $rules['questionCorrectAnswer'] = [
                    'required',
                    'array',
                    function ($attribute, $value, $fail) {
                        $answers = array_filter(array_map('trim', explode("\n", $this->input('questionAnswers'))));
                        if (count($value) < 2 || count($value) > 15) {
                            $fail('Liczba poprawnych odpowiedzi musi mieścić się w przedziale od 2 do 15.');
                        }
                        foreach ($value as $selected) {
                            if (!isset($answers[$selected])) {
                                $fail('Każda poprawna odpowiedź musi być jedną z wprowadzonych opcji.');
                            }
                        }
                    },
                ];
                break;

            case 3: // SELECT (wstaw w luki)
                $rules['questionTitle'] = ['required', 'string', function ($attribute, $value, $fail) {
                    if (!preg_match('/\[\$\]/', $value)) {
                        $fail('Treść pytania musi zawierać co najmniej jedną lukę oznaczoną jako [$].');
                    }
                }];

                foreach ($this->all() as $key => $value) {
                    if (preg_match('/^questionAnswers_(\d+)$/', $key, $matches)) {
                        $index = $matches[1]; // Pobieramy numer sekcji

                        // Walidacja odpowiedzi dla danego pola `questionAnswers_X`
                        $rules["questionAnswers_{$index}"] = ['required', 'string'];

                        // Walidacja poprawnej odpowiedzi dla danego pola `questionCorrectAnswer_X`
                        $rules["questionCorrectAnswer_{$index}"] = [
                            'required',
                            'integer', // Poprawna odpowiedź jest liczbą odpowiadającą indeksowi opcji
                            function ($attribute, $value, $fail) use ($key) {
                                $index = explode('_', $key)[1];
                                $answersKey = "questionAnswers_{$index}";
                                $answers = array_filter(array_map('trim', explode("\n", $this->input($answersKey))));

                                // Sprawdź, czy poprawna odpowiedź istnieje w opcjach
                                if (!isset($answers[$value])) {
                                    $fail("Poprawna odpowiedź w sekcji {$index} musi być jedną z wprowadzonych opcji.");
                                }
                            },
                        ];
                    }
                }


                break;

            case 4: // INPUT (wpisz wartość)
                $rules['questionCorrectAnswers'] = ['required', 'string'];
                break;
        }

        return $rules;
    }
}
