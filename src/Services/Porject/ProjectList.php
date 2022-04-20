<?php

namespace App\Services\Porject;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;

class ProjectList
{

    // Services
    private $entityManager;

    // Data
    private $page;
    private $repository;

    private $interval = 30;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function geMainProjectList() {
        $this->repository = $this->entityManager->getRepository(Project::class);
        $projects = $this->repository->getMainList();
        return $projects;
    }

    public function getProjects($page, $userId = null) {
        $this->repository = $this->entityManager->getRepository(Project::class);

        $this->page = $page;
        $page = (intval($page) - 1) * intval($this->interval);
        $rowCount = $this->repository->getRowCount();
        $maxPage = intval(ceil($rowCount / $this->interval));

        if ($userId) {
            $projects = $this->repository->getList($page, $this->interval, $userId);
        } else {
            $projects = $this->repository->getList($page, $this->interval);
        }

        return [
            'maxPerPage' => $maxPage,
            'page' => $page,
            'maxResult' => $rowCount,
            'projects' => $projects
        ];
    }

    public function search($page, $text) {
        $this->repository = $this->entityManager->getRepository(Project::class);
        $words = explode(" ", $text);
        $projects = $this->repository->search($words);
        return [
            'maxPerPage' => 1,
            'page' => $page,
            'maxResult' => count($projects),
            'projects' => $projects
        ];
    }

}