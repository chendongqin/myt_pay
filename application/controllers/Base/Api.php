<?php

namespace Base;

class ApiController extends \Base\AbstractController {

    protected $_ac = array(

    );
    protected $_diver = '';
    protected function before() {
        $diver = $this->getParam('diver','h5','string');
        $this->_diver = $diver;
        $this->disableView();
        $this->disableLayout();
    }

    protected function isFilter(){
        $modules = strtolower($this->getRequest()->getModuleName());
        $controller = strtolower($this->getRequest()->getControllerName());
        $action = strtolower(($this->getRequest()->getActionName()));
        if(isset($this->_ac[$modules])){
            if($this->_ac[$modules][$controller] == '*' || in_array($action, array_filter(explode(',',$this->_ac[$modules][$controller])))){
                return true;
            }
        }
        return false;
    }
    protected function after() {

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

    /**
     * 获取请求设备
     * @return string
     */
    public function getDiver(){
        return $this->_diver;
    }
}
