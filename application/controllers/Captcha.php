<?php

use \Ku\Captcha;

/**
 * 验证码输出
 */
class CaptchaController extends Base\ApplicationController {

    /**
     * 布局模板的名称
     * @var sting
     */
    protected $layout = '';

    public function init() {
        $this->disableView();
    }

    public function indexAction() {
        return false;
    }

    /**
     * 显示验证码
     *
     * 输出png图片
     */
    public function showAction($key = '') {
        $captcha = new Captcha($key);
        $captcha->show();
    }

}
