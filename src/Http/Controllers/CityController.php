<?php

namespace SupremoCRM\Agenda\Http\Controllers;

use SupremoCRM\Agenda\Core\Controller;
use SupremoCRM\Agenda\Models\CityModel;
use SupremoCRM\Agenda\Models\StateModel;
use SupremoCRM\Agenda\Models\ContactModel;
use SupremoCRM\Agenda\Http\Requests\CityRequest;

require_once __DIR__ . '/../../Helpers/helpers.php';

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
        $search = $_GET['search'] ?? null;
        $page = (int) ($_GET['page'] ?? 1);
        $perPage = 20;

        $result = $this->city->getPaginated($search, $page, $perPage);

        $this->view('pages/cities/index', [
            'cities' => $result['data'],
            'total' => $result['total'],
            'page' => $result['page'],
            'lastPage' => $result['lastPage'],
            'perPage' => $result['perPage'],
            'search' => $search
        ]);
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

        $_SESSION['flash'] = 'Cidade criada com sucesso!';
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

        $_SESSION['flash'] = 'Cidade atualizada com sucesso!';
        header('Location: /cities');
        exit;
    }

    public function delete(int $id)
    {
        $this->city->delete($id);
        $_SESSION['flash'] = 'Cidade excluída com sucesso!';
        header('Location: /cities');
        exit;
    }

    public function import()
    {
        $states = $this->state->getAll();

        if (empty($states)) {
            $_SESSION['error'] = 'Primeiro importe os estados!';
            header('Location: /cities');
            exit;
        }

        $importados = 0;
        $existentes = 0;

        foreach ($states as $state) {
            $url = "https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$state['ibge_id']}/municipios";
            $cidades = fetch_api($url);

            if ($cidades === false) continue;
            if (!$cidades) continue;

            foreach ($cidades as $cidade) {
                $stmt = $this->city->getDb()->prepare("SELECT id FROM cities WHERE name = ? AND state_id = ?");
                $stmt->execute([$cidade['nome'], $state['id']]);

                if (!$stmt->fetch()) {
                    $this->city->create([
                        'name' => $cidade['nome'],
                        'state_id' => $state['id']
                    ]);
                    $importados++;
                } else {
                    $existentes++;
                }
            }
        }

        $_SESSION['flash'] = "Importação concluída! {$importados} cidades importadas, {$existentes} já existentes.";
        header('Location: /cities');
        exit;
    }
}
