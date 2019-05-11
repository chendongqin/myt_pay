<?php
/**
 * Created by PhpStorm.
 * User: chendongqin
 * Date: 2019/4/26
 * Time: 9:08
 */

namespace M\Mapper;
use M\Instance;
class MytUserFinance extends MapperAbstract
{
    use Instance;
    protected $table = 'myt_user_finance';
    protected $modelClass = '\M\MytUserFinance';


}