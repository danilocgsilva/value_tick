<?php

namespace App\Tests\Unit\Controller;

use App\Entity\Tick;
use App\Repository\TickRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Controller\TicksController;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TicksControllerTest extends TestCase
{
    private TicksController $controller;
    private TickRepository $repository;
    private EntityManagerInterface $em;
    private ContainerInterface $container;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(TickRepository::class);
        $this->em = $this->createMock(EntityManagerInterface::class);
        $this->container = $this->createMock(ContainerInterface::class);
        
        $this->controller = new TicksController();
        $this->controller->setContainer($this->container);
    }

    public function testIndex(): void
    {
        $ticks = [new Tick(), new Tick()];
        $this->repository->expects($this->once())
            ->method('findAll')
            ->willReturn($ticks);

        $response = $this->controller->index($this->repository);
        
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testShow(): void
    {
        $tick = new Tick();
        
        $response = $this->controller->show($tick);
        
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCreate(): void
    {
        $request = new Request([], [], [], [], [], [], json_encode([
            'value' => 10.5,
            'time' => '2023-01-01 12:00:00'
        ]));

        $this->em->expects($this->once())->method('persist');
        $this->em->expects($this->once())->method('flush');

        $response = $this->controller->create($request, $this->em);
        
        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testUpdate(): void
    {
        $tick = new Tick();
        $request = new Request([], [], [], [], [], [], json_encode([
            'value' => 15.0
        ]));

        $this->em->expects($this->once())->method('flush');

        $response = $this->controller->update($request, $tick, $this->em);
        
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDelete(): void
    {
        $tick = new Tick();

        $this->em->expects($this->once())->method('remove')->with($tick);
        $this->em->expects($this->once())->method('flush');

        $response = $this->controller->delete($tick, $this->em);
        
        $this->assertEquals(204, $response->getStatusCode());
    }
}