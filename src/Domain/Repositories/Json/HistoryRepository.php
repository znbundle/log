<?php

namespace ZnBundle\Log\Domain\Repositories\Json;

use Illuminate\Support\Collection;
use Monolog\DateTimeImmutable;
use Monolog\Handler\HandlerInterface;
use ZnBundle\Log\Domain\Entities\HistoryEntity;
use ZnBundle\Log\Domain\Entities\LogEntity;
use ZnBundle\Log\Domain\Interfaces\Repositories\HistoryRepositoryInterface;
use ZnBundle\Log\Domain\Mappers\HistoryMapper;
use ZnCore\Base\Exceptions\NotFoundException;
use ZnCore\Domain\Interfaces\Entity\EntityIdInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Libs\Query;
use ZnCore\Domain\Traits\EntityManagerTrait;
use ZnLib\Db\Traits\MapperTrait;

class HistoryRepository implements HistoryRepositoryInterface
{

    use EntityManagerTrait;
    use MapperTrait;

    private $path;

    public function __construct(EntityManagerInterface $em, HandlerInterface $handler)
    {
        $this->path = $handler->getUrl();
        $this->setEntityManager($em);
    }

    public function getEntityClass(): string
    {
        return HistoryEntity::class;
    }

    public function mappers(): array
    {
        return [
            new HistoryMapper(),
        ];
    }

    public function all(Query $query = null)
    {
        $file = new \SplFileObject($this->path);
        $fileIterator = new \LimitIterator($file, $query->getOffset(), $query->getPerPage());
        $collection = new Collection();
        foreach ($fileIterator as $index => $line) {
            $id = $index + 1;
            $item = json_decode($line, JSON_OBJECT_AS_ARRAY);
            $item['id'] = $id;
            $entity = $this->mapperDecodeEntity($item);
            $collection->add($entity);
        }
        return $collection;
    }

    public function count(Query $query = null): int
    {
        $file_arr = file($this->path);
        return count($file_arr) - 1;
    }

    public function oneById($id, Query $query = null): EntityIdInterface
    {
        $query = Query::forge($query);
        $query->setOffset($id - 1);
        $query->setPerPage(1);
        $collection = $this->all($query);
        $entity = $collection->first();
        if(empty($entity)) {
            throw new NotFoundException();
        }
        return $entity;
    }
}
