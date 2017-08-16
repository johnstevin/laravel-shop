<?php
/**
 * Created by PhpStorm.
 * User: Jiangzhiheng
 * Date: 2017/4/18
 * Time: 下午4:37
 */

namespace Commodity\Cate\Criteria;

use Commodity\Criteria\Criteria;
use Commodity\Contracts\RepositoryInterface as Repository;

class CateRootId extends Criteria
{
    /**
     * @var array
     */
    private $rootIds;

    public function __construct(array $rootIds)
    {
        $this->rootIds = $rootIds;
    }

    /**
     * @param $model
     * @param Repository $repository
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        $query = $model->whereIn('root_id', $this->rootIds);
        return $query;
    }
}