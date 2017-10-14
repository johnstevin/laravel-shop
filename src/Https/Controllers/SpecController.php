<?php
/**
 *------------------------------------------------------
 * LogisticsController.php
 *------------------------------------------------------
 *
 * @author    qqiu@qq.com
 * @version   V1.0
 *
 */

namespace SimpleShop\Commodity\Https\Controllers;

use Illuminate\Http\Request;
use SimpleShop\Commodity\Spec;
use SimpleShop\Commons\Https\Controllers\Controller;

class SpecController extends Controller
{

    public $specService;



    public function __construct(Spec $specService)
    {
        $this->specService = $specService;
    }




    public function getValueIdsGoods($goodsId) {
        return $this->specService->getValueIdsGoods($goodsId);
    }


}
