<?php

namespace Mvc\Models;

use Mvc\Entities\Person;
use Doctrine\ORM\EntityManager;

class PersonModel
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function findAll(array $filters = []): array
    {
        $repository = $this->entityManager->getRepository(Person::class);
        $queryBuilder = $repository->createQueryBuilder('p');
        
        if (!empty($filters['name'])) {
            $queryBuilder->where('LOWER(p.name) LIKE :name')
                       ->setParameter('name', '%' . mb_strtolower($filters['name']) . '%');
        }
        
        return $queryBuilder->getQuery()->getResult();
    }

    public function findById(int $id): ?Person
    {
        return $this->entityManager->find(Person::class, $id);
    }

    public function findByCpf(string $cpf): ?Person
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        $repository = $this->entityManager->getRepository(Person::class);
        return $repository->findOneBy(['cpf' => $cpf]);
    }

    public function create(array $data): Person
    {
        $person = new Person();
        $person->setName($data['name']);
        $person->setCpf($data['cpf']);

        $this->entityManager->persist($person);
        $this->entityManager->flush();

        return $person;
    }

    public function update(Person $person, array $data): Person
    {
        $person->setName($data['name']);
        $person->setCpf($data['cpf']);

        $this->entityManager->flush();

        return $person;
    }

    public function delete(Person $person): bool
    {
        try {
            $existingPerson = $this->entityManager->find(Person::class, $person->getId());
            if (!$existingPerson) {
                return false;
            }
            
            $this->entityManager->remove($existingPerson);
            $this->entityManager->flush();
            
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }


    public function isValidCpf(string $cpf): bool
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        
        if (strlen($cpf) !== 11) {
            return false;
        }
        
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
        
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        
        return true;
    }

    public function formatCpf(string $cpf): string
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        
        if (strlen($cpf) === 11) {
            return substr($cpf, 0, 3) . '.' . 
                   substr($cpf, 3, 3) . '.' . 
                   substr($cpf, 6, 3) . '-' . 
                   substr($cpf, 9, 2);
        }
        
        return $cpf;
    }

    public function cpfExists(string $cpf, ?int $excludeId = null): bool
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        $repository = $this->entityManager->getRepository(Person::class);
        
        $queryBuilder = $repository->createQueryBuilder('p')
            ->where('p.cpf = :cpf')
            ->setParameter('cpf', $cpf);
        
        if ($excludeId) {
            $queryBuilder->andWhere('p.id != :excludeId')
                        ->setParameter('excludeId', $excludeId);
        }
        
        return $queryBuilder->getQuery()->getOneOrNullResult() !== null;
    }

    public function getTotalCount(): int
    {
        $repository = $this->entityManager->getRepository(Person::class);
        return $repository->count([]);
    }
}
