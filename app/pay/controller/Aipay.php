<?php
namespace app\pay\controller;

use app\core\controller\Common;
use app\pay\model\PublicModel;
use app\pay\model\ExecModel;
use think\Exception;
use think\Controller;
use app\admin\model\SpreadModel;
use app\core\model\CommonModel;
use think\Db;
use think\Model;

/**
 * 爱贝web处理类
 */
Class Aipay extends Common
{
    private $m_pub;
    public function __construct()
    {
        parent::__construct();
        $this->m_pub = new PublicModel();
    }

    /**
     * 爱贝接口入口
     * @order_id request 订单id
     * @timestamp request 时间戳
     * @sign request 签名
     */
    public function index()
    {
    
        $order_id = I("request.order_id", null);
        $timestamp = I("request.timestamp", null);
        $sign = I("request.sign", null);


        $r = $this->m_pub->auth($order_id, $timestamp, $sign);

        if ($r["code"] !== "1") {
            if (IS_AJAX) {
                die_result('-100', "本请求失效或超时,请重新发起请求" . $sign);
            } else {
                $this->redirect('/');
            }
        }
        //修改爱贝支付类型
        M("order_list_parent")->where(array("order_id" => $order_id))->setField("plat_form","aipay");
        //下单等流程
        $url = $this->order($order_id);
        if($url == "failed"){
            $this->error("下单错误");
        }
        $this->redirect($url);
    }

    /**
     * 爱贝下单
     * @return array
     */
    public function order($order_id){

        $OrderListParent = M('order_list_parent');

        $order_info = $OrderListParent->field('id,order_id,price,name,close_time,username,uid')->where(['order_id'=>$order_id])->find();
        $orderUrl = "http://ipay.iapppay.com:9999/payapi/order";
        $appkey = $this->get_conf("AIPAY_PRIVATE_KEY");
        $platpkey = $this->get_conf("AIPAY_PLAT_KEY");
        $appid = $this->get_conf("AIPAY_APPID");
        //下单接口
        /*$orderReq['appid'] = "$appid";
        $orderReq['waresid'] = 1;
        $orderReq['waresname'] = "123";
        $orderReq['cporderid'] = "16041822164353176"; //确保该参数每次 都不一样。否则下单会出问题。
        $orderReq['price'] = 0.01;   //单位：元
        $orderReq['currency'] = 'RMB';
        $orderReq['appuserid'] = 'blueshow@vip.qq.com';
        $orderReq['cpprivateinfo'] = '11qwe123r23q2321ss11';
        $orderReq['notifyurl'] = $this->get_conf("AIPAY_NOTIFY_URL");*/
        //下单接口
        $orderReq['appid'] = $appid;
        $orderReq['waresid'] = 1;
        $orderReq['waresname'] = $order_info['name'];
        $orderReq['cporderid'] = $order_id; //确保该参数每次 都不一样。否则下单会出问题。
        $orderReq['price'] = floatval($order_info['price']);   //单位：元
        $orderReq['cpprivateinfo'] = "";
        $orderReq['appuserid'] = $order_info['uid'];
        $orderReq['currency'] = 'RMB';
        $orderReq['notifyurl'] = U('Notify/aipay_result',null,true,get_conf_domain());//$this->get_conf("AIPAY_NOTIFY_URL");

        if (strtolower(C('OPEN_TEST_ENV')) == 'true') {
            $orderReq['price'] = 0.01;
        }

        //组装请求报文  对数据签名
        $aipay = new \app\pay\controller\Aipay();
        $reqData = $aipay->composeReq($orderReq, $appkey);

        //发送到爱贝服务后台请求下单
        $respData = $aipay->request_by_curl($orderUrl, $reqData, 'order test');

        //验签数据并且解析返回报文
        if(!$aipay->parseResp($respData, $platpkey, $respJson)) {
            return  "failed";
        }else{
            //     下单成功之后获取 transid
            $pcurl         = "https://web.iapppay.com/pc/exbegpay?";

            $url_data['transid']=$respJson->transid;
            $url_data['cpurl']       = 'aaa';
            $url_data['redirecturl'] = U('yyg/pay/pay_result',null,true,get_conf_domain());//$this->get_conf("AIPAY_REDIRECT_URL");
            $reqData                 = $aipay->composeReq($url_data, $appkey);

            $url=$pcurl.$reqData;//我们的常连接版本 有PC 版本 和移动版本。 根据使用的环境不同请更换相应的URL:$h5url,$pcurl.
  
            return $url;
        }
    }

    /**格式化公钥
     * $pubKey PKCS#1格式的公钥串
     * return pem格式公钥， 可以保存为.pem文件
     */
    function formatPubKey($pubKey) {
        $fKey = "-----BEGIN PUBLIC KEY-----\n";
        $len = strlen($pubKey);
        for($i = 0; $i < $len; ) {
            $fKey = $fKey . substr($pubKey, $i, 64) . "\n";
            $i += 64;
        }
        $fKey .= "-----END PUBLIC KEY-----";
        return $fKey;
    }


    /**格式化公钥
     * $priKey PKCS#1格式的私钥串
     * return pem格式私钥， 可以保存为.pem文件
     */
    function formatPriKey($priKey) {
        $fKey = "-----BEGIN RSA PRIVATE KEY-----\n";
        $len = strlen($priKey);
        for($i = 0; $i < $len; ) {
            $fKey = $fKey . substr($priKey, $i, 64) . "\n";
            $i += 64;
        }
        $fKey .= "-----END RSA PRIVATE KEY-----";
        return $fKey;
    }

    /**RSA签名
     * $data待签名数据
     * $priKey商户私钥
     * 签名用商户私钥
     * 使用MD5摘要算法
     * 最后的签名，需要用base64编码
     * return Sign签名
     */
    function sign($data, $priKey) {
        //转换为openssl密钥
        $res = openssl_get_privatekey($priKey);

        try {
	        //调用openssl内置签名方法，生成签名$sign
	        openssl_sign($data, $sign, $res, OPENSSL_ALGO_MD5);
	        //释放资源
	        openssl_free_key($res);
	        
        }catch (\Exception $e) {
        		echo $e->getMessage();
        }

        //base64编码
        $sign = base64_encode($sign);
        return $sign;
    }

    /**RSA验签
     * $data待签名数据
     * $sign需要验签的签名
     * $pubKey爱贝公钥
     * 验签用爱贝公钥，摘要算法为MD5
     * return 验签是否通过 bool值
     */
    function verify($data, $sign, $pubKey)  {
        //转换为openssl格式密钥
        $res = openssl_get_publickey($pubKey);

        //调用openssl内置方法验签，返回bool值
        $result = (bool)openssl_verify($data, base64_decode($sign), $res, OPENSSL_ALGO_MD5);

        //释放资源
        openssl_free_key($res);

        //返回资源是否成功
        return $result;
    }


    /**
     * 解析response报文
     * $content  收到的response报文
     * $pkey     爱贝平台公钥，用于验签
     * $respJson 返回解析后的json报文
     * return    解析成功TRUE，失败FALSE
     */
    function parseResp($content, $pkey, &$respJson) {
        $arr=array_map(create_function('$v', 'return explode("=", $v);'), explode('&', $content));
        foreach($arr as $value) {
            $resp[($value[0])] = $value[1];
        }

        //解析transdata
        if(array_key_exists("transdata", $resp)) {
            $respJson = json_decode($resp["transdata"]);
        } else {
            return FALSE;
        }

        //验证签名，失败应答报文没有sign，跳过验签
        if(array_key_exists("sign", $resp)) {
            //校验签名
            $pkey = $this->formatPubKey($pkey);
            return $this->verify($resp["transdata"], $resp["sign"], $pkey);
        } else if(array_key_exists("errmsg", $respJson)) {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * curl方式发送post报文
     * $remoteServer 请求地址
     * $postData post报文内容
     * $userAgent用户属性
     * return 返回报文
     */
    function request_by_curl($remoteServer, $postData, $userAgent) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remoteServer);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        $data = urldecode(curl_exec($ch));
        curl_close($ch);

        return $data;
    }

    //根据订单号查询状态
    public function ReqData($order_id)
    {
        global $appkey,$platpkey;
        $queryResultUrl = "http://ipay.iapppay.com:9999/payapi/queryresult";
        $appkey = C('AIPAY_PRIVATE_KEY');
        $platpkey = C('AIPAY_PLAT_KEY');

        //$contentdata["cporderid"] = "1607060249466659";
        $order_id = $order_id;
        $contentdata["appid"] = C('AIPAY_APPID');
        $contentdata["cporderid"] = $order_id;
        $reqData = $this->composeReq($contentdata, $appkey);
        $conten = $this->HttpPost($queryResultUrl, $reqData);
        if ( !$conten ) {
            return false;
        }
        $content ='';
//        [
//        'appid' =>  '3005498368',
//        'appuserid' => '20744',
//        'cporderid' => '1607060249466659',
//        'cpprivate' =>  '',
//        'currency' =>  'RMB',
//        'feetype' =>  0,
//        'money' =>  0.01,
//        'paytype' =>  403,
//        'result' =>  0, //0为支付成功
//        'transid' => '32211607061449485227',
//        'transtime' =>'2016-07-06 14:50:08',
//        'waresid' =>  1,
//        ];
        $this->parseResp($conten,$platpkey,$content);
        return json_encode($content);

    }


    /**
     * 组装request报文
     * $reqJson 需要组装的json报文
     * $vkey  cp私钥，格式化之前的私钥
     * return 返回组装后的报文
     */
    function composeReq($reqJson, $vkey) {
        //获取待签名字符串
        $content = json_encode($reqJson);
        //格式化key，建议将格式化后的key保存，直接调用
        $vkey = $this->formatPriKey($vkey);

        //生成签名
        $sign = $this->sign($content, $vkey);

        //组装请求报文，目前签名方式只支持RSA这一种
        $reqData = "transdata=".urlencode($content)."&sign=".urlencode($sign)."&signtype=RSA";

        return $reqData;
    }



//发送post请求 ，并得到响应数据  和对数据进行验签
    function HttpPost($Url,$reqData){
        global  $cpvkey, $platpkey;
        $respData = $this->request_by_curl($Url,$reqData," demo ");
        if(!$this->parseResp($respData,$platpkey, $notifyJson)) {
            //获取数据失败
            return false;
        }
        return  $respData;
    }



}