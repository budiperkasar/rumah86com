<!DOCTYPE html>
<?php
$isRTL = Lang::isRTLLang(Yii::app()->language);
$cs = Yii::app()->clientScript;
?>
<html lang="<?php echo Yii::app()->language; ?>">
<head>
    <title><?php echo CHtml::encode($this->seoTitle ? $this->seoTitle : $this->pageTitle); ?></title>
    <meta name="description"
          content="<?php echo CHtml::encode($this->seoDescription ? $this->seoDescription : $this->pageDescription); ?>"/>
    <meta name="keywords"
          content="<?php echo CHtml::encode($this->seoKeywords ? $this->seoKeywords : $this->pageKeywords); ?>"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="icon" href="<?php echo Yii::app()->request->getBaseUrl(true); ?>/favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="<?php echo Yii::app()->request->getBaseUrl(true); ?>/favicon.ico"
          type="image/x-icon"/>

    <?php
    HSite::registerMainAssets();

    if (Yii::app()->user->checkAccess('backend_access')) {
        ?>
        <link rel="stylesheet" type="text/css"
              href="<?php echo Yii::app()->theme->baseUrl; ?>/css/tooltip/tipTip.css" /><?php
    }
    ?>

    <link rel="stylesheet" type="text/css" href="<?= Yii::app()->theme->baseUrl ?>/css/all.css">
    <link rel="stylesheet" type="text/css" href="<?= Yii::app()->theme->baseUrl ?>/css/global.min.css" />

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">


    <!--[if lt IE 9]>
    <script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/ie.css">
    <![endif]-->
</head>

<body class="<?php echo ($this->htmlPageId == 'index') ? 'b_mainpage' : $this->htmlPageId; ?> <?php echo ($isRTL) ? 'rtl' : ''; ?>">

<?php if (demo()) : ?>
    <style>
        #page {
            padding-top: 40px;
        }

        @media screen and (max-width: 960px) {
            #page {
                padding-top: 0px;
            }
        }
    </style>
    <?php $this->renderPartial('//site/ads-block', array()); ?>
    <div class="clear"></div>
<?php endif; ?>

<?php if (isDev()) { (new HDev())->run(); } ?>

<noscript>
    <div class="noscript"><?php echo Yii::t('common', 'Allow javascript in your browser for comfortable use site.'); ?></div>
</noscript>

<div id="page">

    <?php
    $bgUrl = Themes::getBgUrl();
    if ($bgUrl) {
        ?>
        <div id="bg">
            <img src="<?php echo $bgUrl; ?>" alt="">
        </div>
    <?php } ?>

    <div class="line_header b_black c_grey">
        <div class="main_header">
            <div class="row">
                <div class="col-md-4">
                    <nav class="switch-menu left">
                        <span><span class="image-menu"></span><?php echo tc('Menu'); ?></span>
                        <ul class="line_menu">
                            <li class="depth_zero"><?= $this->welcomeSite ?></li>
                            <?php
                            $menuItems = $this->aData['leftTopBarMenuItems'];
                            foreach ($menuItems as $menuItem)
                            {
                                ?>
                                <li class="depth_zero">
                                    <a href="<?= $menuItem['url'] ?>"><?= $menuItem['label'] ?></a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </nav>
                </div>

                <div class="col-md-8">
                    <ul class="line_menu right">
                        <?php
                        $menuItems = $this->aData['rightTopBarMenuItems'];

                        foreach ($menuItems as $menuItem)
                        {
                            ?>
                            <li class="depth_zero">
                                <a href="<?= $menuItem['url'] ?>"><?= CHtml::encode($menuItem['label']) ?></a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>

            </div>



            <?php if (!isFree()): ?>
                <div class="right">
                    <?php
                    $languages = Lang::getActiveLangs(true);
                    $countActiveLangs = count($languages);
                    $typeShowLangs = 'dropdown';
                    ?>
                    <?php if ($countActiveLangs > 1): ?>
                        <?php
                        $typeShowLangs = 'li';
                        if ($countActiveLangs > 5)
                            $typeShowLangs = 'dropdown';
                        ?>
                        <?php if ($typeShowLangs == 'li'): ?>
                            <ul class="languages">
                        <?php endif; ?>
                        <?php $this->widget('application.modules.lang.components.langSelectorWidget', array('type' => $typeShowLangs, 'languages' => $languages)); ?>
                        <?php if ($typeShowLangs == 'li'): ?>
                            </ul>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if (count(Currency::getActiveCurrency()) > 1) : ?>
                        <div class="dotted_currency"></div>
                        <div class="new_select <?php echo ($typeShowLangs == 'dropdown') ? 'new_select_right' : ''; ?>">
                            <?php $this->widget('application.modules.currency.components.currencySelectorWidget'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="body_background"></div>

    <div main-content-wrapper>
        <!-- header -->
        <div class="body_background"></div>
        <div class="header">

            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <div class="logo">
                            <a title="<?php echo Yii::t('common', 'Go to main page'); ?>"
                               href="<?php echo Yii::app()->controller->createAbsoluteUrl('/'); ?>">
                                <div class="logo-img">
                                    <img alt="" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/pages/logo-site.png"/>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <span class="listing listing-add">
                            <a class="c_white" href="<?= $this->aData['siteSettings']['addListUrl'] ?>">
                              <i class="fas fa-plus font-38"></i>
                            <br>
                                <?= $this->aData['siteProperties']['addWorkerLabel']?>
                            </a>
                        </span>
                        <span class="listing listing-count">
                            <span class="no"><?= $this->aData['siteProperties']['totalListing'] ?></span>
                            <?= $this->aData['siteProperties']['listingLabel'] ?>
                        </span>
                    </div>
                </div>
            </div>


        </div>

        <div class="menu b_green">
            <div id="mobnav-btn"><span class="image-menu"></span><?php echo tc('Menu'); ?></div>
            <?php
            $this->widget('ResponsiveMainCMenu', array(
                'id' => 'sf-menu-id',
                'items' => $this->aData['topMenuItems'],
                'htmlOptions' => array('class' => 'sf-menu header_menu'),
                'encodeLabel' => false,
                'activateParents' => true,
            ));
            ?>
        </div>

        <?php echo $content; ?>

        <?php if (issetModule('advertising')) : ?>
            <?php $this->renderPartial('//modules/advertising/views/advert-bottom', array()); ?>
        <?php endif; ?>

        <div class="page-buffer">&nbsp;</div>

        <div id="footer">
            <div id="footer-links">
                <div class="wrapper">
                    <div class="footer_links_block">
                        <a class="footer_add_ad" rel="nofollow"
                           href="<?php echo Yii::app()->createUrl('guestad/main/create'); ?>"
                           target="_blank"><?php echo tc('List your property'); ?></a>

                        <div class="footer_request_block">
                            <a class="link" rel="nofollow"
                               href="<?php echo Yii::app()->createUrl('booking/main/mainform'); ?>"><?php echo tc('Reserve apartment'); ?></a>
                        </div>

                        <div class="footer_social_block">
                            <?php
                            if (param('useYandexShare', 0))
                                $this->widget('application.extensions.YandexShareApi', array(
                                    'services' => param('yaShareServices', 'yazakladki,moikrug,linkedin,vkontakte,facebook,twitter,odnoklassniki')
                                ));
                            if (param('useInternalShare', 1))
                                $this->widget('ext.sharebox.EShareBox', array(
                                    'url' => Yii::app()->getRequest()->getHostInfo() . Yii::app()->request->url,
                                    'title' => CHtml::encode($this->seoTitle ? $this->seoTitle : $this->pageTitle),
                                    'iconSize' => 24,
                                    'include' => explode(',', param('intenalServices', 'vk,facebook,twitter,google-plus,stumbleupon,digg,delicious,linkedin,reddit,technorati,entriesvine')),
                                ));
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div id="footer-two-links">
                <div class="wrapper">
                    <div class="copyright">&copy;&nbsp;<?php echo CHtml::encode(Yii::app()->name) . ', ' . date('Y'); ?>
                        <br/>
                        <?php if (param('adminPhone') || param('adminEmail')) : ?>
                            <div class="tel">
                                <?php if (param('adminPhone')): ?>
                                    <span><?php echo param('adminPhone'); ?></span>
                                <?php endif; ?>
                                <?php if (param('adminEmail')): ?>
                                    <?php if (param('adminPhone')): ?><br/><?php endif; ?>
                                    <div class="mail">
                                        <?php if (IdnaConvert::check(param('adminEmail'))): ?>
                                            <?php echo IdnaConvert::checkDecode(param('adminEmail')); ?>
                                        <?php else: ?>
                                            <?php echo $this->protectEmail(param('adminEmail')); ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php echo getGA(); ?>
            <?php echo getJivo(); ?>
        </div>

        <div id="loading" style="display:none;"><?php echo Yii::t('common', 'Loading content...'); ?></div>
        <div id="loading-blocks" style="display:none;"></div>
        <div id="overlay-content" style="display:none;"></div>
        <div id="toTop">^ <?php echo tc('Go up'); ?></div>
        <?php
        $cs->registerScript('main-vars', '
		var BASE_URL = ' . CJavaScript::encode(Yii::app()->baseUrl) . ';
		var CHANGE_SEARCH_URL = ' . CJavaScript::encode(Yii::app()->createUrl('/quicksearch/main/mainsearch/countAjax/1')) . ';
		var INDICATOR = "' . Yii::app()->theme->baseUrl . "/images/pages/indicator.gif" . '";
		var LOADING_NAME = "' . tc('Loading ...') . '";
		var params = {
			change_search_ajax: ' . param("change_search_ajax", 1) . '
		}
	', CClientScript::POS_BEGIN, array(), true);

        $this->renderPartial('//layouts/_common');

        $this->widget('application.modules.fancybox.EFancyBox', array(
                'target' => 'a.fancy',
                'config' => array(
                    'ajax' => array('data' => "isFancy=true"),
                    'titlePosition' => 'inside',
                    'onClosed' => 'js:function(){
						var capClick = $(".get-new-ver-code");
						if(typeof capClick !== "undefined")	{ 
							capClick.click(); 
						}
					}'
                ),
            )
        );

        /*$this->widget('ext.magnific-popup.EMagnificPopup', array(
            'target'=>'a.fancy',
            'type' => 'image',
            'options' => array(
                'closeOnContentClick' => true,
                'mainClass' => 'mfp-img-mobile',
                'callbacks' => array(
                    'close' => 'js:function(){
                        var capClick = $(".get-new-ver-code");
                        if(typeof capClick !== "undefined")	capClick.click();
                    }
                    ',
                ),
            ),
        ));

        $this->widget('ext.magnific-popup.EMagnificPopup', array(
                'target'=>'.mgp-open-inline',
                'type' => 'inline',
                'options' => array(
                    'preloader' => false,
                    'focus' => '#name',
                    'callbacks' => array(
                        'beforeOpen' => 'js:function() {
                            if($(window).width() < 700) {
                              this.st.focus = false;
                            } else {
                              this.st.focus = "#name";
                            }
                          }
                        ',
                        'close' => 'js:function(){
                            var capClick = $(".get-new-ver-code");
                            if(typeof capClick !== "undefined")	capClick.click();
                        }
                        ',
                    ),
                ),
            )
        );

        $this->widget('ext.magnific-popup.EMagnificPopup', array(
                'target'=>'.mgp-open-ajax',
                'type' => 'ajax',
                'options' => array(
                    'preloader' => false,
                    'focus' => '#name',
                    'callbacks' => array(
                        'beforeOpen' => 'js:function() {
                            if($(window).width() < 700) {
                              this.st.focus = false;
                            } else {
                              this.st.focus = "#name";
                            }
                          }
                        ',
                        'close' => 'js:function(){
                            var capClick = $(".get-new-ver-code");
                            if(typeof capClick !== "undefined")	capClick.click();
                        }
                        ',
                    ),
                ),
            )
        );*/


        if (Yii::app()->user->checkAccess('apartments_admin')) {
            $cs->registerScriptFile(Yii::app()->theme->baseUrl . '/js/tooltip/jquery.tipTip.js', CClientScript::POS_END);
            $cs->registerScript('adminMenuToolTip', '
			$(function(){
				$(".adminMainNavItem").tipTip({maxWidth: "auto", edgeOffset: 10, delay: 200});
			});
		', CClientScript::POS_READY);
            ?>

<!--            <div class="admin-menu-small --><?php //echo demo() ? 'admin-menu-small-demo' : ''; ?><!-- ">-->
<!--                <a href="--><?php //echo (Yii::app()->user->checkAccess('stats_admin') === true) ? Yii::app()->baseUrl . '/stats/backend/main/admin' : Yii::app()->baseUrl . '/apartments/backend/main/admin' ?><!--">-->
<!--                    <img src="--><?php //echo Yii::app()->theme->baseUrl; ?><!--/images/adminmenu/administrator.png"-->
<!--                         alt="--><?php //echo Yii::t('common', 'Administration'); ?><!--"-->
<!--                         title="--><?php //echo Yii::t('common', 'Administration'); ?><!--" class="adminMainNavItem"/>-->
<!--                </a>-->
<!--            </div>-->
        <?php } ?>

        <?php
        if (param('useShowInfoUseCookie') && isset(Yii::app()->controller->privatePolicyPage) && !empty(Yii::app()->controller->privatePolicyPage)) {
            $privatePolicyPage = Yii::app()->controller->privatePolicyPage;

            $message = CJavaScript::encode(CHtml::encode(Yii::app()->name) . ' ' . CHtml::encode(tc('uses cookie')) . ', <a href="' . $privatePolicyPage->getUrl() . '" target="_blank">' . $privatePolicyPage->getStrByLang('title') . '</a>');

            $cs->registerScript('display-info-use-cookie-policy', "
					$.cookieBar({/*acceptOnContinue:false, */ fixed: true, bottom: true, message: $message, acceptText : 'X'});
				", CClientScript::POS_READY);
        }
        ?>
    </div>
</body>
</html>