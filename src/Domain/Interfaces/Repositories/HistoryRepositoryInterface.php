<?php

namespace ZnBundle\Log\Domain\Interfaces\Repositories;

use ZnCore\Base\Libs\Domain\Interfaces\GetEntityClassInterface;
use ZnCore\Base\Libs\Domain\Interfaces\ReadAllInterface;
use ZnCore\Base\Libs\Repository\Interfaces\FindOneInterface;
use ZnCore\Base\Libs\Repository\Interfaces\RepositoryInterface;

interface HistoryRepositoryInterface extends RepositoryInterface, GetEntityClassInterface, ReadAllInterface, FindOneInterface
{


}
