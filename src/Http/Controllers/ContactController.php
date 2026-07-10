<?php

namespace SupremoCRM\Agenda\Http\Controllers;

use SupremoCRM\Agenda\Core\Controller;
use SupremoCRM\Agenda\Models\ContactModel;
use SupremoCRM\Agenda\Models\StateModel;
use SupremoCRM\Agenda\Models\CityModel;
use SupremoCRM\Agenda\Http\Requests\ContactRequest;

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

    public function index()
    {
        $search = $_GET['search'] ?? null;

        $contacts = $this->contact->getAll($search);
        $states = $this->state->getAll();
        $cities = $this->city->getAll();

        $this->view('pages/contacts/index', [
            'contacts' => $contacts,
            'states' => $states,
            'cities' => $cities,
            'search' => $search
        ]);
    }

    public function create()
    {
        $states = $this->state->getAll();
        $this->view('pages/contacts/create', ['states' => $states, 'errors' => []]);
    }

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

        header('Location: /contacts');
        exit;
    }

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

        header('Location: /contacts');
        exit;
    }

    public function delete(int $id)
    {
        $this->contact->delete($id);
        header('Location: /contacts');
        exit;
    }

    public function search()
    {
        $search = $_GET['search'] ?? '';
        $contacts = $this->contact->getAll($search);
        $this->view('pages/contacts/_table_rows', ['contacts' => $contacts]);
    }

    public function getCities()
    {
        $stateId = $_GET['state_id'] ?? 0;
        $cities = $this->city->getByState($stateId);
        $this->json($cities);
    }
}
