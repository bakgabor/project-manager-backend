<?php

namespace App\Services\Porject;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;

class ProjectCreator
{

    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function create($data) {
        $project = new Project();
        $project->setName($data['name'])
            ->setKeywords($data['keywords']);

        $this->entityManager->persist($project);
        $this->entityManager->flush();
        return $project;
    }

    public function update($data) {
        $project = $this->entityManager->getRepository(Project::class)->find($data['id']);
        $project->setCoverImage($data['coverImage'])
            ->setMainProject($data['mainProject'])
            ->setKeywords($data['keywords'])
            ->setName($data['name'])
            ->setJsonData($data['jsonData']);
        $this->entityManager->persist($project);
        $this->entityManager->flush();
        return $project;
    }

}