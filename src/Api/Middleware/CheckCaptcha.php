<?php

namespace Nearata\CustomCaptcha\Api\Middleware;

use Flarum\Foundation\ValidationException;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Support\Arr;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class CheckCaptcha implements MiddlewareInterface
{
    public function __construct(
        protected TranslatorInterface $translator,
        protected SettingsRepositoryInterface $settings)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // signup only
        if ($request->getAttribute('routeName') !== 'users.create') {
            return $handler->handle($request);
        }

        if (! $this->settings->get('nearata-custom-captcha.signup_enabled')) {
            return $handler->handle($request);
        }

        if ($this->settings->get('nearata-custom-captcha.signup_type') === 'math' && $this->checkMathAnswer($request)) {
            return $handler->handle($request);
        }

        throw new ValidationException(['message' => $this->translator->trans('nearata-custom-captcha.forum.error.invalid_captcha')]);
    }

    private function checkMathAnswer(ServerRequestInterface $request): bool
    {
        $answer = Arr::get($request->getParsedBody(), 'data.attributes.nearataCustomCaptcha');

        /**
         * @var \Illuminate\Session\Store
         */
        $session = $request->getAttribute('session');

        return $answer === (string) $session->get('nearataCustomCaptchaMathAnswer');
    }
}
