<?php
/**
 * Created by PhpStorm.
 * User: chendongqin
 * Date: 2019/4/26
 * Time: 9:08
 */

namespace M\Mapper;
use M\Instance;
class MytFinanceLogs extends MapperAbstract
{
    use Instance;
    protected $table = 'myt_finance_logs';
    protected $modelClass = '\M\MytFinanceLogs';


}