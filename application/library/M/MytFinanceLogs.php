<?php

/**
 * 用户财务日志
 * 
 * @Table Schema: payment
 * @Table Name: pay_finance_logs
 */
namespace M;

class MytFinanceLogs extends \M\ModelAbstract {

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
     * 金额
     * 
     * Column Type: decimal(10,2)
     * Default: 0.00
     * 
     * @var float
     */
    protected $_amount = 0.00;

    /**
     * 交易类型
     * 
     * Column Type: tinyint(3)
     * Default: 0
     * 
     * @var int
     */
    protected $_type = 0;

    /**
     * 账户类型
     * 
     * Column Type: varchar(255)
     * 
     * @var string
     */
    protected $_finance_type = '';

    /**
     * 状态
     * 
     * Column Type: tinyint(3)
     * Default: 0
     * 
     * @var int
     */
    protected $_status = 0;

    /**
     * 是否删除
     * 
     * Column Type: varchar(255)
     * 
     * @var string
     */
    protected $_is_del = '';

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
     * 更新时间
     * 
     * Column Type: bigint(11)
     * Default: 20
     * 
     * @var int
     */
    protected $_update_at = 20;

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
     * @return \M\MytFinanceLogs
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
     * @return \M\MytFinanceLogs
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
     * 金额
     * 
     * Column Type: decimal(10,2)
     * Default: 0.00
     * 
     * @param float $amount
     * @return \M\MytFinanceLogs
     */
    public function setAmount($amount) {
        $this->_amount = (float)$amount;
        $this->_params['amount'] = (float)$amount;
        return $this;
    }

    /**
     * 金额
     * 
     * Column Type: decimal(10,2)
     * Default: 0.00
     * 
     * @return float
     */
    public function getAmount() {
        return $this->_amount;
    }

    /**
     * 交易类型
     * 
     * Column Type: tinyint(3)
     * Default: 0
     * 
     * @param int $type
     * @return \M\MytFinanceLogs
     */
    public function setType($type) {
        $this->_type = (int)$type;
        $this->_params['type'] = (int)$type;
        return $this;
    }

    /**
     * 交易类型
     * 
     * Column Type: tinyint(3)
     * Default: 0
     * 
     * @return int
     */
    public function getType() {
        return $this->_type;
    }

    /**
     * 账户类型
     * 
     * Column Type: varchar(255)
     * 
     * @param string $finance_type
     * @return \M\MytFinanceLogs
     */
    public function setFinance_type($finance_type) {
        $this->_finance_type = (string)$finance_type;
        $this->_params['finance_type'] = (string)$finance_type;
        return $this;
    }

    /**
     * 账户类型
     * 
     * Column Type: varchar(255)
     * 
     * @return string
     */
    public function getFinance_type() {
        return $this->_finance_type;
    }

    /**
     * 状态
     * 
     * Column Type: tinyint(3)
     * Default: 0
     * 
     * @param int $status
     * @return \M\MytFinanceLogs
     */
    public function setStatus($status) {
        $this->_status = (int)$status;
        $this->_params['status'] = (int)$status;
        return $this;
    }

    /**
     * 状态
     * 
     * Column Type: tinyint(3)
     * Default: 0
     * 
     * @return int
     */
    public function getStatus() {
        return $this->_status;
    }

    /**
     * 是否删除
     * 
     * Column Type: varchar(255)
     * 
     * @param string $is_del
     * @return \M\MytFinanceLogs
     */
    public function setIs_del($is_del) {
        $this->_is_del = (string)$is_del;
        $this->_params['is_del'] = (string)$is_del;
        return $this;
    }

    /**
     * 是否删除
     * 
     * Column Type: varchar(255)
     * 
     * @return string
     */
    public function getIs_del() {
        return $this->_is_del;
    }

    /**
     * 创建时间
     * 
     * Column Type: bigint(20)
     * Default: 0
     * 
     * @param int $create_at
     * @return \M\MytFinanceLogs
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
     * 更新时间
     * 
     * Column Type: bigint(11)
     * Default: 20
     * 
     * @param int $update_at
     * @return \M\MytFinanceLogs
     */
    public function setUpdate_at($update_at) {
        $this->_update_at = (int)$update_at;
        $this->_params['update_at'] = (int)$update_at;
        return $this;
    }

    /**
     * 更新时间
     * 
     * Column Type: bigint(11)
     * Default: 20
     * 
     * @return int
     */
    public function getUpdate_at() {
        return $this->_update_at;
    }

    /**
     * Return a array of model properties
     * 
     * @return array
     */
    public function toArray() {
        return array(
            'id'           => $this->_id,
            'user_id'      => $this->_user_id,
            'amount'       => $this->_amount,
            'type'         => $this->_type,
            'finance_type' => $this->_finance_type,
            'status'       => $this->_status,
            'is_del'       => $this->_is_del,
            'create_at'    => $this->_create_at,
            'update_at'    => $this->_update_at
        );
    }

}
