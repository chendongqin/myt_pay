<?php
/**
 * Created by PhpStorm.
 * User: chendongqin
 * Date: 2019/4/26
 * Time: 9:08
 */

namespace M\Mapper;

use M\Instance;

class MytMerchant extends MapperAbstract
{
    use Instance;
    protected $table = 'myt_merchant';
    protected $modelClass = '\M\MytMerchant';

    //创建商户
    public function create($name, $appId, $publicKey, $privateKey, $merchantSn, $termianalSn)
    {
        $model = new \M\MytMerchant();
        $model->setApp_id($appId);
        $model->setMerchat_name($name);
        $model->setPublic_key($publicKey);
        $model->setPrivate_key($privateKey);
        $model->setMerchat_sn($merchantSn);
        $model->setTermianal_sn($termianalSn);
        $model->setCreate_at(date('YmdHis'));
        $res = $this->insert($model);
        if($res === false){
            return false;
        }
        return true;
    }


}