<?php

namespace App\Controller;

use App\Entity\Tick;
use App\Repository\TickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class TicksController extends AbstractController
{
    #[Route('/ticks', name: 'ticks_index', methods: ['GET'])]
    public function index(TickRepository $repository): JsonResponse
    {
        $ticks = $repository->findAll();
        return $this->json($ticks);
    }

    #[Route('/ticks/{id}', name: 'ticks_show', methods: ['GET'])]
    public function show(Tick $tick): JsonResponse
    {
        return $this->json($tick);
    }

    #[Route('/ticks', name: 'ticks_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        $tick = new Tick();
        $tick->setValue($data['value']);
        $tick->setTime(new \DateTime($data['time']));
        
        $em->persist($tick);
        $em->flush();
        
        return $this->json($tick, 201);
    }

    #[Route('/ticks/{id}', name: 'ticks_update', methods: ['PUT'])]
    public function update(Request $request, Tick $tick, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        if (isset($data['value'])) $tick->setValue($data['value']);
        if (isset($data['time'])) $tick->setTime(new \DateTime($data['time']));
        
        $em->flush();
        
        return $this->json($tick);
    }

    #[Route('/ticks/{id}', name: 'ticks_delete', methods: ['DELETE'])]
    public function delete(Tick $tick, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($tick);
        $em->flush();
        
        return $this->json(null, 204);
    }
}
