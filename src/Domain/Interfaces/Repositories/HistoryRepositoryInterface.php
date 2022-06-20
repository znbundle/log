<?php

namespace ZnBundle\Log\Domain\Interfaces\Repositories;

use ZnCore\Domain\Interfaces\GetEntityClassInterface;
use ZnCore\Domain\Interfaces\ReadAllInterface;
use ZnCore\Domain\Interfaces\Repository\ReadOneInterface;
use ZnCore\Base\Libs\Repository\Interfaces\RepositoryInterface;

interface HistoryRepositoryInterface extends RepositoryInterface, GetEntityClassInterface, ReadAllInterface, ReadOneInterface
{


}
