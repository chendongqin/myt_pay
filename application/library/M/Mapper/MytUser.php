<?php
/**
 * Created by PhpStorm.
 * User: chendongqin
 * Date: 2019/4/26
 * Time: 9:08
 */

namespace M\Mapper;
use M\Instance;
class MytUser extends MapperAbstract
{
    use Instance;
    protected $table = 'myt_user';
    protected $modelClass = '\M\MytUser';


}