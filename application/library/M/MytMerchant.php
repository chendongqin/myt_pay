<?php

/**
 * 商户表
 * 
 * @Table Schema: myt_pay
 * @Table Name: myt_merchant
 */
namespace M;

class MytMerchant extends \M\ModelAbstract {

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
     * 商户名称
     * 
     * Column Type: varchar(255)
     * 
     * @var string
     */
    protected $_merchant_name = '';

    /**
     * 商户appId
     * 
     * Column Type: varchar(50)
     * 
     * @var string
     */
    protected $_app_id = '';

    /**
     * 快钱公钥
     * 
     * Column Type: text
     * 
     * @var string
     */
    protected $_public_key = null;

    /**
     * 快钱私钥
     * 
     * Column Type: text
     * 
     * @var string
     */
    protected $_private_key = null;

    /**
     * 快钱商户编号
     * 
     * Column Type: varchar(50)
     * 
     * @var string
     */
    protected $_merchat_sn = '';

    /**
     * 快钱分配商户的终端号
     * 
     * Column Type: varchar(50)
     * 
     * @var string
     */
    protected $_termianal_sn = '';

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
     * Column Type: bigint(20)
     * Default: 0
     * 
     * @var int
     */
    protected $_update_at = 0;

    /**
     * 是否删除
     * 
     * Column Type: tinyint(1)
     * Default: 0
     * 
     * @var int
     */
    protected $_is_del = 0;

    /**
     * oqs私钥证书相对目录地址
     * 
     * Column Type: varchar(255)
     * 
     * @var string
     */
    protected $_oqs_private_key = '';

    /**
     * oqs公钥证书相对目录地址
     * 
     * Column Type: varchar(255)
     * 
     * @var string
     */
    protected $_oqs_public_key = '';

    /**
     * mas公钥证书相对目录地址
     * 
     * Column Type: varchar(255)
     * 
     * @var string
     */
    protected $_mas_public_key = '';

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
     * @return \M\Mytmerchant
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
     * 商户名称
     * 
     * Column Type: varchar(255)
     * 
     * @param string $merchant_name
     * @return \M\Mytmerchant
     */
    public function setMerchant_name($merchant_name) {
        $this->_merchant_name = (string)$merchant_name;
        $this->_params['merchant_name'] = (string)$merchant_name;
        return $this;
    }

    /**
     * 商户名称
     * 
     * Column Type: varchar(255)
     * 
     * @return string
     */
    public function getMerchant_name() {
        return $this->_merchant_name;
    }

    /**
     * 商户appId
     * 
     * Column Type: varchar(50)
     * 
     * @param string $app_id
     * @return \M\Mytmerchant
     */
    public function setApp_id($app_id) {
        $this->_app_id = (string)$app_id;
        $this->_params['app_id'] = (string)$app_id;
        return $this;
    }

    /**
     * 商户appId
     * 
     * Column Type: varchar(50)
     * 
     * @return string
     */
    public function getApp_id() {
        return $this->_app_id;
    }

    /**
     * 快钱公钥
     * 
     * Column Type: text
     * 
     * @param string $public_key
     * @return \M\Mytmerchant
     */
    public function setPublic_key($public_key) {
        $this->_public_key = (string)$public_key;
        $this->_params['public_key'] = (string)$public_key;
        return $this;
    }

    /**
     * 快钱公钥
     * 
     * Column Type: text
     * 
     * @return string
     */
    public function getPublic_key() {
        return $this->_public_key;
    }

    /**
     * 快钱私钥
     * 
     * Column Type: text
     * 
     * @param string $private_key
     * @return \M\Mytmerchant
     */
    public function setPrivate_key($private_key) {
        $this->_private_key = (string)$private_key;
        $this->_params['private_key'] = (string)$private_key;
        return $this;
    }

    /**
     * 快钱私钥
     * 
     * Column Type: text
     * 
     * @return string
     */
    public function getPrivate_key() {
        return $this->_private_key;
    }

    /**
     * 快钱商户编号
     * 
     * Column Type: varchar(50)
     * 
     * @param string $merchat_sn
     * @return \M\Mytmerchant
     */
    public function setMerchat_sn($merchat_sn) {
        $this->_merchat_sn = (string)$merchat_sn;
        $this->_params['merchat_sn'] = (string)$merchat_sn;
        return $this;
    }

    /**
     * 快钱商户编号
     * 
     * Column Type: varchar(50)
     * 
     * @return string
     */
    public function getMerchat_sn() {
        return $this->_merchat_sn;
    }

    /**
     * 快钱分配商户的终端号
     * 
     * Column Type: varchar(50)
     * 
     * @param string $termianal_sn
     * @return \M\Mytmerchant
     */
    public function setTermianal_sn($termianal_sn) {
        $this->_termianal_sn = (string)$termianal_sn;
        $this->_params['termianal_sn'] = (string)$termianal_sn;
        return $this;
    }

    /**
     * 快钱分配商户的终端号
     * 
     * Column Type: varchar(50)
     * 
     * @return string
     */
    public function getTermianal_sn() {
        return $this->_termianal_sn;
    }

    /**
     * 创建时间
     * 
     * Column Type: bigint(20)
     * Default: 0
     * 
     * @param int $create_at
     * @return \M\Mytmerchant
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
     * Column Type: bigint(20)
     * Default: 0
     * 
     * @param int $update_at
     * @return \M\Mytmerchant
     */
    public function setUpdate_at($update_at) {
        $this->_update_at = (int)$update_at;
        $this->_params['update_at'] = (int)$update_at;
        return $this;
    }

    /**
     * 更新时间
     * 
     * Column Type: bigint(20)
     * Default: 0
     * 
     * @return int
     */
    public function getUpdate_at() {
        return $this->_update_at;
    }

    /**
     * 是否删除
     * 
     * Column Type: tinyint(1)
     * Default: 0
     * 
     * @param int $is_del
     * @return \M\Mytmerchant
     */
    public function setIs_del($is_del) {
        $this->_is_del = (int)$is_del;
        $this->_params['is_del'] = (int)$is_del;
        return $this;
    }

    /**
     * 是否删除
     * 
     * Column Type: tinyint(1)
     * Default: 0
     * 
     * @return int
     */
    public function getIs_del() {
        return $this->_is_del;
    }

    /**
     * oqs私钥证书相对目录地址
     * 
     * Column Type: varchar(255)
     * 
     * @param string $oqs_private_key
     * @return \M\Mytmerchant
     */
    public function setOqs_private_key($oqs_private_key) {
        $this->_oqs_private_key = (string)$oqs_private_key;
        $this->_params['oqs_private_key'] = (string)$oqs_private_key;
        return $this;
    }

    /**
     * oqs私钥证书相对目录地址
     * 
     * Column Type: varchar(255)
     * 
     * @return string
     */
    public function getOqs_private_key() {
        return $this->_oqs_private_key;
    }

    /**
     * oqs公钥证书相对目录地址
     * 
     * Column Type: varchar(255)
     * 
     * @param string $oqs_public_key
     * @return \M\Mytmerchant
     */
    public function setOqs_public_key($oqs_public_key) {
        $this->_oqs_public_key = (string)$oqs_public_key;
        $this->_params['oqs_public_key'] = (string)$oqs_public_key;
        return $this;
    }

    /**
     * oqs公钥证书相对目录地址
     * 
     * Column Type: varchar(255)
     * 
     * @return string
     */
    public function getOqs_public_key() {
        return $this->_oqs_public_key;
    }

    /**
     * mas公钥证书相对目录地址
     * 
     * Column Type: varchar(255)
     * 
     * @param string $mas_public_key
     * @return \M\Mytmerchant
     */
    public function setMas_public_key($mas_public_key) {
        $this->_mas_public_key = (string)$mas_public_key;
        $this->_params['mas_public_key'] = (string)$mas_public_key;
        return $this;
    }

    /**
     * mas公钥证书相对目录地址
     * 
     * Column Type: varchar(255)
     * 
     * @return string
     */
    public function getMas_public_key() {
        return $this->_mas_public_key;
    }

    /**
     * Return a array of model properties
     * 
     * @return array
     */
    public function toArray() {
        return array(
            'id'              => $this->_id,
            'merchant_name'   => $this->_merchant_name,
            'app_id'          => $this->_app_id,
            'public_key'      => $this->_public_key,
            'private_key'     => $this->_private_key,
            'merchat_sn'      => $this->_merchat_sn,
            'termianal_sn'    => $this->_termianal_sn,
            'create_at'       => $this->_create_at,
            'update_at'       => $this->_update_at,
            'is_del'          => $this->_is_del,
            'oqs_private_key' => $this->_oqs_private_key,
            'oqs_public_key'  => $this->_oqs_public_key,
            'mas_public_key'  => $this->_mas_public_key
        );
    }

}
