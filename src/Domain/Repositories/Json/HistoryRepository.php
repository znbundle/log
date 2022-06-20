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
use ZnCore\Contract\Domain\Interfaces\Entities\EntityIdInterface;
use ZnCore\Base\Libs\EntityManager\Interfaces\EntityManagerInterface;
use ZnCore\Base\Libs\Query\Entities\Query;
use ZnCore\Base\Libs\EntityManager\Traits\EntityManagerAwareTrait;
use ZnDatabase\Base\Domain\Traits\MapperTrait;

class HistoryRepository implements HistoryRepositoryInterface
{

    use EntityManagerAwareTrait;
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
            if(!empty($line)) {
                $item = json_decode($line, JSON_OBJECT_AS_ARRAY);
                $id = $index + 1;
                $item['id'] = $id;
                $entity = $this->mapperDecodeEntity($item);
                $collection->add($entity);
            }
        }
        return $collection;
    }

    public function count(Query $query = null): int
    {
        $count = 0;
        $handle = fopen($this->path, "r");
        while (!feof($handle))  {
            fgets($handle);
            $count++;
        }
        fclose($handle);
        return $count - 1;

//        $file_arr = file($this->path);
//        return count($file_arr);
    }

    public function oneById($id, Query $query = null): EntityIdInterface
    {
        $query = Query::forge($query);
        $query->offset($id - 1);
        $query->perPage(1);
        $collection = $this->all($query);
        $entity = $collection->first();
        if(empty($entity)) {
            throw new NotFoundException();
        }
        return $entity;
    }
}
