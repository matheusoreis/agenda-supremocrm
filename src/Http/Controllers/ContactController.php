<?php

namespace SupremoCRM\Agenda\Http\Controllers;

use SupremoCRM\Agenda\Core\Controller;
use SupremoCRM\Agenda\Models\ContactModel;
use SupremoCRM\Agenda\Models\StateModel;
use SupremoCRM\Agenda\Models\CityModel;
use SupremoCRM\Agenda\Http\Requests\ContactRequest;

/**
 * Controller de Contatos.
 * 
 * Gerencia as operações relacionadas a contatos
 */
class ContactController extends Controller
{
    private ContactModel $contact;
    private StateModel $state;
    private CityModel $city;

    public function __construct()
    {
        $this->contact = new ContactModel();
        $this->state = new StateModel();
        $this->city = new CityModel();
    }

    /**
     * Lista todos os contatos com paginação.
     * 
     * @return void
     */
    public function index()
    {
        $search = $_GET['search'] ?? null;
        $page = (int) ($_GET['page'] ?? 1);
        $perPage = 10;

        $result = $this->contact->getPaginated($search, $page, $perPage);

        $this->view('pages/contacts/index', [
            'contacts' => $result['data'],
            'total' => $result['total'],
            'page' => $result['page'],
            'lastPage' => $result['lastPage'],
            'perPage' => $result['perPage'],
            'search' => $search
        ]);
    }

    /**
     * Exibe formulário de criação de contato.
     * 
     * @return void
     */
    public function create()
    {
        $states = $this->state->getAll();
        $this->view('pages/contacts/create', ['states' => $states, 'errors' => []]);
    }

    /**
     * Salva um novo contato.
     * 
     * @return void
     */
    public function store()
    {
        $request = new ContactRequest();
        $errors = $request->validate($_POST);

        if (!empty($errors)) {
            $states = $this->state->getAll();
            $this->view('pages/contacts/create', [
                'states' => $states,
                'errors' => $errors,
                'old' => $_POST
            ]);
            return;
        }

        $data = $request->validated($_POST);

        $this->contact->create($data);

        $_SESSION['flash'] = 'Contato criado com sucesso.';
        header('Location: /contacts');
        exit;
    }

    /**
     * Exibe formulário de edição de contato.
     * 
     * @param int $id ID do contato
     * 
     * @return void
     */
    public function edit(int $id)
    {
        $contact = $this->contact->getById($id);

        if (!$contact) {
            header('Location: /contacts');
            exit;
        }

        $states = $this->state->getAll();
        $cities = $this->city->getByState($contact['state_id']);

        $this->view('pages/contacts/edit', [
            'contact' => $contact,
            'states' => $states,
            'cities' => $cities,
            'errors' => []
        ]);
    }

    /**
     * Atualiza um contato.
     * 
     * @param int $id ID do contato
     * 
     * @return void
     */
    public function update(int $id)
    {
        $request = new ContactRequest();
        $errors = $request->validate($_POST);

        if (!empty($errors)) {
            $states = $this->state->getAll();
            $cities = $this->city->getByState((int) $_POST['state_id']);

            $this->view('pages/contacts/edit', [
                'contact' => array_merge(['id' => $id], $_POST),
                'states' => $states,
                'cities' => $cities,
                'errors' => $errors
            ]);
            return;
        }

        $data = $request->validated($_POST);
        $this->contact->update($id, $data);

        $_SESSION['flash'] = 'Contato atualizado com sucesso.';
        header('Location: /contacts');
        exit;
    }

    /**
     * Exclui um contato.
     * 
     * @param int $id ID do contato
     * 
     * @return void
     */
    public function delete(int $id)
    {
        $this->contact->delete($id);
        $_SESSION['flash'] = 'Contato excluído com sucesso.';
        header('Location: /contacts');
        exit;
    }

    /**
     * Retorna cidades de um estado via JSON.
     * 
     * @return void
     */
    public function getCities()
    {
        $stateId = $_GET['state_id'] ?? 0;
        $cities = $this->city->getByState($stateId);
        $this->json($cities);
    }
}
