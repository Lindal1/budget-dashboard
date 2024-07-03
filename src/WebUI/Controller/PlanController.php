<?php
declare(strict_types=1);

namespace App\WebUI\Controller;

use App\Domain\Planing\Entity\Plan;
use App\Domain\Planing\Repository\PlanRepositoryInterface;
use App\Domain\Planing\ValueObject\Month;
use App\Domain\Planing\ValueObject\Period;
use App\WebUI\Form\CreatePlan;
use App\WebUI\Service\Planing\PlanService;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class PlanController extends AbstractController
{
    #[Route('/planing', name: 'plan_list')]
    public function planList(
        #[CurrentUser]
        UserInterface           $user,
        PlanRepositoryInterface $planRepository,
        Request                 $request,
    ): Response
    {
        $form = $this->createForm(CreatePlan::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $plan = new Plan(
                Uuid::uuid4(),
                Uuid::fromString($user->getUserIdentifier()),
                $form->get('name')->getData(),
            );

            $planRepository->save($plan);

            return $this->redirectToRoute('plan_list');
        }

        return $this->render(
            'planing/list.html.twig',
            [
                'plans' => $planRepository->getByUserUuid(Uuid::fromString($user->getUserIdentifier())),
                'form' => $form,
            ]
        );
    }

    #[Route('/planing/{plan_uuid}', name: 'plan_view', requirements: ['plan_uuid' => \Ramsey\Uuid\Uuid::VALID_PATTERN])]
    public function view(
        Plan        $plan,
        PlanService $planService,
        Request     $request,
    ): Response
    {
        $this->denyAccessUnlessGranted('view', $plan);
        $currentYear = (int)date('Y');
        $period = new Period(
            new Month(1, $currentYear),
            new Month(12, $currentYear),
        );

        return $this->render(
            'planing/view.html.twig',
            [
                'plan' => $plan,
                'table' => $planService->getTable($plan, $period),
                'editMode' => $request->query->getBoolean('edit'),
            ]
        );
    }

    #[Route('/planing/{plan_uuid}/update', name: 'plan_update', requirements: ['plan_uuid' => \Ramsey\Uuid\Uuid::VALID_PATTERN])]
    public function update(
        Plan                    $plan,
        PlanRepositoryInterface $planRepository,
        Request                 $request,
    ): Response
    {
        $this->denyAccessUnlessGranted('update', $plan);
        $form = $this->createForm(CreatePlan::class, $plan);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $plan->name = $form->get('name')->getData();
            $planRepository->save($plan);

            return $this->redirectToRoute('plan_list');
        }

        return $this->render('planing/update_plan.html.twig', ['form' => $form]);
    }

    #[Route('/planing/{plan_uuid}/delete', name: 'plan_delete', requirements: ['plan_uuid' => \Ramsey\Uuid\Uuid::VALID_PATTERN])]
    public function delete(
        Plan                    $plan,
        PlanRepositoryInterface $planRepository,
    ): Response
    {
        $this->denyAccessUnlessGranted('delete', $plan);
        $planRepository->delete($plan);
        return $this->redirectToRoute('plan_list');
    }
}
