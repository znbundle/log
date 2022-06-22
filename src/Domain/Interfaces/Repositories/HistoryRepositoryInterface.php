<?php

namespace ZnBundle\Log\Domain\Interfaces\Repositories;

use ZnCore\Domain\Domain\Interfaces\GetEntityClassInterface;
use ZnCore\Domain\Domain\Interfaces\ReadAllInterface;
use ZnCore\Domain\Repository\Interfaces\FindOneInterface;
use ZnCore\Domain\Repository\Interfaces\RepositoryInterface;

interface HistoryRepositoryInterface extends RepositoryInterface, GetEntityClassInterface, ReadAllInterface, FindOneInterface
{


}
