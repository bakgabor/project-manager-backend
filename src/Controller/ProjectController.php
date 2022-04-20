<?php

namespace App\Controller;

use App\Entity\Project;
use App\Services\Porject\ProjectCreator;
use App\Services\Porject\ProjectList;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{

    /**
     * @Route("/api/project/create", methods={"POST"}, name="project_create")
     */
    public function createProject(
        Request $request,
        ProjectCreator $projectCreator
    ) {
        $data = json_decode($request->getContent(), true);
        return $this->json($projectCreator->create($data));
    }

    /**
     * @Route("/api/project/main", methods={"GET"}, name="main_project_list")
     */
    public function mainProjectList(ProjectList $projectList) {
        $projects = $projectList->geMainProjectList();
        return $this->json($projects);
    }


    /**
     * @Route("/api/project/list/{page}", methods={"GET"}, name="project_list")
     */
    public function projectList(ProjectList $projectList, $page) {
        $projects = $projectList->getProjects($page);
        return $this->json($projects);
    }

    /**
     * @Route("/api/project/search/{page}/{text}", methods={"GET"}, name="project_search")
     */
    public function projectSearch(ProjectList $projectList, $page, $text) {
        $text = base64_decode($text);
        return $this->json($projectList->search($page, $text));
    }

    /**
     * @Route("/api/project/update", methods={"POST"}, name="project_update")
     */
    public function updateProject(
        Request $request,
        ProjectCreator $projectCreator
    ) {
        $data = json_decode($request->getContent(), true);
        return $this->json($projectCreator->update($data));
    }

    /**
     * @Route("/api/project/data/{id}", methods={"GET"}, name="project_data")
     */
    public function getProject(EntityManagerInterface $entityManager, $id) {
        $data = $entityManager->getRepository(Project::class)->find($id);
        return $this->json($data);
    }

}