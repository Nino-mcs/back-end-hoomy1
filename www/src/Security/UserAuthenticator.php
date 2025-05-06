<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use App\Entity\User;

class UserAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    public function __construct(private UrlGeneratorInterface $urlGenerator) {}

    public function authenticate(Request $request): Passport
    {
        // on récupère les données du formulaire
        $username = $request->request->get('username', ''); // Correspond à "username" de ton entité
        // on stocke le nom d'utilisateur dans la session pour le réafficher en cas d'erreur
        $request->getSession()->set('_security.last_username', $username);


        // Création du Passport avec l'email en tant que UserBadge
        return new Passport(
            new UserBadge($username), // Username correspond à l'identifiant de l'utilisateur
            new PasswordCredentials($request->request->get('password', '')), // Mot de passe
            [
                new CsrfTokenBadge('authenticate', $request->get('_csrf_token')), // Sécurisation CSRF
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Récupération de l'utilisateur authentifié
        $user = $token->getUser();

        if (!$user instanceof \App\Entity\User) {
            return new JsonResponse(['error' => 'Invalid user type'], Response::HTTP_UNAUTHORIZED);
        }


        // Préparation des données à renvoyer après une authentification réussie
        $data = [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(), // Récupération des rôles
        ];

        // Renvoyer la réponse JSON avec les informations utilisateur
        return new JsonResponse($data);
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE); // Redirection vers la page de login
    }
}
