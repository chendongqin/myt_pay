<?php
/**
 * Created by PhpStorm.
 * User: chendongqin
 * Date: 2019/4/26
 * Time: 9:08
 */

namespace M\Mapper;
use M\Instance;
class MytUserLogs extends MapperAbstract
{
    use Instance;
    protected $table = 'myt_user_logs';
    protected $modelClass = '\M\MytUserLogs';


}