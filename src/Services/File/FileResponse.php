<?php

namespace App\Services\File;

use App\Entity\Files\PrivateFile;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FileResponse
{

    // Services
    private $entityManager;
    private $params;

    // Data
    private $user;
    private $fileUser;
    private $id;
    private $originalName;
    private $patch;
    private $fileEntity;
    private $kernelDir;
    private $response;

    public function __construct(
        EntityManagerInterface $entityManager,
        ParameterBagInterface $params
    ) {
        $this->entityManager = $entityManager;
        $this->params = $params;
        $this->kernelDir = $this->params->get('kernel.project_dir');
    }

    public function create($id, $user) {
        try {
            $this->id = $id;
            $this->user = $user;
            $this->loadData();
            $this->checkUser();
            $this->createResponse();
            return $this->response;
        } catch (FileException $e) {
            throw new NotFoundHttpException('File not found.');
        }
    }

    protected function checkUser() {
        if (!$this->user || $this->fileUser->getId() != $this->user->getId()) {
            throw new NotFoundHttpException('File not found.');
        }
    }

    protected function createResponse() {
        $this->response = new BinaryFileResponse($this->kernelDir . $this->patch);
        $this->response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $this->originalName
        );
    }

    protected function loadData() {
        $this->fileEntity = $this->entityManager->getRepository(PrivateFile::class)->find($this->id);
        if (!$this->fileEntity) {
            throw new NotFoundHttpException('File not found.');
        }
        $this->originalName = $this->fileEntity->getOriginalName();
        $this->patch = $this->fileEntity->getUrl();
        $this->fileUser = $this->fileEntity->getUser();
    }

}