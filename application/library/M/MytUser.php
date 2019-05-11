<?php

/**
 * 用户表
 * 
 * @Table Schema: payment
 * @Table Name: pay_user
 */
namespace M;

class MytUser extends \M\ModelAbstract {

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
     * 用户名
     * 
     * Column Type: varchar(20)
     * 
     * @var string
     */
    protected $_user_name = '';

    /**
     * 手机号
     * 
     * Column Type: char(11)
     * 
     * @var string
     */
    protected $_mobile = '';

    /**
     * 密码
     * 
     * Column Type: varchar(60)
     * 
     * @var string
     */
    protected $_password = '';

    /**
     * 创建时间
     * 
     * Column Type: int(2)
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
     * 真实姓名
     * 
     * Column Type: varchar(20)
     * 
     * @var string
     */
    protected $_real_name = '';

    /**
     * 身份证号
     * 
     * Column Type: varchar(18)
     * 
     * @var string
     */
    protected $_id_card_no = '';

    /**
     * 最新一次登陆ip
     * 
     * Column Type: char(15)
     * 
     * @var string
     */
    protected $_login_ip = '';

    /**
     * 最新登陆时间
     * 
     * Column Type: bigint(20)
     * Default: 0
     * 
     * @var int
     */
    protected $_login_at = 0;

    /**
     * 是否被删除
     * 
     * Column Type: tinyint(1)
     * Default: 0
     * 
     * @var int
     */
    protected $_is_del = 0;

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
     * @return \M\MytUser
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
     * 用户名
     * 
     * Column Type: varchar(20)
     * 
     * @param string $user_name
     * @return \M\MytUser
     */
    public function setUser_name($user_name) {
        $this->_user_name = (string)$user_name;
        $this->_params['user_name'] = (string)$user_name;
        return $this;
    }

    /**
     * 用户名
     * 
     * Column Type: varchar(20)
     * 
     * @return string
     */
    public function getUser_name() {
        return $this->_user_name;
    }

    /**
     * 手机号
     * 
     * Column Type: char(11)
     * 
     * @param string $mobile
     * @return \M\MytUser
     */
    public function setMobile($mobile) {
        $this->_mobile = (string)$mobile;
        $this->_params['mobile'] = (string)$mobile;
        return $this;
    }

    /**
     * 手机号
     * 
     * Column Type: char(11)
     * 
     * @return string
     */
    public function getMobile() {
        return $this->_mobile;
    }

    /**
     * 密码
     * 
     * Column Type: varchar(60)
     * 
     * @param string $password
     * @return \M\MytUser
     */
    public function setPassword($password) {
        $this->_password = (string)$password;
        $this->_params['password'] = (string)$password;
        return $this;
    }

    /**
     * 密码
     * 
     * Column Type: varchar(60)
     * 
     * @return string
     */
    public function getPassword() {
        return $this->_password;
    }

    /**
     * 创建时间
     * 
     * Column Type: int(2)
     * Default: 0
     * 
     * @param int $create_at
     * @return \M\MytUser
     */
    public function setCreate_at($create_at) {
        $this->_create_at = (int)$create_at;
        $this->_params['create_at'] = (int)$create_at;
        return $this;
    }

    /**
     * 创建时间
     * 
     * Column Type: int(2)
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
     * @return \M\MytUser
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
     * 真实姓名
     * 
     * Column Type: varchar(20)
     * 
     * @param string $real_name
     * @return \M\MytUser
     */
    public function setReal_name($real_name) {
        $this->_real_name = (string)$real_name;
        $this->_params['real_name'] = (string)$real_name;
        return $this;
    }

    /**
     * 真实姓名
     * 
     * Column Type: varchar(20)
     * 
     * @return string
     */
    public function getReal_name() {
        return $this->_real_name;
    }

    /**
     * 身份证号
     * 
     * Column Type: varchar(18)
     * 
     * @param string $id_card_no
     * @return \M\MytUser
     */
    public function setId_card_no($id_card_no) {
        $this->_id_card_no = (string)$id_card_no;
        $this->_params['id_card_no'] = (string)$id_card_no;
        return $this;
    }

    /**
     * 身份证号
     * 
     * Column Type: varchar(18)
     * 
     * @return string
     */
    public function getId_card_no() {
        return $this->_id_card_no;
    }

    /**
     * 最新一次登陆ip
     * 
     * Column Type: char(15)
     * 
     * @param string $login_ip
     * @return \M\MytUser
     */
    public function setLogin_ip($login_ip) {
        $this->_login_ip = (string)$login_ip;
        $this->_params['login_ip'] = (string)$login_ip;
        return $this;
    }

    /**
     * 最新一次登陆ip
     * 
     * Column Type: char(15)
     * 
     * @return string
     */
    public function getLogin_ip() {
        return $this->_login_ip;
    }

    /**
     * 最新登陆时间
     * 
     * Column Type: bigint(20)
     * Default: 0
     * 
     * @param int $login_at
     * @return \M\MytUser
     */
    public function setLogin_at($login_at) {
        $this->_login_at = (int)$login_at;
        $this->_params['login_at'] = (int)$login_at;
        return $this;
    }

    /**
     * 最新登陆时间
     * 
     * Column Type: bigint(20)
     * Default: 0
     * 
     * @return int
     */
    public function getLogin_at() {
        return $this->_login_at;
    }

    /**
     * 是否被删除
     * 
     * Column Type: tinyint(1)
     * Default: 0
     * 
     * @param int $is_del
     * @return \M\MytUser
     */
    public function setIs_del($is_del) {
        $this->_is_del = (int)$is_del;
        $this->_params['is_del'] = (int)$is_del;
        return $this;
    }

    /**
     * 是否被删除
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
     * Return a array of model properties
     * 
     * @return array
     */
    public function toArray() {
        return array(
            'id'         => $this->_id,
            'user_name'  => $this->_user_name,
            'mobile'     => $this->_mobile,
            'password'   => $this->_password,
            'create_at'  => $this->_create_at,
            'update_at'  => $this->_update_at,
            'real_name'  => $this->_real_name,
            'id_card_no' => $this->_id_card_no,
            'login_ip'   => $this->_login_ip,
            'login_at'   => $this->_login_at,
            'is_del'     => $this->_is_del
        );
    }

}
