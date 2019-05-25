<?php
/**
 * Created by PhpStorm.
 * User: chendongqin
 * Date: 2019/5/13
 * Time: 21:32
 */

namespace Business;


use Ku\Http;

class Kuaiqianoqs extends BusinessAbstract
{
    use Instance;


    /**
     * pos发起查询
     * @param \M\MytTradeOrder $order
     * @param $url
     * @param string $ext1
     * @param string $ext2
     * @return array|bool|\Ku\json|null|Object|string
     */
    public function oqs_request(\M\MytTradeOrder $order, $url, $ext1 = '', $ext2 = '')
    {
        $merchant = \M\Mapper\MytMerchant::getInstance()->findById($order->getMerchant_id());
        if (!$merchant instanceof \M\MytMerchant) {
            return $this->getMsg(400, '商户存在');
        }
        $requestTime = date('Y-m-d');
        $params = [
            'orderId'    => $order->getOut_trade_no(),
            'reqTime'    => $requestTime,
            'merchantId' => $merchant->getApp_id(),
            'terminalId' => $merchant->getTermianal_sn()
        ];
        $signStr = 'orderId=' . $order->getOut_trade_no() . '&reqTime =' . $requestTime;
        if ($ext1) {
            $params['ext1'] = $ext1;
            $signStr .= '&ext1=' . $ext1;
        }
        if ($ext2) {
            $params['ext2'] = $ext2;
            $signStr .= '&ext2=' . $ext2;
        }
        $MAC = $this->createSign($signStr, APPLICATION_PATH . $merchant->getOqs_private_key());
        $params['MAC'] = $MAC;
        $http = new Http();
        $http->setUrl($url);
        $http->setParam($params, true);
        $res = $http->send();
        return $res;
    }

    /**
     * oqs请求返回结果
     * @param $orderSn
     * @param $reqTime
     * @param $MAC
     * @param $ext1
     * @param $ext2
     * @return string
     */
    public function oqs($orderSn, $reqTime, $MAC, $ext1, $ext2)
    {
        $order = \M\Mapper\MytTradeOrder::getInstance()->findByOut_trade_no($orderSn);
        if (!$order instanceof \M\MytTradeOrder) {
            $res = $this->oqs_response($reqTime, $orderSn, '56');
            return $this->returnResponse($res);
        }
        $merchant = \M\Mapper\MytMerchant::getInstance()->findById($order->getMerchant_id());
        if (!$merchant instanceof \M\MytMerchant) {
            $res = $this->oqs_response($reqTime, $orderSn, '13');
            return $this->returnResponse($res);
        }
        $signStr = 'orderId=' . $orderSn . '&reqTime =' . $reqTime;
        if ($ext1) {
            $signStr .= '&ext1=' . $ext1;
        }
        if ($ext2) {
            $signStr .= '&ext2=' . $ext2;
        }
        $verifyRes = $this->verifySign($signStr, $MAC, $merchant->getOqs_public_key());
        if ($verifyRes === false) {
            $res = $this->oqs_response($reqTime, $orderSn, '67', '签名错误');
            return $this->returnResponse($res, $merchant->getOqs_private_key());
        }
        //设置扩展参数：key为标签名，value为值，chrName为数据的名称
        $responseExt = [];
        $responseExt = $this->createExt($responseExt);
        $res = $this->oqs_response($reqTime, $orderSn, '00', '', $merchant->getApp_id(), $merchant->getMerchant_name(), $order->getAmount(), $responseExt);
        return $this->returnResponse($res, $merchant->getOqs_private_key());
    }

    /**
     * 创建签名
     * @param $signStr
     * @param $pem_path
     * @return string
     */
    public function createSign($signStr, $pem_path)
    {
        $fp = fopen($pem_path, 'r');
        $priv_key = fread($fp, 8192);
        fclose($fp);
        $pkeyid = openssl_get_privatekey($priv_key);

        openssl_sign($signStr, $signMsg, $pkeyid, OPENSSL_ALGO_SHA1);

        openssl_free_key($pkeyid);

        $MAC = base64_encode($signMsg);
        return $MAC;
    }

    /**
     * 校验签名
     * @param $signStr
     * @param $verifyStr
     * @param $pem_path
     * @return bool
     */
    public function verifySign($signStr, $verifyStr, $pem_path)
    {
        $verifyStr = base64_decode($verifyStr);
        $fp = fopen($pem_path, 'r');
        $cert = fread($fp, 8192);
        fclose($fp);
        $pubkeyid = openssl_get_publickey($cert);
        $ok = (boolean)openssl_verify($signStr, $verifyStr, $pubkeyid);
        return $ok;
    }

    /**
     * 返回建签的xml
     * @param $reqTime
     * @param $orderSn
     * @param $responseCode
     * @param $responseMsg
     * @param string $merchantId
     * @param string $merchantName
     * @param int $amt
     * @param string $ext
     * @return string
     */
    public function oqs_response($reqTime, $orderSn, $responseCode, $responseMsg = '', $merchantId = '', $merchantName = '', $amt = 0, $ext = '')
    {
        if (empty($ext)) {
            $ext = '<ext></ext>';
        }
        $respTime = date('YmdHis');
        $xml_sign = '<MessageContent><reqTime>' . $reqTime . '</reqTime><respTime>' . $respTime . '</respTime><responseCode>' . $responseCode . '</responseCode>';
        if ($responseMsg) {
            $xml_sign .= '<responseMsg>' . $responseMsg . '</responseMsg>';
        }
        $xml_sign .= '<message><orderId>' . $orderSn . '</orderId><merchantId>' . $merchantId . '</merchantId><merchantName>' . $merchantName . '</merchantName><amt>' . $amt . '</amt><amt2></amt2><amt3></amt3><amt4></amt4>' . $ext . '</message></MessageContent>';
        return $xml_sign;
    }

    /**
     * 创建扩展信息
     * @param $exts
     * @return string
     */
    public function createExt($exts)
    {
        $str = '<ext>';
        if (!empty($exts)) {
            foreach ($exts as $key => $ext) {
                $str .= '<' . $key . '><value>' . $ext['value'] . '</value><chnName>' . $ext['chnName'] . '</chnName></' . $key . '>';
            }
        }
        $str .= '</ext>';
        return $str;
    }

    /**
     * 输出的xml
     * @param $xml_sign
     * @param string $privateKeyPath
     * @return string
     */
    public function returnResponse($xml_sign, $privateKeyPath = '')
    {
        $MAC = '';
        if (!empty($privateKeyPath)) {
            $MAC = $this->createSign($xml_sign, $privateKeyPath);
        }
        $config = new \Yaf\Config\Ini(\APPLICATION_PATH . '/conf/pay.ini', \Yaf\Application::app()->environ());
        $config = $config->get('pay.kuaiqianpay');

        if (!$config instanceof \Yaf\Config\Ini) {
            throw new \Exception('invalid configure');
        }
        $xml_info = '<?xml version="' . $config['version'] . '" encoding="UTF-8"?><ResponseMessage><MAC>' . $MAC . '</MAC>' . $xml_sign . '</ResponseMessage>';
        return $xml_info;
    }

}