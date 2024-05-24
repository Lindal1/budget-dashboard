<?php
declare(strict_types=1);

namespace App\WebUI\Controller;

use App\Domain\Category\Entity\Category;
use App\Domain\Planing\Entity\Plan;
use App\Domain\Planing\Entity\Value;
use App\Domain\Planing\Repository\ValueRepositoryInterface;
use App\Domain\Planing\ValueObject\Month;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ValueController extends AbstractController
{
    #[Route(
        path: '/plan/{plan_uuid}/{category_uuid}/{month}/{year}/value/{value}',
        name: 'value_set',
        requirements: [
            'plan_uuid' => \Ramsey\Uuid\Uuid::VALID_PATTERN,
            'category_uuid' => \Ramsey\Uuid\Uuid::VALID_PATTERN,
            'month' => '\d{1,2}',
            'year' => '\d{4}',
            'value' => '[0-9]+(\.[0-9]+)?',
        ],
        methods: ['POST'],
    )]
    public function set(
        Plan                     $plan,
        Category                 $category,
        int                      $month,
        int                      $year,
        float                    $value,
        ValueRepositoryInterface $valueRepository,
    ): Response
    {
        $this->denyAccessUnlessGranted('update', $plan);
        $valueRepository->set(new Value(
            $plan,
            new Month($month, $year),
            $category,
            (int)($value * 100),
        ));

        return new Response();
    }
}
