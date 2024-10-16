<?php

namespace App\Controller;

use App\Entity\LogEntry;
use App\Repository\LogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LogController extends AbstractController
{
    private LogRepository $logRepository;

    public function __construct(LogRepository $logRepository)
    {
        $this->logRepository = $logRepository;
    }

    #[Route('/logs', name: 'app_logs')]
    public function index(): Response
    {
        $logs = $this->logRepository->findAll();

        return $this->render('log/index.html.twig', [
            'logs' => $logs,
        ]);
    }
}
