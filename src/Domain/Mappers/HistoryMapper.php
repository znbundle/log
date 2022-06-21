<?php

namespace ZnBundle\Log\Domain\Mappers;

use ZnCore\Base\Libs\Repository\Interfaces\MapperInterface;

class HistoryMapper implements MapperInterface
{

    public function encode($entityAttributes)
    {
        return $entityAttributes;
    }

    public function decode($rowAttributes)
    {
        $rowAttributes['createdAt'] = new \DateTime($rowAttributes['datetime']);
        unset($rowAttributes['datetime']);
        return $rowAttributes;
    }
}
