<?php if (!defined('THINK_PATH')) exit(); /*a:8:{s:58:"D:\webroot\mengdie_yyg\app\www_tpl\default\pay\charge.html";i:1469530424;s:57:"D:\webroot\mengdie_yyg\app\www_tpl\default\base/base.html";i:1470730361;s:63:"D:\webroot\mengdie_yyg\app\www_tpl\default\base/common_css.html";i:1468303703;s:61:"D:\webroot\mengdie_yyg\app\www_tpl\default\base/tool_bar.html";i:1470730313;s:59:"D:\webroot\mengdie_yyg\app\www_tpl\default\base/header.html";i:1468303703;s:59:"D:\webroot\mengdie_yyg\app\www_tpl\default\base/footer.html";i:1470726624;s:61:"D:\webroot\mengdie_yyg\app\www_tpl\default\base/base_url.html";i:1468303703;s:62:"D:\webroot\mengdie_yyg\app\www_tpl\default\base/common_js.html";i:1468303703;}*/ ?>
<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <title>付款</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?php echo htmlspecialchars($site_config['website_desc']); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($site_config['website_keyword']); ?>">
    <link rel="stylesheet" type="text/css" href="__static__/css/common.css" />
<link rel="stylesheet" type="text/css" href="__yyg__/css/common.css" />
<link rel="stylesheet" type="text/css" href="__plugin__/font-awesome/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="__plugin__/bigautocomplete/jquery.bigautocomplete.css" />

    
<link rel="stylesheet" type="text/css" href="__static__/css/payment.css" />

    <script type="text/javascript" src="__static__/js/jquery.min.js"></script>
</head>
<body>
<div class="g-header">
    <div class="m-toolbar" >
    <div class="g-wrap f-clear">
        <div class="m-toolbar-l">
            <span class="m-toolbar-welcome"><?php echo C('WEBSITE_WELCOME'); ?></span>
        </div>
        <ul class="m-toolbar-r">
            <li class="m-toolbar-login">
                <?php if(is_user_login()): ?>
                <div id="pro-view-6"><a class="m-toolbar-login-btn" href="<?php echo dwz_filter('ucenter/index'); ?>"><?php echo get_user_nick_name(); ?></a>
                    <a href="javascript:" class="login_out">退出登录</a></div>
                <?php else: ?>
                <div id=""><a class="m-toolbar-login-btn" href="<?php echo dwz_filter('user/login'); ?>">请登录</a>
                    <a href="<?php echo dwz_filter('user/reg'); ?>" >免费注册</a></div>
                <?php endif; ?>
            </li>
            <li class="m-toolbar-myDuobao">
                <a class="m-toolbar-myDuobao-btn" href="<?php echo dwz_filter('ucenter/index'); ?>">我的夺宝
                    <i class="ico ico-arrow-gray-s ico-arrow-gray-s-down"></i></a>
                <ul class="m-toolbar-myDuobao-menu">
                    <li><a href="<?php echo dwz_filter('ucenter/deposer'); ?>">夺宝记录</a></li>
                    <li class="m-toolbar-myDuobao-menu-win"><a href="<?php echo dwz_filter('ucenter/luck'); ?>">幸运记录</a></li>
                    <!--<li class="m-toolbar-myDuobao-menu-mall"><a href="<?php echo dwz_filter('ucenter/index'); ?>">购买记录</a></li>-->
                    <!--<li class="m-toolbar-myDuobao-menu-gems"><a href="#">我的宝石</a></li>-->
                    <li><a href="<?php echo dwz_filter('pay/recharge'); ?>">账户充值</a></li>
                    <?php if((empty($promote_spread) == false AND $promote_spread['status'] == 1) OR (empty($reg_spread) == false AND $reg_spread['status'] == 1)): ?>
                    <li><a href="<?php echo dwz_filter('ucenter/promote'); ?>">我的推广</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <!--<li class="m-toolbar-myBonus"><a href="#">我的红包</a><var>|</var></li>-->
            <li>
                <a href="<?php echo C('WEBSITE_SINA_WEIBO'); ?>" target="_blank">
                <img width="16" height="13" style="float:left;margin:8px 3px 0 0;" src="__static__/img/icon_weibo_s.png">官方微博</a>
                <var>|</var>
                <a href="<?php echo C('WEBSITE_QQ_GROUP'); ?>" target="_blank">官方交流群</a>
            </li>
            <!--<li><a href="http://1.xiangchang.com/groups.do">官方交流群</a></li>-->
        </ul>
    </div>
</div>
    <script>
    function no_img(img){
        img.attr('src',$("#no_img_url").val());
        img.onerror=null;
    }
</script>
<div class="m-header">
    <div class="g-wrap f-clear">
        <div class="m-header-logo">
            <h1><a class="m-header-logo-link" href="/" style="background-image: url('<?php echo C("WEBSITE_LOGO"); ?>')"><?php echo C('WEBSITE_NAME'); ?></a></h1>
            <div class="m-header-slogan">
                <a class="m-header-slogan-link" href="<?php echo C('ANDROID_DOWNLOAD_URL'); ?>" target="_blank" style="height: 90px;">
                    <img src="<?php echo C('WEBSITE_LOGO_SUB'); ?>" style="height: 90px;"></a>
            </div>
        </div>

        <div class="w-miniCart" id="cart_list_fade_in">
            <a class="w-miniCart-btn" href="javascript:void(0);" data-pro="btn"><i class="ico ico-miniCart"></i>清 单
                <b class="w-miniCart-count" >
                    <i class="ico ico-arrow-white-solid ico-arrow-white-solid-l"></i><p id="cart_num"><?php echo (isset($cart_num) && ($cart_num !== '')?$cart_num:'0'); ?></p></b>
            </a>
            <div class="w-layer w-miniCart-layer" style="display: none" id="cart_box_hidden">

                <div pro="title">
                    <p class="w-miniCart-layer-title" id="pro-view-28"><strong>最近加入的商品</strong></p>
                </div>

                <div id="cart_div_area">
                    <div class="w-miniCart-loading">
                        <b class="w-loading-ico"></b><span class="w-loading-txt">加载中……</span>
                    </div>
                   <!-- <ul pro="list" class="w-miniCart-list">
                        <li class="w-miniCart-item" id="pro-view-27">
                            <div class="w-miniCart-item-pic">
                                <img src="../../img/goods/b2.png" alt="佳能 EOS 5D Mark III 单反机身(无镜头)" width="74px" height="74px" />
                            </div>
                            <div class="w-miniCart-item-text">
                                <p><strong>佳能 EOS 5D Mark III 单反机身(无镜头)</strong></p>
                                <p><em>730<?php echo C('MONEY_NAME'); ?> &times; 1期</em><a class="w-miniCart-item-del" href="javascript:void(0);" pro="del">删除</a></p>
                            </div></li>
                    </ul>
                    <div pro="footer" class="w-miniCart-layer-footer" id="pro-view-29">
                        <p><strong>共有<b pro="count">1</b>件商品，金额总计：<em><span pro="amount">730</span><?php echo C('MONEY_NAME'); ?></em></strong></p>
                        <p><button pro="go" class="w-button w-button-main">查看清单并结算</button></p>
                    </div>-->
                </div>
            </div>
        </div>

        <div class="w-search"  id="pro-view-2" >
            <form action="<?php echo dwz_filter('lists/search'); ?>" method="get" id="searchForm" class="w-search-form f-clear" target="_blank">
                <div class="w-input" id="pro-view-3"><div class="autoComplete"><input id="search-condition" class="w-input-input" type="text" placeholder="请输入要搜索的商品" name="keyword"></div></div>
                <button type="submit" class="w-search-btn" ><i class="ico ico-search"></i></button>
            </form>
            <div class="w-search-recKeyWrap">
                <?php if(is_array($keywords)): $i = 0; $__LIST__ = $keywords;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$keyword): $mod = ($i % 2 );++$i;?>
                    <a class="w-search-recKey" href="javascript:void(0);"><?php echo (isset($keyword) && ($keyword !== '')?$keyword:''); ?></a>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
    </div>
</div>
    <div class="m-nav" id="pro-view-1">
        <div class="g-wrap f-clear">
            <div class="m-catlog <?php echo strtolower(MODULE_NAME)=='yyg' && strtolower(CONTROLLER_NAME) == 'index' && strtolower(ACTION_NAME) == 'index'?' m-catlog-normal':' m-catlog-fold'; ?>">
                <div class="m-catlog-hd" style="padding-left:30px;cursor:pointer">
                    <h2>商品分类<i class="ico ico-arrow ico-arrow-white ico-arrow-white-down"></i></h2>
                </div>
                <div class="m-catlog-wrap"
                     style="<?php echo strtolower(MODULE_NAME)=='yyg' && strtolower(CONTROLLER_NAME) == 'index' && strtolower(ACTION_NAME) == 'index'?'':'height: 0; '; ?>">
                    <div class="m-catlog-bd">
                        <ul class="m-catlog-list">
                            <li><a class="catlog-0" href="<?php echo dwz_filter('lists/index',['category'=>0]); ?>">全部商品</a></li>
                            <!--  <?php if(is_array($category_list)): $i = 0; $__LIST__ = $category_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$each_category): $mod = ($i % 2 );++$i;?> -->
                            <li><a href="<?php echo dwz_filter('lists/index',['category'=>$each_category['id']]); ?>">
                                <?php if(empty(trim($each_category["icon"]))): ?>
                                <i class="fa <?php echo (isset($each_category['style']) && ($each_category['style'] !== '')?$each_category['style']:'fa-star-o'); ?>"></i>
                                <span>&nbsp;<?php echo $each_category['name']; ?></span>
                                <?php else: ?>
                                <img style="width: 16px;height: 16px;display: inline-block;" src="<?php echo (isset($each_category['icon']) && ($each_category['icon'] !== '')?$each_category['icon']:''); ?>" alt="">
                                <span style="position: absolute;margin-top: -2px;">&nbsp;<?php echo $each_category['name']; ?></span>
                                <?php endif; ?>

                                </a>
                            </li>
                          <!--   <?php endforeach; endif; else: echo "" ;endif; ?>  -->
                        </ul>
                    </div>
                    <div class="m-catlog-ft"></div>
                </div>
            </div>
            <div class="m-menu">
                <ul class="m-menu-list">
                    <li class="m-menu-list-item <?php echo strtolower(CONTROLLER_NAME) == 'index' && strtolower(ACTION_NAME) == 'index'?' selected':' '; ?>"
                        data-name="index">

                        <a class="m-menu-list-item-link" href="/">首页</a>

                    </li>
                    <li class="m-menu-list-item <?php echo strtolower(CONTROLLER_NAME) == 'lists' && strtolower(ACTION_NAME) == 'ten'?' selected':' '; ?>"
                        data-name="ten">
                        <var>|</var>
                        <a class="m-menu-list-item-link" href="<?php echo dwz_filter('lists/ten'); ?>">十元专区</a>

                    </li>
                    <li class="m-menu-list-item <?php echo strtolower(CONTROLLER_NAME) == 'lists' && strtolower(ACTION_NAME) == 'results'?' selected':' '; ?>"
                        data-name="results">
                        <var>|</var>
                        <a class="m-menu-list-item-link" href="<?php echo dwz_filter('lists/results'); ?>">最新揭晓</a>

                    </li>
                    <li class="m-menu-list-item <?php echo strtolower(CONTROLLER_NAME) == 'share' && strtolower(ACTION_NAME) == 'index'?' selected':' '; ?>"
                        data-name="share">
                        <var>|</var>
                        <a class="m-menu-list-item-link" href="<?php echo dwz_filter('Share/index'); ?>">晒单分享</a>

                    </li>
                    <!--<li class="m-menu-list-item dropdown" data-name="find">-->
                        <!--<var>|</var>-->
                        <!--<a class="m-menu-dropdown" href="javascript:void(0);">活动专区</a>-->

                    <!--</li>-->
                </ul>
            </div>
        </div>
    </div>
</div>
<input id="get_goods_url" type="hidden" value="<?php echo U('index/get_goods_key'); ?>">
<input id="flag_trigger" type="hidden" value="<?php echo U('core/common/flag_trigger'); ?>">


<div class="g-body">
    <div class="m-cashier m-cashier-usePayments">
        <?php if($info["status"] == "1" AND $info["pay_status"] == "1"): ?>
        <div class="m-header">
            <div class="g-wrap f-clear">
                <div class="m-header-logo">
                    <h1><a class="m-header-logo-link" href="javascript:;"><?php echo C('WEBSITE_NAME'); ?></a></h1>
                    <div class="m-header-slogan">
                    </div>
                </div>
                <div class="m-header-steps">
                    <div class="w-step-duobao w-step-duobao-2"></div>
                </div>
            </div>
        </div>
        <!--订单成功-->
        <div class="g-wrap">
            <div class="m-cashier-info">
                <div class="header" id="idOrderHeader">
                    <h2 class="title"><b class="ico ico-suc-m"></b> 订单提交成功，只差最后一步支付就可以啦！</h2>
                    <p class="desc">请您在提交订单后
                        <span id="count_down" data-sec="<?php echo (isset($sec) && ($sec !== '')?$sec:'0'); ?>">
                        <!--<span class="day">&#45;&#45;</span>小时-->
                        <b style="color: #f36;" class="hour">--</b>时
                        <b style="color: #f36;" class="min">--</b>分
                        <b style="color: #f36;" class="sec">--</b>秒
                        </span>
                        完成支付，否则订单会自动取消！</p>
                </div>
                <div class="detail">
                    订单号：<?php echo (isset($info['order_id']) && ($info['order_id'] !== '')?$info['order_id']:'--'); ?><br>
                </div>
            </div>
        </div>
        <div class="g-wrap">
            <div class="m-cashier-amount">
                <div class="header">
                    <div class="amount">应付金额：<span class="txtMoney">￥<?php echo number_format($info['price'],"2"); ?></span></div>
                    <div class="useCoin">
                        <label class="w-checkbox w-checkbox-disabled" disabled="disabled">
                            <?php if((int)$user_money > 0): ?>
                            <input type="checkbox" id="balance_flag"  checked="checked">
                            <span>使用账户余额支付（账户余额：<?php echo round($user_money,"0"); echo C('MONEY_UNIT'); echo C('MONEY_NAME'); ?>）</span>
                            <?php endif; ?>
                            <input type="hidden" id="user_money" value="￥<?php echo number_format($user_money,'2'); ?>">
                            <input type="hidden" id="price" value="￥<?php echo number_format($info['price'],'2'); ?>">
                            <input type="hidden" id="still_money" value="￥<?php echo number_format($still_money,'2'); ?>">
                        </label>
                    </div>

                </div>

                <div class="content ">
                    <div class="stillPay other_pay_list">
                        <div class="payMoney">
                            <span>还需支付：</span>
                            <em class="txtMoney" id="id_still_pay">--</em>
                        </div>
                        <div class="payment">
                            <span class="title">支付方式：</span>
                            <!--<div>-->
                                <!--此处有二维码-->
                            <!--</div>-->
                            <div>
                                <div class="w-pay-selector" id="pro-view-13">
                                    <?php if($pay_type['ALI_PAY'] == '1'): ?>
                                        <div class="w-pay-type  w-pay-selected pay_btn" data-url="<?php echo $alipay_url; ?>">
                                            <img src="__static__/img/0023.png" alt="支付宝" data-type="alipay">
                                        </div>
                                    <?php endif; if($pay_type['WX_THREE_PAY'] == '1'): ?>
                                        <div class="w-pay-type pay_btn">
                                            <img style="width: 140px;height: 49px;" src="__static__/img/wx.png" alt="微信扫码" data-type="wxsm">
                                        </div>
                                    <?php endif; if($pay_type['W_PAY'] == '1'): ?>
                                        <div class="w-pay-type pay_btn">
                                            <img src="__static__/img/SMWX.png" alt="微信扫码" data-type="wxpay">
                                        </div>
                                    <?php endif; if($pay_type['BEE_ALI_PAY'] == '1'): ?>
                                        <div class="w-pay-type pay_btn">
                                            <img src="__static__/img/0023.png" alt="支付宝(BEECLOUD)" data-type="bee-alipay">
                                        </div>
                                    <?php endif; if($pay_type['BEE_W_PAY'] == '1'): ?>
                                        <div class="w-pay-type pay_btn">
                                            <img src="__static__/img/SMWX.png" alt="微信扫码(BEECLOUD)" data-type="bee-wechat">
                                        </div>
                                    <?php endif; if($pay_type['AIBEI_PAY'] == '1'): ?>
                                        <div class="w-pay-type pay_btn">
                                             <img style="width: 140px;height: 49px;" src="__static__/img/aibeipay.jpg" alt="爱贝支付" data-type="aipay">
                                        </div>
                                    <?php endif; ?>

                                    <!--<div class="w-pay-type" ><img src="__static__/img/9999.v2.png" alt=""></div>-->
                                    <!--<div class="w-pay-type w-pay-type-multi" >信用卡</div>-->
                                    <!--<div class="w-pay-type w-pay-type-multi" >储蓄卡</div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="f-clear"></div>
                    <form id="submit_form" action="<?php echo U('pay/notify/order_flow'); ?>" method="post" target="_blank" autocomplete="off">
                        <input type="hidden" name="order_id" value="<?php echo $info['order_id']; ?>">
                        <input type="hidden" name="timestamp" value="<?php echo $timestamp; ?>">
                        <input type="hidden" name="pay_type" value="alipay">
                        <input type="hidden" name="sign" value="<?php echo $sign; ?>">
                        <input type="hidden" name="balance_flag" >
                        <div class="opt">
                            <button class="w-button w-button-main w-button-xl pay_right_now" type="submit">
                                <span>立即支付</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php else: ?>
        <!--订单失效-->
        <div class="g-wrap" >
            <div class="m-cashier-info">
                <div class="header">
                    <h2 class="title"><b class="ico ico-err-m"></b> 订单已失效！</h2>
                </div>
            </div>
        </div>
        <?php endif; ?>



        <!--微信支付-->
        <div class="g-wrap" style="display:none;">
            <div class="m-weixin-header">
                <p><strong>请您及时付款，以便订单尽快处理！订单号：24473852</strong></p>
                <p>请您在提交订单后1小时内支付，否则订单会自动取消。</p>
            </div>

            <div class="m-weixin-main">
                <h1 class="m-weixin-title">微信支付</h1>
                <p class="m-weixin-money">扫一扫付款<br><strong>￥1</strong>
                </p>
                <p>
                    <img id="code" width="260" height="260" class="m-weixin-code" src="__static__/img/qr.png" alt="二维码">
                    <img class="m-weixin-demo" src="__static__/img/weixin_0.png" alt="扫一扫">
                    <img src="__static__/img/weixin_1.png" alt="请使用微信扫描二维码以完成支付">
                </p>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="pay_info_url" value="<?php echo U('Pay/info'); ?>"><!--确认商品信息-->
<input type="hidden" id="check_pay_status" value="<?php echo U('core/pay/check_pay_status'); ?>"><!--检测付款状态-->

<div class="g-footer">
    <div class="m-instruction">
        <div class="g-wrap f-clear">
            <div class="g-main">
                <ul class="m-instruction-list">
                    <li class="m-instruction-list-item">
                        <h5><i class="ico ico-instruction ico-instruction-1"></i>新手指南
                        </h5>
                        <ul class="list">
                            <?php if(is_array($novice_directory)): $i = 0; $__LIST__ = $novice_directory;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$each_help_article): $mod = ($i % 2 );++$i;if($each_help_article["is_hide"] != 1): if(empty($each_help_article['outlink'])): if(empty($each_help_article['name'])): ?>
                            <li><a href="<?php echo dwz_filter('help/read',['id'=>$each_help_article['id']]); ?>" target="_blank"><?php echo htmlspecialchars($each_help_article['title']); ?></a>
                            </li>
                            <?php else: ?>
                            <li><a href="<?php echo dwz_filter('help/read',['name'=>$each_help_article['name']]); ?>" target="_blank"><?php echo htmlspecialchars($each_help_article['title']); ?></a>
                            </li>
                            <?php endif; else: ?>
                            <li><a href="<?php echo $each_help_article['outlink']; ?>" target="_blank"><?php echo htmlspecialchars($each_help_article['title']); ?></a>
                            </li>
                            <?php endif; endif; endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </li>
                    <li class="m-instruction-list-item">
                        <h5><i class="ico ico-instruction ico-instruction-2"></i>夺宝保障
                        </h5>
                        <ul class="list">
                            <?php if(is_array($indiana_security)): $i = 0; $__LIST__ = $indiana_security;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$each_help_article): $mod = ($i % 2 );++$i;if($each_help_article["is_hide"] != 1): if(empty($each_help_article['outlink'])): if(empty($each_help_article['name'])): ?>
                            <li><a href="<?php echo dwz_filter('help/read',['id'=>$each_help_article['id']]); ?>" target="_blank"><?php echo htmlspecialchars($each_help_article['title']); ?></a>
                            </li>
                            <?php else: ?>
                            <li><a href="<?php echo dwz_filter('help/read',['name'=>$each_help_article['name']]); ?>" target="_blank"><?php echo htmlspecialchars($each_help_article['title']); ?></a>
                            </li>
                            <?php endif; else: ?>
                            <li><a href="<?php echo $each_help_article['outlink']; ?>" target="_blank"><?php echo htmlspecialchars($each_help_article['title']); ?></a>
                            </li>
                            <?php endif; endif; endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </li>
                    <li class="m-instruction-list-item">
                        <h5><i class="ico ico-instruction ico-instruction-3"></i>商品配送
                        </h5>
                        <ul class="list">
                            <?php if(is_array($goods_send)): $i = 0; $__LIST__ = $goods_send;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$each_help_article): $mod = ($i % 2 );++$i;if($each_help_article["is_hide"] != 1): if(empty($each_help_article['outlink'])): if(empty($each_help_article['name'])): ?>
	                            <li><a href="<?php echo dwz_filter('help/read',['id'=>$each_help_article['id']]); ?>" target="_blank"><?php echo htmlspecialchars($each_help_article['title']); ?></a>
	                            </li>
	                            <?php else: ?>
	                            <li><a href="<?php echo dwz_filter('help/read',['name'=>$each_help_article['name']]); ?>" target="_blank"><?php echo htmlspecialchars($each_help_article['title']); ?></a>
	                            </li>
	                            <?php endif; else: ?>
                            <li><a href="<?php echo $each_help_article['outlink']; ?>" target="_blank"><?php echo htmlspecialchars($each_help_article['title']); ?></a>
                            </li>
                            <?php endif; endif; endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </li>
                    <li class="m-instruction-list-item">
                        <h5><i class="ico ico-instruction ico-instruction-5"></i>友情链接
                        </h5>
                        <ul class="list">
                            <?php if(is_array($youqinglianjie)): $i = 0; $__LIST__ = $youqinglianjie;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$each_help_article): $mod = ($i % 2 );++$i;?>
                            <li>
                                <a href="<?php echo (isset($each_help_article['url']) && ($each_help_article['url'] !== '')?$each_help_article['url']:'--'); ?>" target="_blank"><?php echo htmlspecialchars($each_help_article['name']); ?></a>
                            </li>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="g-side">
                <div class="g-side-l">
                    <ul class="m-instruction-state f-clear">
                        <li><i class="ico ico-state-l ico-state-l-1"></i>100%公平公正公开</li>
                        <li><i class="ico ico-state-l ico-state-l-2"></i>100%正品保证</li>
                        <li><i class="ico ico-state-l ico-state-l-3"></i>100%权益保障</li>
                    </ul>
                </div>
                <div class="g-side-r">
                    <div class="m-instruction-yxCode">
                        <a href="<?php echo $down_url; ?>" ><img width="100%" src="<?php echo C('WEBSITE_QRCODE'); ?>"></a>
                        <!--<p >下载客户端</p>-->
                    </div>
                    <div class="m-instruction-service">
                        <p><?php echo C('WEB_SERVICE_TIME'); ?></p>
                        <p><?php echo C('WEB_SERVICE_TEL'); ?></p>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="m-copyright">
        <div class="g-wrap">
            <div class="m-copyright-logo">

            </div>
            <div class="m-copyright-txt">
                <p>&nbsp;</p>
                <p> <?php echo C('WEB_INC_INFO'); ?> | <?php echo C('WEBSITE_BEIAN'); ?></p>
            </div>
        </div>
    </div>
</div>
<?php if(isset($notify_list)): if(is_array($notify_list)): $i = 0; $__LIST__ = $notify_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <div style="display: none;" class="luck">
        <div class="luck-bg"></div>
        <div class="luck-main active">
            <button class="luck-close" data-id="<?php echo (isset($vo['w_id']) && ($vo['w_id'] !== '')?$vo['w_id']:''); ?>" title="关闭"><i class="iconfont"></i></button>
            <img src="__UPLOAD_DOMAIN__<?php echo $vo['goods_image']; ?>">
            <h6><?php echo $vo['goods_name']; ?></h6>
            <p>期号：<span><?php echo num_base_mask($vo['n_id']); ?></span><br>
                中奖号码：<span><?php echo num_base_mask($vo['luck_num'],1,0); ?></span></p>
            <?php if($vo['reward_type'] == 0): ?>
              <a href="<?php echo U('ucenter/luck_detail',['id'=>$vo['w_id']]); ?>" target="_blank" class="verify_btn">确认收货方式</a>
            <?php else: ?>
            <a href="<?php echo U('ucenter/luck_detail',['id'=>$vo['w_id']]); ?>" target="_blank" class="verify_btn">立即兑换</a>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; endif; else: echo "" ;endif; ?>
    <script>
        // DUANG恭喜你中奖了
        $(".luck").show().find(".luck-main").addClass("active");
        $(document).on("click",".luck-close,.verify_btn",function(){
            var obj  =$(this);
            var url = $('#flag_trigger').val();
            common.ajax_post(url,{'id':obj.data('id')},true,function(rt){});
            $(this).parents(".luck").hide();
        });
    </script>
<?php endif; ?>
<!--全局url-->
<input type="hidden" id="login_out" value="<?php echo U('User/login_out'); ?>"><!--退出登录-->
<input type="hidden" id="get_user_login_info" value="<?php echo U('User/get_user_login_info'); ?>"><!--用户登录状态-->
<input type="hidden" id="show_login" value="<?php echo U('User/show_login'); ?>"><!--显示登录界面-->
<input type="hidden" id="cart_page_url" value="<?php echo U('Pay/cart'); ?>"><!--购物车页面-->
<input type="hidden" id="cart_list_div_url" value="<?php echo U('core/pay/cart_list_div'); ?>"><!--购物车ajax载入时候的页面-->
<input type="hidden" id="del_cart_by_nper_id_url" value="<?php echo U('core/pay/del_cart_by_nper_id'); ?>"><!--购物车ajax载入时候的页面-->
<input type="hidden" id="del_cart_by_ids_url" value="<?php echo U('core/pay/del_cart_by_ids'); ?>"><!--根据id删除购物车内容-->
<input type="hidden" id="update_cart_num_url" value="<?php echo U('core/pay/update_cart_num'); ?>"><!--更新购物车数量-->
<input type="hidden" id="create_order_url" value="<?php echo U('core/pay/create_order'); ?>"><!--生成订单-->

<!--登录相关-->
<input type="hidden" id="gee_test_url" value="<?php echo U('core/api/gee_test'); ?>"><!--极验证-->
<input type="hidden" id="user_login_do_url" value="<?php echo U('User/user_login_do'); ?>"><!--ajax登录-->
<input type="hidden" id="check_need_verify_url" value="<?php echo U('User/check_need_verify'); ?>"><!--需要验证码检测-->
<!--开奖相关-->
<input type="hidden" id="trigger_open_url" value="<?php echo U('core/Gdfc/trigger_open'); ?>"><!--全局开奖定时触发任务-->
<input type="hidden" id="collect_url" value="<?php echo U('core/Collect/index'); ?>"><!--彩票开奖定时触发任务-->
<input type="hidden" id="no_img_url" value="__yyg__/images/empty_img.jpg"><!--图片不存在时候显示的图片-->

<!--获取总参与人数-->
<input id="total_join_num" type="hidden" value="<?php  echo get_total_join() ?>">



<script type="text/javascript" src="__plugin__/layer/layer.js"></script>
<script type="text/javascript" src="__common__/js/common.js"></script>
<script type="text/javascript" src="__yyg__/js/public.js"></script>
<script type="text/javascript" src="__common__/js/geetest.js"></script>
<script type="text/javascript" src="__plugin__/bigautocomplete/jquery.bigautocomplete.js"></script>

<?php if($info["status"] == "1" AND $info["pay_status"] == "1"): ?>
<script type="text/javascript" src="__yyg__/js/pay/charge.js"></script>
<?php endif; ?>

</body>

<div style="display: none;">

<!--WEBSITE_TONGJI_BD-->

<?php echo $site_config['website_tongji_bd']; ?>
<!--WEBSITE_TONGJI_CNZZ-->
<?php echo $site_config['website_tongji_cnzz']; ?>
</div>
</html>