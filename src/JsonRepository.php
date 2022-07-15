<?php

namespace ZnBundle\Log;

use ZnBundle\Log\Domain\Entities\LogEntity;
use ZnCore\Collection\Libs\Collection;
use ZnDomain\Entity\Helpers\EntityHelper;

class JsonRepository
{

    public function findAll()
    {
        $env = $_ENV['APP_ENV'];
        $logFileName = __DIR__ . '/../../../../../' . $_ENV['MONOLOG_DIR'] . '/' . $env . '.json';
        $lines = file($logFileName, \FILE_IGNORE_NEW_LINES);
        $collection = new Collection();
        foreach ($lines as &$line) {
            $line = json_decode($line);
            $logEntity = new LogEntity();
            EntityHelper::setAttributes($logEntity, $line);
            $collection->add($logEntity);
        }
        return $collection;
    }

}
