<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;

class Debug extends AbstractController
{

    /**
     * @Route("/debug", methods={"GET"}, name="debug")
     */
    public function debug(Request $request)
    {
        return $this->json(['status' => 'ok' ]);
    }


}