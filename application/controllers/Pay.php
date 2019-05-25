<?php

class PayController extends Base\ApiController {

    public function indexAction(){

    }

    /**
     * 快钱mas回调接口
     * @return bool
     */
    public function kq_masAction(){
        $params = $this->getRequest()->getPost();
        $business = \Business\Kuaiqianpay::getInstance();
        $res = $business->callback($params);
        if($res === false){
            $msg = $business->getMessage();
            echo $msg['msg'];
        }else{
            echo 0;
        }
        return false;
    }

}