<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\LogServiceInterface;
use App\Service\LogValidator;
use App\Service\LogValidatorInterface;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class LogController extends AbstractController
{
    public function __construct(private readonly LogServiceInterface   $logService,
                                private readonly LogValidatorInterface $logValidator) {}

    #[Route('/count', name: 'counter', methods: ['GET'])]
    public function count(Request $request): JsonResponse
    {
        try {
            $requestData = $this->logValidator->validate($request->query->all());
            return new JsonResponse([
                'counter' => $this->logService->countLogsByFilters($requestData),
            ]);
        } catch (InvalidArgumentException|\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage(), Response::HTTP_BAD_REQUEST]);
        }
    }

    #[Route('/delete', name: 'delete', methods: ['DELETE'])]
    public function delete(): Response
    {
        $this->logService->truncate();

        return new Response(Response::$statusTexts[Response::HTTP_NO_CONTENT], Response::HTTP_NO_CONTENT);
    }
}
