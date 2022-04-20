<?php

namespace App\Controller\System;

use App\Services\System\LogSystem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;

class LogController extends AbstractController
{

    /**
     * @Route("/api/log", methods={"POST"}, name="app_log")
     */
    public function debug(
        Request $request,
        LogSystem $logSystem
    ) {
        $data = json_decode($request->getContent(), true);
        $logSystem->addLog($data);
        return $this->json(['status' => 'ok' ]);
    }

}