<?php
declare(strict_types=1);

namespace App\WebUI\Controller;

use App\Domain\Category\Dto\GroupQuery;
use App\Domain\Category\Repository\GroupRepositoryInterface;
use App\WebUI\Form\Category\GroupCreate;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/category/group')]
class CategoryGroupController extends AbstractController
{
    #[Route(path: '', name: 'category_group_list', methods: ['GET'])]
    public function list(
        #[CurrentUser]
        UserInterface            $user,
        GroupRepositoryInterface $groupRepository
    ): Response
    {
        $form = $this->createForm(GroupCreate::class);
        return $this->render(
            'category_group_list.html.twig',
            [
                'groups' => $groupRepository->search(
                    new GroupQuery(userId: Uuid::fromString($user->getUserIdentifier()))
                ),
                'form' => $form->createView()
            ]
        );
    }

    #[Route(path: '', name: 'category_group_create', methods: ['POST'])]
    public function create(
        #[CurrentUser]
        UserInterface $user,
        Request       $request,
    ): Response
    {
        $form = $this->createForm(GroupCreate::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $group = new Group(
                Uuid::uuid4(),
                Uuid::fromString($user->getUserIdentifier()),
                $form->get('name')->getData(),
                CategoryType::from($form->get('type')->getData())
            );
            $this->groupRepository->save($group);
        }
        return $this->redirectToRoute('category_group_list');
    }
}
