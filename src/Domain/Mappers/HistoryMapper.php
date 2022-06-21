<?php

namespace ZnBundle\Log\Domain\Mappers;

use ZnCore\Base\Libs\Repository\Interfaces\MapperInterface;

class HistoryMapper implements MapperInterface
{

    public function encode($data)
    {
        return $data;
    }

    public function decode($row)
    {
        $row['createdAt'] = new \DateTime($row['datetime']);
        unset($row['datetime']);
        return $row;
    }
}
