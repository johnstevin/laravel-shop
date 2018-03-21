<?php
/**
 * Created by PhpStorm.
 * User: coffeekizoku
 * Date: 2017/12/19
 * Time: 10:56
 */

namespace SimpleShop\Commodity\Repositories\Criteria;


use SimpleShop\Repositories\Contracts\RepositoryInterface as Repository;
use SimpleShop\Repositories\Criteria\Criteria;

class Recommend extends Criteria
{
    /**
     * @param            $model
     * @param Repository $repository
     *
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
<<<<<<< HEAD
        $model = $model->where('shop_goods.status', 1)->orderBy('shop_goods.recommend', 'desc')
=======
        $model = $model->orderBy('shop_goods.recommend', 'desc')
>>>>>>> 9e286fa16e60cc5662ba14ef655a6b0476978e19
            ->orderBy('shop_goods.hot', 'desc');

        return $model;
    }
}