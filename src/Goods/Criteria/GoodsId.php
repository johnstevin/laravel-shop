<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/12
 * Time: 17:52
 */

namespace Commodity\Goods\Criteria;
use Commodity\Criteria\Criteria;

use Commodity\Contracts\RepositoryInterface as Repository;


class GoodsId extends Criteria {

    private $goodsId;

    public function __construct($goodsId)
    {
        $this->goodsId = $goodsId;
    }

    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        $query = $model->where('id', $this->goodsId);
        return $query;
    }

}