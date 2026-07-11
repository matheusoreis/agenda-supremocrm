<?php

namespace SupremoCRM\Agenda\Http\Requests;

/**
 * Request de Estado.
 * 
 * Valida e sanitiza os dados recebidos para estado
 */
class StateRequest
{
    /**
     * Valida os dados da requisição.
     * 
     * @param array $data Dados a serem validados
     * 
     * @return array Lista de erros encontrados
     */
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

    /**
     * Retorna os dados validados e sanitizados.
     * 
     * @param array $data Dados originais
     * 
     * @return array Dados processados
     */
    public function validated(array $data)
    {
        return [
            'name' => trim($data['name']),
            'abbreviation' => strtoupper(trim($data['abbreviation']))
        ];
    }
}
