<?php

namespace SupremoCRM\Agenda\Http\Controllers;

use SupremoCRM\Agenda\Core\Controller;
use SupremoCRM\Agenda\Models\StateModel;
use SupremoCRM\Agenda\Models\ContactModel;
use SupremoCRM\Agenda\Models\CityModel;
use SupremoCRM\Agenda\Http\Requests\StateRequest;

require_once __DIR__ . '/../../Helpers/helpers.php';

/**
 * Controller de Estados.
 * 
 * Gerencia as operações relacionadas a estados
 */
class StateController extends Controller
{
    private StateModel $state;

    public function __construct()
    {
        $this->state = new StateModel();
    }

    /**
     * Lista todos os estados com paginação.
     * 
     * @return void
     */
    public function index()
    {
        $search = $_GET['search'] ?? null;
        $page = (int) ($_GET['page'] ?? 1);
        $perPage = 10;

        $result = $this->state->getPaginated($search, $page, $perPage);

        $this->view('pages/states/index', [
            'states' => $result['data'],
            'total' => $result['total'],
            'page' => $result['page'],
            'lastPage' => $result['lastPage'],
            'perPage' => $result['perPage'],
            'search' => $search
        ]);
    }

    /**
     * Exibe formulário de criação de estado.
     * 
     * @return void
     */
    public function create()
    {
        $this->view('pages/states/create', ['errors' => []]);
    }

    /**
     * Salva um novo estado.
     * 
     * @return void
     */
    public function store()
    {
        $request = new StateRequest();
        $errors = $request->validate($_POST);

        if (!empty($errors)) {
            $this->view('pages/states/create', ['errors' => $errors, 'old' => $_POST]);
            return;
        }

        $data = $request->validated($_POST);

        $ibgeId = $_POST['ibge_id'] ?? null;

        $this->state->create([
            'ibge_id' => $ibgeId,
            'name' => $data['name'],
            'abbreviation' => $data['abbreviation']
        ]);

        $_SESSION['flash'] = 'Estado criado com sucesso.';
        header('Location: /states');
        exit;
    }

    /**
     * Exibe formulário de edição de estado.
     * 
     * @param int $id ID do estado
     * 
     * @return void
     */
    public function edit(int $id)
    {
        $state = $this->state->getById($id);

        if (!$state) {
            header('Location: /states');
            exit;
        }

        $this->view('pages/states/edit', ['state' => $state, 'errors' => []]);
    }

    /**
     * Atualiza um estado.
     * 
     * @param int $id ID do estado
     * 
     * @return void
     */
    public function update(int $id)
    {
        $request = new StateRequest();
        $errors = $request->validate($_POST);

        if (!empty($errors)) {
            $this->view('pages/states/edit', [
                'state' => array_merge(['id' => $id], $_POST),
                'errors' => $errors
            ]);
            return;
        }

        $data = $request->validated($_POST);
        $this->state->update($id, $data);

        $_SESSION['flash'] = 'Estado atualizado com sucesso.';
        header('Location: /states');
        exit;
    }

    /**
     * Exclui um estado.
     * 
     * @param int $id ID do estado
     * 
     * @return void
     */
    public function delete(int $id)
    {
        $this->state->delete($id);
        $_SESSION['flash'] = 'Estado excluído com sucesso.';
        header('Location: /states');
        exit;
    }

    /**
     * Importa estados da API do IBGE.
     * 
     * @return void
     */
    public function import()
    {
        $estados = fetch_api('https://servicodados.ibge.gov.br/api/v1/localidades/estados');

        if ($estados === false) {
            $_SESSION['error'] = 'Erro ao buscar estados do IBGE.';
            header('Location: /states');
            exit;
        }

        if (!$estados) {
            $_SESSION['error'] = 'Nenhum estado encontrado na API.';
            header('Location: /states');
            exit;
        }

        $importados = 0;
        $existentes = 0;

        foreach ($estados as $estado) {
            $stmt = $this->state->getDb()->prepare("SELECT id FROM states WHERE ibge_id = ?");
            $stmt->execute([$estado['id']]);

            if (!$stmt->fetch()) {
                $this->state->create([
                    'ibge_id' => $estado['id'],
                    'name' => $estado['nome'],
                    'abbreviation' => $estado['sigla']
                ]);
                $importados++;
            } else {
                $existentes++;
            }
        }

        $_SESSION['flash'] = "Importação concluída. {$importados} estados importados, {$existentes} já existentes.";
        header('Location: /states');
        exit;
    }
}
