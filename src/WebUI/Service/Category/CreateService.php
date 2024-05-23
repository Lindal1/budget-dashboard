<?php
declare(strict_types=1);

namespace App\WebUI\Service\Category;

use App\Domain\Category\Entity\Category;
use App\Infrastructure\Category\CategoryRepository;
use App\WebUI\Form\Category\CreateForm;

class CreateService
{
    public function __construct(
        private CategoryRepository $categoryRepository,
    )
    {
    }

    public function create(CreateForm $form): void
    {
        $userId = 1;

        $category = new Category(
            null,
            $userId,
            $form->get('type')->getData(),
            $form->get('name')->getData(),
        );
        $this->categoryRepository->save($category);
    }
}
