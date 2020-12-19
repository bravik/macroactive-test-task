<?php

/**
 * @author Roman Naumenko <naumenko_subscr@mail.ru>
 */

declare(strict_types=1);

namespace App\Chat\Api;

use App\Chat\ReadModel\TopAuthors;
use App\Chat\Repository\MessageRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ChatController extends AbstractController
{

    /** @Route("/", methods={"GET"}) */
    public function index(MessageRepositoryInterface $messageRepository): JsonResponse
    {
        return $this->json([
            'messages' => $messageRepository->findAll(),
        ]);
    }

    /** @Route("/leaderboard", methods={"GET"}) */
    public function leaderboard(TopAuthors\Fetcher $topAuthorsFetcher): JsonResponse
    {
        return $this->json([
            'topAuthors' => $topAuthorsFetcher->getTopAuthors(),
            'topWriters' => $topAuthorsFetcher->getTopWriters(),
        ]);
    }
}
