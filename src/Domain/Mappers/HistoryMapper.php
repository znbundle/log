<?php

namespace ZnBundle\Log\Domain\Mappers;

use ZnCore\Contract\Encoder\Interfaces\EncoderInterface;

class HistoryMapper implements EncoderInterface
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
