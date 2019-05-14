<?php
/**
 * Created by PhpStorm.
 * User: chendongqin
 * Date: 2019/5/12
 * Time: 14:29
 */
class LoginController extends \Base\ApiController
{

    public function indexAction(){
        return $this->returnData('成功',true);
    }

    public function iAction()
    {
        $request = $this->getRequest();
        $callback = \Ku\Tool::filter($request->get('callback', null));
        if ($this->checkCaptcha($request->get('captcha'),'login') === false) {
            return $this->returnData('验证码错误', 23205, false);
        }
        if ($this->useLimit('user.resource.limit.login.' . \Ku\Tool::getClientIp(true), 20, 600) === true) {
            $this->returnData('登录操作太频繁了, 请休息下吧', 23101, false, array(
                'using_captcha' => $this->useCaptcha('login') === true ? 1 : 0
            ), $callback);
            return false;
        }
        $username = $request->get('username');
        $password = $request->get('password');
        $login = \Business\LoginModel::getInstance();
        $res = $login->login($username, $password);
        if ($res === false) {
            $message = $login->getMessage();
            return $this->returnData($message, 23106,false);
        }
        $redirectUrl = \Ku\Tool::filter($request->get('redirect_url', null));
        $this->returnData('登录成功', 23200, true, array(
            'url' => $this->getRedirectUrl($redirectUrl)
        ), $callback);
        return true;

    }


    public function testAction(){
        $payBusiness = \Business\Kuaiqianpay::getInstance();
        $payBusiness->test();
    }



}