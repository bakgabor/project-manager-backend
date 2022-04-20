<?php

namespace App\Services\File;

use App\Entity\Files\BlobFile;
use App\Entity\Files\PrivateFile;
use App\Entity\Files\PublicFile;
use App\Entity\UploadsStatic;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class FileUpdate
{

    //Data
    private $type;
    private $originalName;
    private $fileName;
    private $file;
    private $user;
    private $extension;
    private $request;
    private $url;
    private $folder;
    private $patch;

    private $entity;

    // Services
    private $entityManager;
    private $params;

    public function __construct(
        EntityManagerInterface $entityManager,
        ParameterBagInterface $params
    ) {
        $this->entityManager = $entityManager;
        $this->params = $params;
    }

    public function saveFile() {
        $this->updateEntity();
        $this->moveFile();
        $this->entityManager->persist($this->entity);
        $this->entityManager->flush();
        return $this->entity;
    }

    public function checkPrivate() {
        if ($this->type == 'private') {
            $this->entity = new PrivateFile();
            $this->entity->setUser($this->user);
            $this->createPrivateUrl();
            return;
        }
        $this->createPublicUrl();
        $this->entity = new PublicFile();
    }

    public function setData(Request $request, $user) {
        $this->request = $request;
        $this->user = $user;
        $this->type = $request->get('type');
        $this->file = $request->files->get('file');
        $this->originalName = $this->file->getClientOriginalName();
        $this->getExtension();
        $this->createFileName();
        $this->checkPrivate();
        return $this;
    }

    private function moveFile() {
        try {
            $patch = $this->params->get('kernel.project_dir') . $this->patch;
            $this->file->move($patch, $this->fileName);
        } catch (FileException $e) {}
    }

    protected function updateEntity() {
        $this->entity->setTitle($this->request->get('title'))
            ->setUrl($this->url)
            ->setMimeType($this->file->getMimeType())
            ->setOriginalName($this->originalName)
            ->setDescription($this->request->get('description'))
            ->setKeywords($this->request->get('keywords'));
    }

    protected function getExtension() {
        $sections = explode(".", $this->originalName);
        $this->extension = $sections[count($sections) - 1];
    }

    protected function createPrivateUrl() {
        $this->folder = date("Y") . '/' . date("m");
        $this->patch = '/private/' . $this->folder . '/';
        $this->url = $this->patch . $this->fileName;
    }

    protected function createPublicUrl() {
        $this->folder = date("Y") . '/' . date("m");
        $patch = '/uploads/' . $this->folder . '/';
        $this->url = $patch . $this->fileName;
        $this->patch = '/public' . $patch;
    }

    protected function createFileName()
    {
        $filename = random_int(1, 10000).'-';
        $filename .= time();
        $this->fileName  .= $filename . '.' . $this->extension;

    }

}