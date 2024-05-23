<?php
declare(strict_types=1);

namespace App\WebUI\Controller;

use App\Domain\Auth\Service\LoginAuthServiceInterface;
use App\Domain\User\Enum\UserStatus;
use App\Domain\User\Service\UserServiceInterface;
use App\WebUI\Form\Auth\Registration;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/auth')]
class AuthController extends AbstractController
{
    #[Route(path: '/login', name: 'auth_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // Last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'auth_logout', methods: ['GET'])]
    public function logout(
        Security $security,
    ): Response
    {
        $security->logout();
        return $this->redirect('/');
    }

    #[Route(path: '/register', name: 'auth_register', methods: ['GET', 'POST'])]
    public function register(
        Request                   $request,
        UserServiceInterface      $userService,
        LoginAuthServiceInterface $loginAuthService,
        Security                  $security,
    ): Response
    {
        $form = $this->createForm(Registration::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $registration = $form->getData();

            $user = new \App\Domain\User\Entity\User(
                Uuid::uuid4(),
                $registration->email,
                UserStatus::Active,
            );
            $userService->create($user);

            $loginAuthService->set($user->uuid, $registration->email, $registration->password);

            return $this->redirect('/');
        }

        return $this->render('auth/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
