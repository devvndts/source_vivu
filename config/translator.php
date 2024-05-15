<?php declare(strict_types=1);

use Translator\Framework\LaravelConfigLoader;
use Translator\Infra\LaravelJsonTranslationRepository;

return [
    'languages' => ['en', 'vi'],
    'directories' => [
        app_path(),
        resource_path('views'),
    ],
    'output' => resource_path('lang'),
    'extensions' => ['php'],
    'use_keys_as_default_value ' => true,
    'default_language' => 'vi',
    'container' => [
        'config_loader' => LaravelConfigLoader::class,
        'translation_repository' => LaravelJsonTranslationRepository::class,
    ],
];
