<?php

namespace SupremoCRM\Agenda\Http\Controllers;

use SupremoCRM\Agenda\Core\Controller;
use SupremoCRM\Agenda\Models\StateModel;
use SupremoCRM\Agenda\Http\Requests\StateRequest;

class StateController extends Controller
{
    private StateModel $state;

    public function __construct()
    {
        $this->state = new StateModel();
    }

    public function index()
    {
        $states = $this->state->getAll();
        $this->view('pages/states/index', ['states' => $states]);
    }

    public function create()
    {
        $this->view('pages/states/create', ['errors' => []]);
    }

    public function store()
    {
        $request = new StateRequest();
        $errors = $request->validate($_POST);

        if (!empty($errors)) {
            $this->view('pages/states/create', ['errors' => $errors, 'old' => $_POST]);
            return;
        }

        $data = $request->validated($_POST);
        $this->state->create($data);

        header('Location: /states');
        exit;
    }

    public function edit(int $id)
    {
        $state = $this->state->getById($id);

        if (!$state) {
            header('Location: /states');
            exit;
        }

        $this->view('pages/states/edit', ['state' => $state, 'errors' => []]);
    }

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

        header('Location: /states');
        exit;
    }

    public function delete(int $id)
    {
        $this->state->delete($id);
        header('Location: /states');
        exit;
    }
}
