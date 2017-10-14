<?php

namespace SimpleShop\Commodity\Models;

use SimpleShop\Brand\Models\ShopBrand;
use SimpleShop\Cate\Models\ShopCate;
use SimpleShop\Store\Models\ShopStoreModel;

/**
 * @description 商品SPU表
 * @author  wangzhoudong  <admin@yijinba.com>;
 * @version    1.0
 * @date 2017-01-05
 *
 */
class ShopGoodsModel extends BaseModel
{
    /**
     * 数据表名
     *
     * @var string
     *
     */
    protected $table = 'shop_goods';
    /**
     * 主键
     */
    protected $primaryKey = 'id';

    //分页
    protected $perPage = 30;

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = [
        'store_id',
        'store_name',
        'price',
        'sku_id',
        'max_price',
        'name',
        'cover_path',
        'brand_id',
        'tags',
        'cate_id',
        'description',
        'content',
        'hot',
        'sort',
        'status',
        'unit_id',
        'logistics_id',
        'begin_num',
        'verify'
    ];


    /**
     * SKU信息
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function skuInfo()
    {
        return $this->hasMany(ShopGoodsProductModel::class, 'goods_id', 'id');
    }

    public function attrInfo()
    {
        return $this->hasMany(ShopGoodsAttributeModel::class, 'goods_id', 'id');
    }

    public function specInfo()
    {
        return $this->hasMany(ShopGoodsSpecModel::class, 'goods_id', 'id');
    }
    /**
     * 获取商品分类
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cateInfo()
    {
        return $this->hasOne(ShopCate::class, 'id', 'cate_id');
    }

    /**
     * 获取商品分类
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function storeInfo()
    {
        return $this->hasOne(ShopStoreModel::class, 'id', 'store_id');
    }


    /**
     * 获取商品图片
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pics()
    {
        return $this->hasMany(ShopGoodsImagesModel::class, 'goods_id', 'id');
    }

    public function brandInfo()
    {
        return $this->hasOne(ShopBrand::class, 'id', 'brand_id');
    }
}