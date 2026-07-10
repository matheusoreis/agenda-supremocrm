<?php

namespace SupremoCRM\Agenda\Http\Requests;

class ContactRequest
{
    public function validate($data)
    {
        $errors = [];

        if (empty(trim($data['name'] ?? ''))) {
            $errors['name'] = 'Nome é obrigatório.';
        }

        if (empty(trim($data['phone'] ?? ''))) {
            $errors['phone'] = 'Telefone é obrigatório.';
        }

        if (empty((int) ($data['state_id'] ?? 0))) {
            $errors['state_id'] = 'Estado é obrigatório.';
        }

        if (empty((int) ($data['city_id'] ?? 0))) {
            $errors['city_id'] = 'Cidade é obrigatória.';
        }

        return $errors;
    }

    public function validated($data)
    {
        return [
            'name' => trim($data['name']),
            'phone' => trim($data['phone']),
            'state_id' => (int) $data['state_id'],
            'city_id' => (int) $data['city_id']
        ];
    }
}
