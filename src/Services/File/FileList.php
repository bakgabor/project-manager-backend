<?php

namespace App\Services\File;

use App\Entity\Files\PublicFile;
use Doctrine\ORM\EntityManagerInterface;

class FileList
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

    public function loadRepository($class) {
        $this->repository = $this->entityManager->getRepository($class);
        return $this;
    }

    public function getFiles($page, $userId = null) {
        $this->page = $page;
        $page = (intval($page) - 1) * intval($this->interval);
        $rowCount = $this->repository->getRowCount();
        $maxPage = intval(ceil($rowCount / $this->interval));

        if ($userId) {
            $publicFiles = $this->repository->getList($page, $this->interval, $userId);
        } else {
            $publicFiles = $this->repository->getList($page, $this->interval);
        }

        return [
            'maxPerPage' => $maxPage,
            'page' => $page,
            'maxResult' => $rowCount,
            'files' => $publicFiles
        ];
    }

    public function search($page, $text) {
        $this->page = 1;
        $words = explode(" ", $text);
        $publicFiles = $this->repository->search($words);
        return [
            'maxPerPage' => 1,
            'page' => $page,
            'maxResult' => count($publicFiles),
            'files' => $publicFiles
        ];
    }

}