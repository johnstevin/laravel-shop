<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/12
 * Time: 17:52
 */

namespace LWJ\Commodity\Goods\Criteria;
use LWJ\Commodity\Criteria\Criteria;

use LWJ\Commodity\Contracts\RepositoryInterface as Repository;
use LWJ\Commodity\Models\ShopGoodsModel;
use LWJ\Commodity\Models\ShopGoodsProductModel;


class GoodsProduct extends Criteria {


    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        $goodsProductModel = app(ShopGoodsProductModel::class);
        $tGoodsProduct = $goodsProductModel->getTable();
        $tModel = $model->getTable();

        $model = $model->select(
            "$tModel.*",
            \DB::raw("$tGoodsProduct.id as sku_id"),
            \DB::raw("$tGoodsProduct.sku_name as sku_name")
            );
        $model = $model->leftJoin($tGoods,"$tGoods.id",'=',"$tModel.goods_id");
        return $model;
    }

}