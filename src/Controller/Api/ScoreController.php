<?php
namespace App\Controller\Api;

use App\Entity\Score;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/score', name: 'api_score_')]
class ScoreController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em) {}

    #[Route('', name: 'get', methods: ['GET'])]
    public function getScore(): JsonResponse
    {
        $user = $this->getUser();
        $best = $this->em
            ->getRepository(Score::class)
            ->findOneBy(['user' => $user], ['value' => 'DESC']);

        return $this->json([
            'value' => $best?->getValue() ?? 0
        ]);
    }

    #[Route('', name: 'post', methods: ['POST'])]
    public function postScore(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $newValue = (int) ($data['value'] ?? 0);
        $user = $this->getUser();

        $best = $this->em
            ->getRepository(Score::class)
            ->findOneBy(['user' => $user], ['value' => 'DESC']);

        if (!$best || $newValue > $best->getValue()) {
            $score = new Score();
            $score->setUser($user);
            $score->setValue($newValue);
            // createdAt est déjà initialisé dans le constructeur
            $this->em->persist($score);
            $this->em->flush();
        }

        return $this->json(['status' => 'ok']);
    }
}
