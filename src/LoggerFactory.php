<?php

namespace ZnBundle\Log;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use ZnCore\Base\App\Helpers\EnvHelper;
use ZnCore\Domain\Domain\Interfaces\DomainInterface;
use ZnBundle\Log\Domain\Monolog\Handler\EloquentHandler;

class LoggerFactory
{

    public static function createLogger($container): LoggerInterface
    {
        /**
         * @var ContainerInterface $container
         * @var EloquentHandler $handler
         */
        $handler = $container->get(EloquentHandler::class);
        $level = EnvHelper::isDev() ? Logger::DEBUG : Logger::ERROR;
        $handler->setLevel($level);
        $logger = new Logger('application', []);
        $logger->pushHandler($handler);
        return $logger;
    }

    public static function createMonologLogger(string $env, string $directory, string $format = 'json'): LoggerInterface
    {
        $formatMap = [
            'json' => \Monolog\Formatter\JsonFormatter::class,
            'html' => \Monolog\Formatter\HtmlFormatter::class,
            'log' => \Monolog\Formatter\LineFormatter::class,
        ];
        $formatterClass = $formatMap[$format];
        $logFileName = __DIR__ . '/../../../../../' . $directory . '/' . $env . '.' . $format;
        if($env == 'dev') {
            $level = Logger::DEBUG;
        } else {
            $level = Logger::ERROR;
        }
        $logger = new Logger('application');
        $handler = new StreamHandler($logFileName, $level);
        $handler->setFormatter(new \Monolog\Formatter\JsonFormatter);
        $logger->pushHandler($handler);
        //$repo = new \ZnBundle\Log\JsonRepository;
        //prr($repo->all());

        return $logger;
    }

    public static function createYiiLogger(string $env): LoggerInterface
    {
        $logger = new \ZnBundle\Log\Yii2\Logger;
        return $logger;
    }

}
