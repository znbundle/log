<?php

namespace ZnBundle\Log\Domain\Interfaces\Repositories;

use ZnCore\Domain\Domain\Interfaces\GetEntityClassInterface;
use ZnCore\Domain\Domain\Interfaces\ReadAllInterface;
use ZnCore\Repository\Interfaces\FindOneInterface;
use ZnCore\Repository\Interfaces\RepositoryInterface;

interface HistoryRepositoryInterface extends RepositoryInterface, GetEntityClassInterface, ReadAllInterface, FindOneInterface
{


}
