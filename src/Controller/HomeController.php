<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        // Si l'utilisateur n'est pas connecté, on le redirige vers la page de login
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        // Sinon, on affiche le template home/index.html.twig
        return $this->render('home/index.html.twig');
    }
}
