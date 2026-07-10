<?php

namespace SupremoCRM\Agenda\Http\Controllers;

use SupremoCRM\Agenda\Core\Controller;

use SupremoCRM\Agenda\Models\StateModel;
use SupremoCRM\Agenda\Models\CityModel;

use SupremoCRM\Agenda\Http\Requests\CityRequest;

class CityController extends Controller
{
    private CityModel $city;
    private StateModel $state;

    public function __construct()
    {
        $this->city = new CityModel();
        $this->state = new StateModel();
    }

    public function index()
    {
        $cities = $this->city->getAll();
        $this->view('pages/cities/index', ['cities' => $cities]);
    }

    public function create()
    {
        $states = $this->state->getAll();
        $this->view('pages/cities/create', ['states' => $states, 'errors' => []]);
    }

    public function store()
    {
        $request = new CityRequest();
        $errors = $request->validate($_POST);

        if (!empty($errors)) {
            $states = $this->state->getAll();
            $this->view('pages/cities/create', [
                'states' => $states,
                'errors' => $errors,
                'old' => $_POST
            ]);
            return;
        }

        $data = $request->validated($_POST);
        $this->city->create($data);

        header('Location: /cities');
        exit;
    }

    public function edit(int $id)
    {
        $city = $this->city->getById($id);

        if (!$city) {
            header('Location: /cities');
            exit;
        }

        $states = $this->state->getAll();
        $this->view('pages/cities/edit', ['city' => $city, 'states' => $states, 'errors' => []]);
    }

    public function update(int $id)
    {
        $request = new CityRequest();
        $errors = $request->validate($_POST);

        if (!empty($errors)) {
            $states = $this->state->getAll();
            $this->view('pages/cities/edit', [
                'city' => array_merge(['id' => $id], $_POST),
                'states' => $states,
                'errors' => $errors
            ]);
            return;
        }

        $data = $request->validated($_POST);
        $this->city->update($id, $data);

        header('Location: /cities');
        exit;
    }

    public function delete(int $id)
    {
        $this->city->delete($id);
        header('Location: /cities');
        exit;
    }
}
