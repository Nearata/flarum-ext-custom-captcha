<?php

namespace Nearata\CustomCaptcha\Api\Serializer;

use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Settings\SettingsRepositoryInterface;

class ForumSerializerAttributes
{
    public function __construct(protected SettingsRepositoryInterface $settings)
    {
    }

    public function __invoke(ForumSerializer $serializer, $model, array $attributes)
    {
        return [
            'nearata-custom-captcha.signup_enabled' => $this->settings->get('nearata-custom-captcha.signup_enabled'),
            'nearata-custom-captcha.signup_type' => $this->settings->get('nearata-custom-captcha.signup_type'),
        ];
    }
}
