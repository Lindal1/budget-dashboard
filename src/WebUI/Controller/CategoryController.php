<?php
declare(strict_types=1);

namespace App\WebUI\Controller;

use App\Domain\Category\Dto\CategoryQuery;
use App\Domain\Category\Entity\Category;
use App\Domain\Category\Repository\CategoryRepositoryInterface;
use App\WebUI\Form\Category\CreateForm;
use App\WebUI\Form\Category\UpdateForm;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class CategoryController extends AbstractController
{
    #[Route(path: '/category', name: 'category_list')]
    public function index(
        #[CurrentUser]
        UserInterface               $user,
        CategoryRepositoryInterface $categoryRepository,
        Request                     $request,
    ): Response
    {
        $form = $this->createForm(CreateForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // get current user id
            $category = new Category(
                Uuid::uuid4(),
                Uuid::fromString($user->getUserIdentifier()),
                $form->get('type')->getData(),
                $form->get('name')->getData(),
            );

            $categoryRepository->save($category);

            return $this->redirectToRoute('category_list');
        }

        $query = new CategoryQuery(
            userUuids: [Uuid::fromString($user->getUserIdentifier())],
        );

        return $this->render(
            'category.html.twig',
            [
                'categories' => $categoryRepository->search($query),
                'form' => $form,
            ]
        );
    }

    #[Route(path: '/category/{category_uuid}/delete', name: 'category_delete', requirements: ['category_uuid' => \Ramsey\Uuid\Uuid::VALID_PATTERN], methods: ['GET'])]
    public function delete(
        CategoryRepositoryInterface $categoryRepository,
        Category                    $category,
    ): Response
    {
        $this->denyAccessUnlessGranted('delete', $category);
        $categoryRepository->delete($category);
        return $this->redirectToRoute('category_list');
    }

    #[Route(path: '/category/{category_uuid}/update', name: 'category_update', requirements: ['category_uuid' => \Ramsey\Uuid\Uuid::VALID_PATTERN], methods: ['GET', 'POST'])]
    public function update(
        CategoryRepositoryInterface $categoryRepository,
        Category                    $category,
        Request                     $request,
    ): Response
    {
        $this->denyAccessUnlessGranted(['update', 'admin'], $category);
        $form = $this->createForm(UpdateForm::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category->name = $form->get('name')->getData();
            $categoryRepository->save($category);
            return $this->redirectToRoute('category_list');
        }

        return $this->render(
            'category_update.html.twig',
            [
                'form' => $form,
            ]
        );
    }
}
