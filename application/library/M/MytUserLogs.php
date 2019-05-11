<?php

/**
 * 用户操作日志
 * 
 * @Table Schema: payment
 * @Table Name: pay_user_logs
 */
namespace M;

class MytUserLogs extends \M\ModelAbstract {

    /**
     * Params
     * 
     * @var array
     */
    protected $_params = null;

    /**
     * Id
     * 
     * Column Type: int(11)
     * auto_increment
     * PRI
     * 
     * @var int
     */
    protected $_id = null;

    /**
     * 用户id
     * 
     * Column Type: int(11)
     * Default: 0
     * 
     * @var int
     */
    protected $_user_id = 0;

    /**
     * 操作类型
     * 
     * Column Type: varchar(30)
     * 
     * @var string
     */
    protected $_action = '';

    /**
     * Decribe
     * 
     * Column Type: tinytext
     * 
     * @var string
     */
    protected $_decribe = null;

    /**
     * 创建时间
     * 
     * Column Type: bigint(20)
     * Default: 0
     * 
     * @var int
     */
    protected $_create_at = 0;

    /**
     * Params
     * 
     * Column Type: array
     * Default: null
     * 
     * @var array
     */
    public function getParams() {
        return $this->_params;
    }

    /**
     * Id
     * 
     * Column Type: int(11)
     * auto_increment
     * PRI
     * 
     * @param int $id
     * @return \M\MytUserLogs
     */
    public function setId($id) {
        $this->_id = (int)$id;
        $this->_params['id'] = (int)$id;
        return $this;
    }

    /**
     * Id
     * 
     * Column Type: int(11)
     * auto_increment
     * PRI
     * 
     * @return int
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * 用户id
     * 
     * Column Type: int(11)
     * Default: 0
     * 
     * @param int $user_id
     * @return \M\MytUserLogs
     */
    public function setUser_id($user_id) {
        $this->_user_id = (int)$user_id;
        $this->_params['user_id'] = (int)$user_id;
        return $this;
    }

    /**
     * 用户id
     * 
     * Column Type: int(11)
     * Default: 0
     * 
     * @return int
     */
    public function getUser_id() {
        return $this->_user_id;
    }

    /**
     * 操作类型
     * 
     * Column Type: varchar(30)
     * 
     * @param string $action
     * @return \M\MytUserLogs
     */
    public function setAction($action) {
        $this->_action = (string)$action;
        $this->_params['action'] = (string)$action;
        return $this;
    }

    /**
     * 操作类型
     * 
     * Column Type: varchar(30)
     * 
     * @return string
     */
    public function getAction() {
        return $this->_action;
    }

    /**
     * Decribe
     * 
     * Column Type: tinytext
     * 
     * @param string $decribe
     * @return \M\MytUserLogs
     */
    public function setDecribe($decribe) {
        $this->_decribe = (string)$decribe;
        $this->_params['decribe'] = (string)$decribe;
        return $this;
    }

    /**
     * Decribe
     * 
     * Column Type: tinytext
     * 
     * @return string
     */
    public function getDecribe() {
        return $this->_decribe;
    }

    /**
     * 创建时间
     * 
     * Column Type: bigint(20)
     * Default: 0
     * 
     * @param int $create_at
     * @return \M\MytUserLogs
     */
    public function setCreate_at($create_at) {
        $this->_create_at = (int)$create_at;
        $this->_params['create_at'] = (int)$create_at;
        return $this;
    }

    /**
     * 创建时间
     * 
     * Column Type: bigint(20)
     * Default: 0
     * 
     * @return int
     */
    public function getCreate_at() {
        return $this->_create_at;
    }

    /**
     * Return a array of model properties
     * 
     * @return array
     */
    public function toArray() {
        return array(
            'id'        => $this->_id,
            'user_id'   => $this->_user_id,
            'action'    => $this->_action,
            'decribe'   => $this->_decribe,
            'create_at' => $this->_create_at
        );
    }

}
