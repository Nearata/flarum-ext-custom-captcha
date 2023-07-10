<?php

namespace Nearata\CustomCaptcha\Api\Controller;

use Flarum\Settings\SettingsRepositoryInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GenerateCaptchaMath implements RequestHandlerInterface
{
    public function __construct(protected SettingsRepositoryInterface $settings)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $operators = [
            '+',
            '-',
            '*',
        ];

        $operation = $operators[array_rand($operators)];

        $values = [
            random_int(1, 10),
            random_int(1, 10),
        ];

        if ($operation == '-' && $values[0] < $values[1]) {
            $values = array_reverse($values);
        }

        $question = $values[0].$operation.$values[1];

        $answer = '';
        eval('$answer = '.$question.';');

        /**
         * @var \Illuminate\Session\Store
         */
        $session = $request->getAttribute('session');

        $session->put('nearataCustomCaptchaMathAnswer', $answer);

        return new JsonResponse(['question' => $question]);
    }
}
