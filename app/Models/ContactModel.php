<?php

namespace Mvc\Models;

use Mvc\Entities\Contact;
use Mvc\Entities\Person;
use Doctrine\ORM\EntityManager;

class ContactModel
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findAll(array $filters = []): array
    {
        $repository = $this->entityManager->getRepository(Contact::class);
        $queryBuilder = $repository->createQueryBuilder('c')
            ->leftJoin('c.person', 'p')
            ->addSelect('p');
        
        if (!empty($filters['person_name'])) {
            $queryBuilder->andWhere('LOWER(p.name) LIKE :personName')
                       ->setParameter('personName', '%' . mb_strtolower($filters['person_name']) . '%');
        }
        
        if (!empty($filters['type'])) {
            $queryBuilder->andWhere('LOWER(c.type) = :type')
                       ->setParameter('type', mb_strtolower($filters['type']));
        }
        
        return $queryBuilder->getQuery()->getResult();
    }

    public function findById(int $id): ?Contact
    {
        return $this->entityManager->find(Contact::class, $id);
    }


    public function create(array $data): Contact
    {
        $person = $this->entityManager->find(Person::class, $data['person_id']);
        
        if (!$person) {
            throw new \InvalidArgumentException('Pessoa não encontrada');
        }

        $contact = new Contact();
        $contact->setType($data['type']);
        $contact->setDescription($data['description']);
        $person->addContact($contact);
        
        $this->entityManager->persist($contact);

        return $contact;
    }

    public function update(Contact $contact, array $data): Contact
    {
        $contact->setType($data['type']);
        $contact->setDescription($data['description']);

        $this->entityManager->flush();

        return $contact;
    }

    public function delete(Contact $contact): bool
    {
        try {
            $this->entityManager->remove($contact);
            $this->entityManager->flush();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getValidTypes(): array
    {
        return [
            'Telefone' => 'Telefone',
            'Email' => 'Email'
        ];
    }

    public function isValidType(string $type): bool
    {
        return in_array($type, array_keys($this->getValidTypes()));
    }

    public function getTotalCount(): int
    {
        $repository = $this->entityManager->getRepository(Contact::class);
        return $repository->count([]);
    }

    public function getPersonsForSelect(): array
    {
        $repository = $this->entityManager->getRepository(Person::class);
        $persons = $repository->findAll();
        
        $choices = [];
        foreach ($persons as $person) {
            $choices[$person->getId()] = $person->getName();
        }
        
        return $choices;
    }
}
