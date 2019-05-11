<?php
/**
 * Created by PhpStorm.
 * User: chendongqin
 * Date: 2019/4/26
 * Time: 9:08
 */

namespace M\Mapper;
use M\Instance;
class MytTradeOrder extends MapperAbstract
{
    use Instance;
    protected $table = 'myt_trade_order';
    protected $modelClass = '\M\MytTradeOrder';


}