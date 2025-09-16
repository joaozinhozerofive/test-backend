<?php

namespace Mvc\Controllers;

use Mvc\Views\Views;
use Mvc\Models\PersonModel;
use Doctrine\ORM\EntityManager;

class PersonController extends BaseController
{
    private PersonModel $personModel;

    public function __construct(EntityManager $entityManager)
    {
        $this->personModel = new PersonModel($entityManager);
    }

    public function index()
    {
        $filters = [
            'name' => $_GET['name'] ?? ''
        ];

        $persons = $this->personModel->findAll($filters);
        
        $data = [];
        foreach ($persons as $person) {
            $data[] = [
                'id' => $person->getId(),
                'name' => $person->getName(),
                'cpf' => $person->getCpf(),
                'contacts_count' => $person->getContacts()->count()
            ];
        }

        Views::render('persons.index', ['data' => $data]);
    }

    public function create()
    {
        Views::render('persons.create');
    }

    public function store()
    {
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'cpf' => preg_replace('/[^0-9]/', '', trim($_POST['cpf'] ?? ''))
        ];

        if (empty($data['name']) || empty($data['cpf'])) {
            $this->redirectWithError('/persons', 'Todos os campos são obrigatórios!');
            return;
        }

        if (!$this->personModel->isValidCpf($data['cpf'])) {
            $this->redirectWithError('/persons', 'CPF inválido! Por favor, verifique o número digitado.');
            return;
        }

        if ($this->personModel->cpfExists($data['cpf'])) {
            $this->redirectWithError('/persons', 'Este CPF já está cadastrado no sistema!');
            return;
        }

        try {
            $person = $this->personModel->create($data);
            $this->redirectWithSuccess('/persons', 'Pessoa criada com sucesso!');
        } catch (\Exception $e) {
            $this->redirectWithError('/persons', 'Erro ao salvar no banco de dados');
        }
    }

    public function view(int $id)
    {
        $person = $this->personModel->findById($id);
        
        if (!$person) {
            $this->redirectWithError('/persons', 'Pessoa não encontrada!');
            return;
        }

        Views::render('persons.view', ['person' => $person]);
    }

    public function edit(int $id)
    {
        $person = $this->personModel->findById($id);
        
        if (!$person) {
            $this->redirectWithError('/persons', 'Pessoa não encontrada!');
            return;
        }

        Views::render('persons.edit', ['person' => $person]);
    }

    public function update(int $id)
    {
        $person = $this->personModel->findById($id);
        
        if (!$person) {
            $this->redirectWithError('/persons', 'Pessoa não encontrada!');
            return;
        }

        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'cpf' => preg_replace('/[^0-9]/', '', trim($_POST['cpf'] ?? ''))
        ];

        if (empty($data['name']) || empty($data['cpf'])) {
            $this->redirectWithError("/persons/edit/{$id}", 'Todos os campos são obrigatórios!');
            return;
        }

        if (!$this->personModel->isValidCpf($data['cpf'])) {
            $this->redirectWithError("/persons/edit/{$id}", 'CPF inválido! Por favor, verifique o número digitado.');
            return;
        }

        if ($this->personModel->cpfExists($data['cpf'], $id)) {
            $this->redirectWithError("/persons/edit/{$id}", 'Este CPF já está cadastrado para outra pessoa!');
            return;
        }

        try {
            $this->personModel->update($person, $data);
            $this->redirectWithSuccess('/persons', 'Pessoa atualizada com sucesso!');
        } catch (\Exception $e) {
            $this->redirectWithError("/persons/edit/{$id}", 'Erro ao atualizar pessoa');
        }
    }

    public function delete(int $id)
    {
        $person = $this->personModel->findById($id);
        
        if (!$person) {
            $this->redirectWithError('/persons', 'Pessoa não encontrada!');
            return;
        }

        Views::render('persons.delete', ['person' => $person]);
    }

    public function destroy(int $id)
    {
        $person = $this->personModel->findById($id);
        
        if (!$person) {
            $this->redirectWithError('/persons', 'Pessoa não encontrada!');
            return;
        }

        $contactsCount = $person->getContacts()->count();
        
        if ($this->personModel->delete($person)) {
            $message = 'Pessoa excluída com sucesso!';
            if ($contactsCount > 0) {
                $message .= " {$contactsCount} contato(s) associado(s) também foi(foram) excluído(s).";
            }
            $this->redirectWithSuccess('/persons', $message);
        } else {
            $this->redirectWithError('/persons', 'Erro ao excluir pessoa');
        }
    }
}