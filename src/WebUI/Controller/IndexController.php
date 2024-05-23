<?php
declare(strict_types=1);

namespace App\WebUI\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/')]
class IndexController extends AbstractController
{
    #[Route(path: '', name: 'homepage', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('index.html.twig', []);
    }
}
