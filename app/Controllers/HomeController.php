<?php

namespace Mvc\Controllers;

use Mvc\Views\Views;
use Mvc\Models\PersonModel;
use Mvc\Models\ContactModel;
use Doctrine\ORM\EntityManager;

class HomeController extends BaseController
{
    private PersonModel $personModel;
    private ContactModel $contactModel;

    public function __construct(EntityManager $entityManager)
    {
        $this->personModel = new PersonModel($entityManager);
        $this->contactModel = new ContactModel($entityManager);
    }

    public function index()
    {
        try {
            $totalPersons = $this->personModel->getTotalCount();
            $totalContacts = $this->contactModel->getTotalCount();
        } catch (\Exception $e) {
            $totalPersons = 0;
            $totalContacts = 0;
        }

        Views::render('home.index', [
            'totalPersons' => $totalPersons,
            'totalContacts' => $totalContacts
        ]);
    }
}
