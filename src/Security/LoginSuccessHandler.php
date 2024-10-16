<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): ?Response
    {
        // Check if there's a target path stored in the session
        if ($targetPath = $request->getSession()->get('_security.' . $request->attributes->get('_firewall')->name . '.target_path')) {
            return new RedirectResponse($targetPath);
        }

        // Default redirection
        return new RedirectResponse($this->urlGenerator->generate('app_accueil'));
    }
}
