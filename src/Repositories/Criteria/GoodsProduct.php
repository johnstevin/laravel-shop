<?php
/**
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2017/1/12
 * Time: 17:52
 */

namespace SimpleShop\Commodity\Repositories\Criteria;
use SimpleShop\Commodity\Models\ShopGoodsModel;
use SimpleShop\Commodity\Models\ShopGoodsProductModel;
use SimpleShop\Repositories\Contracts\RepositoryInterface as Repository;
use SimpleShop\Repositories\Criteria\Criteria;

class GoodsProduct extends Criteria
{

    /**
     * @param $model
     * @param Repository $repository
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        $goodsModel = app(ShopGoodsModel::class);
        $tGoods = $goodsModel->getTable();
        $goodsProductModel = app(ShopGoodsProductModel::class);
        $tGoodsProduct = $goodsProductModel->getTable();
        $tModel = $model->getTable();

        $model = $model->select(
            "$tModel.*",
            \DB::raw("$tGoodsProduct.id as sku_id"),
            \DB::raw("$tGoodsProduct.sku_name as sku_name")
        );
        $model = $model->leftJoin($tGoods, "{$tGoods}.id", "=", "{$tModel}.goods_id");
        return $model;
    }

}