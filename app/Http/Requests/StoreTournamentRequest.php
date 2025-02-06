<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * @OA\Schema(
 *     schema="StoreTournamentRequest",
 *     type="object",
 *     required={"type", "gender", "players"},
 *     @OA\Property(property="type", type="string"),
 *     @OA\Property(property="gender", type="string"),
 *     @OA\Property(
 *         property="players",
 *         type="array",
 *         @OA\Items(
 *             type="object",
 *              @OA\Property(property="name", type="string", example="Test Name"),
 *             @OA\Property(property="skill", type="integer", example=80),
 *             @OA\Property(property="extra1", type="integer", example=10),
 *             @OA\Property(property="extra2", type="integer", example=5)
 *         )
 *     )
 * )
 */
class StoreTournamentRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:tournaments'],
            'gender' => ['required', 'string', Rule::in(['male', 'female'])],
            'type' => ['required', 'string', Rule::in(['single', 'double'])],
            'date' => ['required', 'date', 'date_format:Y-m-d'],
            'players' => [
                'required', 
                'array', 
                'min:2',
                // validar la cantidad de jugadores debe ser potencia de 2
                function ($attribute, $value, $fail) {
                    if (count($value) & (count($value) - 1))
                        $fail('La cantidad de jugadores debe ser potencia de 2');
                },
                function ($attribute, $value, $fail) {
                    foreach ($value as $player) {

                        $gender = $this->input('gender');
                        $countAttributes = ($gender === 'male') ? 4 : 3;

                        if (!is_array($player) || count($player) < $countAttributes || count($player) > 4) {
                            $fail("Cada jugador debe contener Nombre, habilidad, extra1 y extra2 (si es masculino)");
                            return;
                        }
                        if (!is_string($player[0])) {
                            $fail('El nombre del jugador debe ser un texto');
                            return;
                        }
                        if (!is_int($player[1]) || $player[1] < 0 || $player[1] > 100) {
                            $fail('El skill del jugador debe ser un número entero entre 0 y 100');
                            return;
                        }
                        if (!is_int($player[2])) {
                            $fail('El extra1 del jugador debe ser un número entero');
                            return;
                        }
                        if (!is_int($player[3] ?? 0)) {
                            $fail('El extra2 del jugador debe ser un número entero');
                            return;
                        }
                    }
                },
            ],
        ];
    }
    
    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 422));
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del torneo es requerido',
            'name.string' => 'El nombre del torneo debe ser un texto',
            'name.max' => 'El nombre del torneo debe tener máximo 255 caracteres',
            'name.unique' => 'El nombre del torneo ya existe',
            'gender.required' => 'El genero de los participantes del torneo es requerido',
            'gender.string' => 'El genero de los participantes del torneo debe ser un texto',
            'gender.in' => 'El genero de los participantes del torneo debe ser "male" o "female"',
            'type.required' => 'El tipo de torneo es requerido',
            'type.string' => 'El tipo de torneo debe ser un texto',
            'type.in' => 'El tipo de torneo debe ser "single" o "double"',
            'date.required' => 'La fecha del torneo es requerida',
            'date.date' => 'La fecha del torneo debe ser una fecha',
            'date.date_format' => 'La fecha del torneo debe tener el formato Y-m-d',
            'players.required' => 'La lista de jugadores es requerida',
            'players.array' => 'La lista de jugadores debe ser un arreglo',
            'players.min' => 'La lista de jugadores debe tener al menos 2 elementos',
        ];
    }
}
