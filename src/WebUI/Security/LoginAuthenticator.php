<?php
declare(strict_types=1);

namespace App\WebUI\Security;

use App\Domain\Auth\Service\LoginAuthServiceInterface;
use App\Domain\User\Repository\UserRepositoryInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

class LoginAuthenticator extends AbstractAuthenticator
{
    private const DEFAULT_USERNAME = 'email';
    private const DEFAULT_PASSWORD = 'password';
    private const DEFAULT_ROUTE = 'auth_login';

    public function __construct(
        private readonly LoginAuthServiceInterface $loginAuthService,
        private readonly UrlGeneratorInterface     $urlGenerator,
        private readonly UserRepositoryInterface   $userRepository,
    )
    {
    }

    public function supports(Request $request): bool
    {
        return $request->isMethod('POST') && $request->attributes->get('_route') === self::DEFAULT_ROUTE;
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->get(self::DEFAULT_USERNAME);
        $password = $request->get(self::DEFAULT_PASSWORD);
        $user = $this->userRepository->getByEmail($email);
        if ($user === null) {
            throw new AuthenticationException('Login or password is incorrect.');
        }

        return new Passport(
            new UserBadge($user->uuid->toString()),
            new CustomCredentials(
                function (array $credentials, UserInterface $user): bool {
                    $uuid = $this->loginAuthService->find($credentials['email'], $credentials['password']);
                    return $uuid !== null && $user->getUserIdentifier() === $uuid->toString();
                },
                [
                    'email' => $email,
                    'password' => $password,
                ]
            ),
            [
                new RememberMeBadge([
                    'lifetime' => 10,
                ]),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Redirect to the homepage after successful login
        return new RedirectResponse($this->urlGenerator->generate('homepage'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        // Redirect back to the login page with an error message
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
        return new RedirectResponse($this->urlGenerator->generate('auth_login'));
    }
}
