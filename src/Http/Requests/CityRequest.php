<?php

namespace SupremoCRM\Agenda\Http\Requests;

class CityRequest
{
    public function validate(array $data)
    {
        $errors = [];

        if (empty(trim($data['name'] ?? ''))) {
            $errors['name'] = 'Nome é obrigatório.';
        }

        if (empty((int) ($data['state_id'] ?? 0))) {
            $errors['state_id'] = 'Estado é obrigatório.';
        }

        return $errors;
    }

    public function validated(array $data)
    {
        return [
            'name' => trim($data['name']),
            'state_id' => (int) $data['state_id']
        ];
    }
}
