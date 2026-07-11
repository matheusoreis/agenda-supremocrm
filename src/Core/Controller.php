<?php

namespace SupremoCRM\Agenda\Core;


/**
 * Base para os Controllers
 * 
 * Fornece métodos auxiliares para todos os controllers.
 */
class Controller
{
    /**
     * Renderiza uma view
     * 
     * Este método carrega uma view específica, captura seu conteúdo e o insere
     * dentro do layout principal da aplicação.
     * 
     * @param string $view Nome da view a ser renderizada
     * @param array $data Dados a serem passados para a view
     * 
     * @return void
     */
    protected function view(string $view, array $data = []): void
    {
        extract($data);

        ob_start();

        require __DIR__ . '/../../views/' . $view . '.php';

        $content = ob_get_clean();

        require __DIR__ . '/../../views/layouts/app.php';
    }

    /**
     * Retorna uma resposta em JSON
     * 
     * Define o header apropriado e encerra a execução após enviar a resposta.
     * 
     * @param array $data Dados a serem convertidos para JSON
     * 
     * @return void
     */
    protected function json(array $data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data);

        exit;
    }

    /**
     * Realiza um redirecionamento
     * 
     * Envia um header de localização para o navegador redirecionar
     * para outra URL.
     * 
     * @param string $url URL de destino do redirecionamento
     * 
     * @return void
     */
    protected function redirect(string $url): void
    {
        header('Location: ' . $url);

        exit;
    }
}
