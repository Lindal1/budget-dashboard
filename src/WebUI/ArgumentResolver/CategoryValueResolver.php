<?php
declare(strict_types=1);

namespace App\WebUI\ArgumentResolver;

use App\Domain\Category\Entity\Category;
use App\Domain\Category\Repository\CategoryRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryValueResolver implements ValueResolverInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
    )
    {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if ($argument->getType() !== Category::class || !$request->attributes->has('category_uuid')) {
            return [];
        }

        $category = $this->categoryRepository->getByUuid(
            Uuid::fromString($request->attributes->get('category_uuid'))
        );

        if (!$category && !$argument->isNullable()) {
            throw new NotFoundHttpException(sprintf('Category %s not found', $request->attributes->get('category_uuid')));
        }

        yield $category;
    }
}
