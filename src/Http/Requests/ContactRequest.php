<?php

namespace SupremoCRM\Agenda\Http\Requests;

/**
 * Request de Contato.
 * 
 * Valida e sanitiza os dados recebidos para contato
 */
class ContactRequest
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
            'phone' => trim($data['phone']),
            'state_id' => (int) $data['state_id'],
            'city_id' => (int) $data['city_id']
        ];
    }
}
