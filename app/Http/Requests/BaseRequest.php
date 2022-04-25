<?php

namespace App\Http\Requests;

use Illuminate\Validation\ValidationException;

class BaseRequest
{
    /**
     *  A list of all post validation errors
     * @var array
     */
    protected $errors = [];

    /**
     * BaseRequest constructor.
     * @param string|integer|null $id
     * @throws ValidationException
     */
    public function __construct()
    {
        if (!isset($this->request)) {
            $this->request = app('request');
        }

        $this->validate();
    }

    /**
     * @throws ValidationException
     */
    public function validate()
    {
        $requestAll = method_exists($this, 'all') ? $this->all() : $this->request->all();
        $validator = \Validator::make($requestAll, $this->rules(), $this->messages(), $this->attributes());

        $pass = !empty($this->rules()) ? $validator->passes() : true;

        if (!$pass) {
            throw new ValidationException($validator);
        }

        $this->postValidate();

        if (!empty($this->errors)) {
            throw ValidationException::withMessages($this->errors);
        }
    }

    public function postValidate()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }

    public function attributes()
    {
        return [];
    }

    public function messages()
    {
        return [];
    }

    public function get($attr, $default = null)
    {
        return $this->request->input($attr, $default);
    }
}