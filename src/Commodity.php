<?php

/*
 * This file is part of Commodity
 *
 * (c) Wangzd <wangzhoudong@foxmail.com>
 *
 */

namespace SimpleShop\Commodity;

use Illuminate\Contracts\Events\Dispatcher;
use SimpleShop\Attr\Attribute;
use SimpleShop\Commodity\Events\GoodsEvent;
use SimpleShop\Commodity\Repositories\Criteria\GoodsMultiWhere;
use SimpleShop\Commodity\Repositories\Criteria\GoodsOrder;
use SimpleShop\Commodity\Repositories\GoodsAttrRepository;
use SimpleShop\Commodity\Repositories\GoodsImagesRepository;
use SimpleShop\Commodity\Repositories\GoodsProductRepository;
use SimpleShop\Commodity\Repositories\GoodsRepository;
use SimpleShop\Spec\Spec;
/**
 * This is the Commodity class.
 *
 * @author Wangzd <wangzhoudong@foxmail.com>
 */
class Commodity
{
    protected $goodsRepository;
    protected $goodsProductRepository;
    protected $goodsImagesRepository;
    protected $goodsAttrRepository;
    protected $attribute;

    public function __construct(GoodsRepository $goodsRepository,
                                GoodsProductRepository $goodsProductRepository,
                                GoodsImagesRepository $goodsImagesRepository,
                                GoodsAttrRepository $goodsAttrRepository,
                                Dispatcher $event
                            )
    {
        $this->goodsRepository = $goodsRepository;
        $this->goodsProductRepository = $goodsProductRepository;
        $this->goodsImagesRepository = $goodsImagesRepository;
        $this->goodsAttrRepository = $goodsAttrRepository;
        $this->event = $event;
    }

    /**
     * 获取列表
     *
     * @param array $search
     * @param array $orderBy
     * @param int $page
     * @param int $pageSize
     * @return mixed
     */
    public function search(array $search = [], array $orderBy = [], $page = 1, $pageSize = 10)
    {
        return $this->goodsRepository
            ->pushCriteria(new GoodsMultiWhere($search))
            ->pushCriteria(new GoodsOrder($orderBy))
            ->with(['cateInfo','brandInfo','storeInfo'])
            ->paginate($pageSize, ['*'], $page);
    }


    /**
     * @param $data
     */

    public function create($data) {
        $priceSection = $this->goodsProductRepository->getPriceSection($data['spec']);
        $data['price'] = $priceSection[0];
        $data['max_price'] = $priceSection[1];
        \DB::transaction(function() use ($data) {
            $goods = $this->goodsRepository->create($data);
            if (isset($data['imgs'])) {
                $this->goodsImagesRepository->adds($goods->id, $data['imgs']);
            }

            if (isset($data['attr'])) {
                $this->goodsAttrRepository->adds($goods->id, $data['attr']);
            }
            if(isset($data['spec'])) {
                app(Sku::class)->create($goods,$data['spec']);
                $this->goodsRepository->update($goods->id,
                    ['sku_id' => $this->goodsProductRepository->getMinSkuId($goods->id)]);
            }
            if (isset($data['add_attr'])) {
                app(Attribute::class)->bindGoods($goods->id, $data['add_attr']);
            }
            if (isset($data['add_spec'])) {
                app(Spec::class)->bindGoods($goods->id, $data['add_spec']);
            }
            event(new GoodsEvent($goods->id, 'added'));
        });
    }

    /**
     * @param $id
     * @param $data
     */
    public function update($goodsId,$data) {
        $priceSection = $this->goodsProductRepository->getPriceSection($data['spec']);
        $data['price'] = $priceSection[0];
        $data['max_price'] = $priceSection[1];
        \DB::transaction(function() use ($goodsId,$data) {
            $goods = $this->goodsRepository->find($goodsId);
            $goods->save($data);
            if (isset($data['imgs'])) {
                $this->goodsImagesRepository->updates($goods->id, $data['imgs']);
            }

            if (isset($data['attr'])) {
                $this->goodsAttrRepository->updates($goods->id, $data['attr']);
            }
            if(isset($data['spec'])) {
                app(Sku::class)->update($goods,$data['spec']);
                $this->goodsRepository->update($goods->id,
                    ['sku_id' => $this->goodsProductRepository->getMinSkuId($goods->id)]);
            }
            event(new GoodsEvent($goodsId, 'updated'));
        });
    }

    public function show($id) {
      $data = $this->goodsRepository->find($id);

      return $data;
    }

    public function destroy($id) {
        $ok = $this->goodsRepository->delete($id);
        event(new GoodsEvent($id, 'destroyed'));
        return $ok;
    }

    /**
     * 上架
     * @param $goodsId
     */
    public function up($goodsId) {
        \DB::transaction(function() use ($goodsId) {
            $this->goodsRepository->update($goodsId,['status' => 1]);
            $this->goodsProductRepository->upGoods($goodsId);
            event(new GoodsEvent($goodsId, 'updated'));
        });
    }

    /**
     * 上架
     * @param $goodsId
     */
    public function down($goodsId) {

        \DB::transaction(function() use ($goodsId) {
            $this->goodsRepository->update($goodsId,['status' => 0]);
            $this->goodsProductRepository->downGoods($goodsId);
            event(new GoodsEvent($goodsId, 'updated'));
        });
    }
}
