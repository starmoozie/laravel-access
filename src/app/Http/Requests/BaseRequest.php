<?php

namespace Starmoozie\LaravelAccess\app\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    use \Starmoozie\LaravelAccess\app\Traits\HttpResponse;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                dd($this->model);
                return [
                    'id' => [
                        'sometimes',

                    ]
                ];
                break;

            default:
                # code...
                break;
        }
        if ($this->method() === 'DELETE') {
            return [
                'id' => [
                    'required',
                    'array'
                ]
            ];
        }

        return [
            //
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        foreach ((new ValidationException($validator))->errors() as $key => $error) {
            $errors[] = [
                'name'  => $key,
                'value' => implode(', ', $error)
            ];
        }

        throw new HttpResponseException(
            $this->failedMessage($errors, JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
