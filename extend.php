<?php

namespace Nearata\CustomCaptcha;

use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Extend;
use Nearata\CustomCaptcha\Api\Controller\GenerateCaptchaMath;
use Nearata\CustomCaptcha\Api\Middleware\CheckCaptcha;
use Nearata\CustomCaptcha\Api\Serializer\ForumSerializerAttributes;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js')
        ->css(__DIR__.'/less/forum.less'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js')
        ->css(__DIR__.'/less/admin.less'),

    new Extend\Locales(__DIR__.'/locale'),

    (new Extend\Routes('api'))
        ->get('/nearata/customCaptcha/generate/math', 'nearata-custom-captcha.generate', GenerateCaptchaMath::class),

    (new Extend\Middleware('api'))
        ->add(CheckCaptcha::class),

    (new Extend\Settings)
        ->default('nearata-custom-captcha.signup_enabled', false)
        ->default('nearata-custom-captcha.signup_type', 'math'),

    (new Extend\ApiSerializer(ForumSerializer::class))
        ->attributes(ForumSerializerAttributes::class)
];
