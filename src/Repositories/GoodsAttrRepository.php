<?php
/**
 *------------------------------------------------------
 * LogisticsRepository.php
 *------------------------------------------------------
 *
 * @author    qqiu@qq.com
 * @version   V1.0
 *
 */

namespace SimpleShop\Commodity\Repositories;

use SimpleShop\Attr\Attribute;
use SimpleShop\Commodity\Models\ShopGoodsAttributeModel;
use SimpleShop\Commons\Exceptions\Exception;
use SimpleShop\Repositories\Eloquent\Repository;

/**
 * Class LogisticsRepository
 * @package SimpleShop\Logistics\Repositories
 */
class GoodsAttrRepository extends Repository
{



    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return ShopGoodsAttributeModel::class;
    }


    /**
     * 添加
     * @param $data
     * @return bool|static
     */
    public function add($goods_id,$value_id) {
        $data = app(Attribute::class)->getValue($value_id);
        if(!$data) {
            throw new Exception("不存在的属性ID" . $value_id);
        }
        $add['goods_id'] = $goods_id;
        $add['cate_id'] =  $data->cate_id;
        $add['attr_id'] = $data->attr_id;
        $add['attr_value_id'] = $data->id;
        return $obj = $this->model->create($add);
    }
    /**
     * @param $goods_id
     * @param $value_ids
     * @return bool
     */
    public function adds($goods_id,$value_ids) {
        foreach($value_ids as $value_id) {
            $ok = $this->add($goods_id,$value_id);
            if(! $ok) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param $goods_id
     * @param $value_ids
     */
    public function updates($goods_id,$value_ids) {
        $this->deleteByGoods($goods_id);
        $this->adds($goods_id,$value_ids);
    }

    public function deleteByGoods($goods_id) {
        return $this->model->where('goods_id',$goods_id)->delete();
    }

}
