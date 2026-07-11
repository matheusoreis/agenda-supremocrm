<?php

namespace SupremoCRM\Agenda\Http\Requests;

class ContactRequest
{
    public function validate(array $data)
    {
        $errors = [];

        if (empty(trim($data['name'] ?? ''))) {
            $errors[] = 'Nome é obrigatório.';
        }

        if (empty(trim($data['phone'] ?? ''))) {
            $errors[] = 'Telefone é obrigatório.';
        }

        if (empty((int) ($data['state_id'] ?? 0))) {
            $errors[] = 'Estado é obrigatório.';
        }

        if (empty((int) ($data['city_id'] ?? 0))) {
            $errors[] = 'Cidade é obrigatória.';
        }

        return $errors;
    }

    public function validated(array $data)
    {
        return [
            'name' => trim($data['name']),
            'phone' => trim($data['phone']),
            'state_id' => (int) $data['state_id'],
            'city_id' => (int) $data['city_id']
        ];
    }
}
