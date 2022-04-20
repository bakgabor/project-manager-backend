<?php

namespace App\Services\System;

use App\Entity\Log\Log;
use Doctrine\ORM\EntityManagerInterface;

class LogSystem
{

    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function addLog($data) {
        $log = new Log();
        $log->setJsonData($data);
        $this->entityManager->persist($log);
        $this->entityManager->flush();
    }

}