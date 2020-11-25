<?php
/* * ********************************************************************************************
 * 								Open Real Estate
 * 								----------------
 * 	version				:	V1.33.0
 * 	copyright			:	(c) 2016 Monoray
 * 							http://monoray.net
 * 							http://monoray.ru
 *
 * 	website				:	http://open-real-estate.info/en
 *
 * 	contact us			:	http://open-real-estate.info/en/contact-us
 *
 * 	license:			:	http://open-real-estate.info/en/license
 * 							http://open-real-estate.info/ru/license
 *
 * This file is part of Open Real Estate
 *
 * ********************************************************************************************* */

class HMenu
{

    public static function setMenuData()
    {
        $controller = Yii::app()->controller;

        if (Yii::app()->getModule('menumanager')) {
            if (!(Yii::app()->controller->module && Yii::app()->controller->module->id == 'install')) {
                $controller->infoPages = Menu::getMenuItems(true, 2);
            }
        }

        $subItems = array();

        if (!Yii::app()->user->isGuest) {
            $subItems = HUser::getMenu();
        } else {
            $subItems[] = array(
                'label' => tc('Login'),
                'url' => Yii::app()->createUrl('/site/login'),
                //'active' => Yii::app()->controller->menuIsActive('my_balance'),
            );
            if (param('useUserRegistration')) {
                $subItems[] = array(
                    'label' => tc("Join now"),
                    'url' => Yii::app()->createUrl('/site/register'),
                );
            }
            $subItems[] = array(
                'label' => tc('Forgot password?'),
                'url' => Yii::app()->createUrl('/site/recover'),
                //'active' => Yii::app()->controller->menuIsActive('my_balance'),
            );
        }

        $controller->aData['userCpanelItems'] = Menu::getMenuItems(true, 1);

        $controller->aData['userCpanelItems'][] = array(
            'label' => tt('Reserve apartment', 'common'),
            'url' => array('/booking/main/mainform'),
            'visible' => Yii::app()->user->checkAccess('backend_access') === false,
            'linkOptions' => array('class' => 'fancy mgp-open-ajax'),
            'itemOptions' => array('class' => 'depth_zero'),
        );

        $controller->aData['userCpanelItems'][] = array(
            'label' => Yii::t('common', 'Control panel'),
            'url' => array('/usercpanel/main/index'),
            'visible' => Yii::app()->user->checkAccess('backend_access') === false,
            'items' => $subItems,
            'itemOptions' => array('class' => 'depth_zero'),
            'submenuOptions' => array(
                'class' => 'sub_menu_dropdown'
            ),
        );

        $helperMenu = new HMenu();
        $isGuest = Yii::app()->user->isGuest;
        $loginUrl = $helperMenu->getUrlTranslatedScopeModule('loginUrl', 'configuration', true);
        $logoutUrl = $helperMenu->getUrlTranslatedScopeModule('logoutUrl', 'configuration', true);
        $registerUrl = $helperMenu->getUrlTranslatedScopeModule('registerUrl', 'configuration', true);
        $siteMapUrl = $helperMenu->getUrlTranslatedScopeModule('siteMapUrl', 'configuration', true);
        $yourOrderUrl = $helperMenu->getUrlTranslatedScopeModule('yourOrderUrl', 'configuration', true);
        $loginWord = $isGuest ? 'Login' : 'Logout';
        $loginUrl = $isGuest ? $loginUrl : $logoutUrl;
        $helperMenu->setControllerData('leftTopBarMenuItems', $loginWord, $loginUrl);

        if (!$isGuest)
        {
            $user = HUser::getModel();

            $controller->aData['userCpanelItems'][] = array(
                'visible' => Yii::app()->user->checkAccess('apartments_admin') === true || Yii::app()->user->checkAccess('stats_admin') === true,
                'label' => Yii::t('common', 'Administration'),
                'url' => (Yii::app()->user->checkAccess('stats_admin')) ? array('/stats/backend/main/admin') : array('/apartments/backend/main/admin'),
                'itemOptions' => array('class' => 'depth_zero'),
            );

            $controller->aData['userCpanelItems'][] = array(
                'label' => '(' . $user->username . ') ' . tt('Logout', 'common'),
                'url' => array('/site/logout'),
                'itemOptions' => array('class' => 'depth_zero'),
            );

            $helperMenu->setControllerData('rightTopBarMenuItems', 'My Account', 'usercpanel');

            $helperMenu->setControllerData('rightTopBarMenuItems', 'My Favorite List', 'usercpanel');

        } else {
            $helperMenu->setControllerData('leftTopBarMenuItems', 'Join Now', $registerUrl);

            $helperMenu->setControllerData('rightTopBarMenuItems', 'Agency Login', $loginUrl);

            $helperMenu->setControllerData('rightTopBarMenuItems', 'Agency Register', $registerUrl);

        }

        $controller->aData['topMenuItems'] = $controller->infoPages;
        
        $helperMenu->setControllerData('rightTopBarMenuItems', 'Order', $yourOrderUrl);

        $helperMenu->setControllerData('rightTopBarMenuItems', 'Site Map', $siteMapUrl);

    }


    protected function createUrl($url)
    {
        if ($url)
        {
            return Yii::app()->createUrl($url);
        }
    }

    protected function setControllerData($objectName, $label, $url)
    {
        $controller = Yii::app()->controller;
        $helperMenu = new HMenu();

        if ($objectName)
        {
            $getLabel = Yii::t('common', $label);
            $separatorSign = '|';
            $controller->aData[$objectName][] = [
//                'label' => $label !== 'Site Map' && $label !== 'Logout' ? $getLabel . ' ' .$separatorSign : $getLabel,
            'label' => $helperMenu->getLabel($label),
                'url' => $helperMenu->createUrl($url)
            ];
        }
    }

    protected function getLabel($word)
    {
        $lastWords = ['Site Map', 'Logout', 'Join Now'];
        $separatorSign = '|';
        $getLabel = Yii::t('common', $word);

        return in_array($word, $lastWords) ? $getLabel : $getLabel . ' ' . $separatorSign;

    }

    protected function getUrlTranslatedScopeModule($word, $moduleName, $convertToUrl = false)
    {
        $helperMenu = new HMenu();
        $data = tt($word,$moduleName);

        if ($convertToUrl === true)
        {
            return $helperMenu->createUrl($data);
        }

        return $data;
    }
}
