<?php

namespace SupremoCRM\Agenda\Http\Requests;

/**
 * Request de Cidade.
 * 
 * Valida e sanitiza os dados recebidos para cidade
 */
class CityRequest
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

        if (empty((int) ($data['state_id'] ?? 0))) {
            $errors['state_id'] = 'Estado é obrigatório.';
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
            'state_id' => (int) $data['state_id']
        ];
    }
}
