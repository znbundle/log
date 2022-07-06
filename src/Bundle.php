<?php

namespace ZnBundle\Log;

use ZnCore\Bundle\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function symfonyAdmin(): array
    {
        return [
            __DIR__ . '/Symfony4/Admin/config/routing.php',
        ];
    }

    public function yiiAdmin(): array
    {
        return [

        ];
    }

    public function i18next(): array
    {
        return [

        ];
    }

    public function migration(): array
    {
        return [
            '/vendor/znbundle/log/src/Domain/Migrations',
        ];
    }

    public function container(): array
    {
        return [
            __DIR__ . '/Domain/config/container.php',
        ];
    }
}
