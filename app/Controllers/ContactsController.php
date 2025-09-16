<?php

namespace Mvc\Controllers;

use Mvc\Views\Views;
use Mvc\Models\ContactModel;
use Doctrine\ORM\EntityManager;

class ContactsController extends BaseController
{
    private ContactModel $contactModel;
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->contactModel = new ContactModel($entityManager);
    }

    public function index()
    {
        $filters = [
            'person_name' => $_GET['person_name'] ?? '',
            'type' => $_GET['type'] ?? ''
        ];

        $contacts = $this->contactModel->findAll($filters);
        
        $data = [];
        foreach ($contacts as $contact) {
            $data[] = [
                'id' => $contact->getId(),
                'person_name' => $contact->getPerson()->getName(),
                'type' => $contact->getType(),
                'description' => $contact->getDescription()
            ];
        }

        Views::render('contacts.index', [
            'data' => $data,
            'personsChoices' => $this->contactModel->getPersonsForSelect()
        ]);
    }

    public function create()
    {
        $personsChoices = $this->contactModel->getPersonsForSelect();
        $selectedPersonId = $_GET['person_id'] ?? '';
        $redirectTo = $_GET['redirect'] ?? '';
        
        Views::render('contacts.create', [
            'personsChoices' => $personsChoices,
            'selectedPersonId' => $selectedPersonId,
            'redirectTo' => $redirectTo
        ]);
    }

    public function store()
    {
        $personId = (int)($_POST['person_id'] ?? 0);
        
        if ($personId <= 0) {
            $this->redirectWithError('/contacts/create', 'Pessoa é obrigatória!');
            return;
        }
        $contacts = [];
        if (isset($_POST['contacts']) && is_array($_POST['contacts'])) {
            foreach ($_POST['contacts'] as $contactData) {
                if (!empty($contactData['type']) && !empty($contactData['description'])) {
                    $contact = [
                        'type' => trim($contactData['type']),
                        'description' => trim($contactData['description']),
                        'person_id' => $personId
                    ];
                    
                    if (!$this->contactModel->isValidType($contact['type'])) {
                        $this->redirectWithError('/contacts/create', 'Tipo de contato inválido: ' . $contact['type']);
                        return;
                    }
                    
                    if (strlen($contact['description']) < 3) {
                        $this->redirectWithError('/contacts/create', 'Contato deve ter pelo menos 3 caracteres.');
                        return;
                    }
                    
                    if ($contact['type'] === 'Telefone') {
                        $contact['description'] = $this->removePhoneMask($contact['description']);
                    }
                    
                    $contacts[] = $contact;
                }
            }
        }

        if (empty($contacts)) {
            $singleType = trim($_POST['type'] ?? '');
            $singleDescription = trim($_POST['description'] ?? '');
            if (!empty($singleType) && !empty($singleDescription)) {
                $contact = [
                    'type' => $singleType,
                    'description' => $singleDescription,
                    'person_id' => $personId
                ];

                if (!$this->contactModel->isValidType($contact['type'])) {
                    $this->redirectWithError('/contacts/create', 'Tipo de contato inválido: ' . $contact['type']);
                    return;
                }

                if (strlen($contact['description']) < 3) {
                    $this->redirectWithError('/contacts/create', 'Contato deve ter pelo menos 3 caracteres.');
                    return;
                }

                if ($contact['type'] === 'Telefone') {
                    $contact['description'] = $this->removePhoneMask($contact['description']);
                }

                $contacts[] = $contact;
            }
        }

        if (empty($contacts)) {
            $this->redirectWithError('/contacts/create', 'Pelo menos um contato é obrigatório!');
            return;
        }

        $this->entityManager->beginTransaction();
        try {
            foreach ($contacts as $contactData) {
                $this->contactModel->create($contactData);
            }
            
            $this->entityManager->flush();
            $this->entityManager->commit();
            
            $message = count($contacts) . ' contato(s) criado(s) com sucesso!';
            
            $redirectTo = $_POST['redirect_to'] ?? '';
            if ($redirectTo === 'persons') {
                $this->redirectWithSuccess('/persons', $message);
            }
            
            $this->redirectWithSuccess('/contacts', $message);
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            $this->redirectWithError('/contacts/create', 'Erro ao salvar contatos: ' . $e->getMessage());
        }
    }

    public function edit(int $id)
    {
        $contact = $this->contactModel->findById($id);
        
        if (!$contact) {
            $this->redirectWithError('/contacts', 'Contato não encontrado!');
            return;
        }

        Views::render('contacts.edit', [
            'contact' => $contact,
            'validTypes' => $this->contactModel->getValidTypes()
        ]);
    }

    public function update(int $id)
    {
        $contact = $this->contactModel->findById($id);
        
        if (!$contact) {
            $this->redirectWithError('/contacts', 'Contato não encontrado!');
            return;
        }

        $data = [
            'type' => trim($_POST['type'] ?? ''),
            'description' => trim($_POST['description'] ?? '')
        ];

        if (empty($data['type']) || empty($data['description'])) {
            $this->redirectWithError("/contacts/edit/{$id}", 'Todos os campos são obrigatórios!');
            return;
        }

        if (!$this->contactModel->isValidType($data['type'])) {
            $this->redirectWithError("/contacts/edit/{$id}", 'Tipo de contato inválido!');
            return;
        }

        if ($data['type'] === 'Telefone') {
            $data['description'] = $this->removePhoneMask($data['description']);
        }

        try {
            $this->contactModel->update($contact, $data);
            $this->redirectWithSuccess('/contacts', 'Contato atualizado com sucesso!');
        } catch (\Exception $e) {
            $this->redirectWithError("/contacts/edit/{$id}", 'Erro ao atualizar contato');
        }
    }

    public function view(int $id)
    {
        $contact = $this->contactModel->findById($id);
        
        if (!$contact) {
            $this->redirectWithError('/contacts', 'Contato não encontrado!');
            return;
        }

        Views::render('contacts.view', ['contact' => $contact]);
    }

    public function delete(int $id)
    {
        $contact = $this->contactModel->findById($id);
        
        if (!$contact) {
            $this->redirectWithError('/contacts', 'Contato não encontrado!');
            return;
        }

        Views::render('contacts.delete', ['contact' => $contact]);
    }

    public function destroy(int $id)
    {
        $contact = $this->contactModel->findById($id);
        
        if (!$contact) {
            $this->redirectWithError('/contacts', 'Contato não encontrado!');
            return;
        }

        if ($this->contactModel->delete($contact)) {
            $this->redirectWithSuccess('/contacts', 'Contato excluído com sucesso!');
        } else {
            $this->redirectWithError('/contacts', 'Erro ao excluir contato');
        }
    }

    

    private function removePhoneMask(string $phone): string
    {
        return preg_replace('/\D/', '', $phone);
    }
}