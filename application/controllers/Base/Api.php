<?php

namespace Base;

class ApiController extends \Base\AbstractController {

    protected $_ec = array(
        'index',
        'api',
    );
    protected $_ac = array(
        'login'=>'*',
    );
    protected function before() {
        $this->disableView();
        $this->disableLayout();
        if ($this->isFilter() === false) {
            if (isset($_SERVER["HTTP_REFERER"])) {
                $info = \Business\Tokenlogin::getInstance()->getLoginUser();
            } else {
                $info = \Business\Login::getInstance()->getLoginUser();
            }
            if ($info === null) {
                $this->returnData('您没有登录',505);
                exit();
            }
        }
    }

    protected function isFilter(){
        $modules = strtolower($this->getRequest()->getModuleName());
        $controller = strtolower($this->getRequest()->getControllerName());
        $action = strtolower(($this->getRequest()->getActionName()));
        if(in_array($modules, $this->_ec)){
            if($this->_ac[$controller] == '*' || in_array($action, array_filter(explode(',',$this->_ac[$controller])))){
                return true;
            }
        }
        return false;
    }
    protected function after() {
        $info = \Business\Login::getInstance()->getLoginUser();
        $this->assign('loginUser',$info);
    }


    /**
     * @return \MongoClient
     * @throws \Exception
     * 
     */
    public function getMongo() {
        $mongodb = \Yaf\Registry::get('mongodb');
        return $mongodb;
    }

    /**
     * 
     * @return \Redis
     * @throws \Exception
     */
    public function getRedis() {
        $redis = \Yaf\Registry::get('redis');
        return $redis;
    }

    /**
     * 创建校验码
     * @param array $params
     * @return string
     */
    protected function createSignature($params) {
        $codeArr = array();
        foreach ($params as $key => $value) {
            $codeArr[$key] = $key . '=' . $value;
        }
        ksort($codeArr);
        $config = \Yaf\Registry::get('config');
        return md5(implode('', $codeArr) . $config->get('encryption.appsecret'));
    }

    protected function getToken($input = array()) {
        $request = $this->getRequest();
        $server = $request->getServer();
        $ip = \Ku\Tool::getClientIp();
        $data['ua'] = !isset($server['HTTP_USER_AGENT'])? : $server['HTTP_USER_AGENT'];
        $data['ip'] = $ip;
        if ($input) {
            $data = array_merge($data, $input);
        }
        return $this->createSignature($data);
    }
}
