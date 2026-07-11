<?php

namespace SupremoCRM\Agenda\Http\Requests;

class StateRequest
{
    public function validate(array $data)
    {
        $errors = [];

        if (empty(trim($data['name'] ?? ''))) {
            $errors['name'] = 'Nome é obrigatório.';
        }

        if (empty(trim($data['abbreviation'] ?? ''))) {
            $errors['abbreviation'] = 'Sigla é obrigatória.';
        } elseif (strlen(trim($data['abbreviation'])) !== 2) {
            $errors['abbreviation'] = 'Sigla deve ter 2 caracteres.';
        }

        return $errors;
    }

    public function validated(array $data)
    {
        return [
            'name' => trim($data['name']),
            'abbreviation' => strtoupper(trim($data['abbreviation']))
        ];
    }
}
