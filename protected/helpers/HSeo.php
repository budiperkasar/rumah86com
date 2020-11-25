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

class HSeo
{
    public static function getCityUrlById($cityId, $params = array())
    {
        return SeoTrash::getInstance()->getCityUrlById($cityId, $params);
    }

    public static function getCityObjTypeLinkById($cityId, $objTypeId, $params = array())
    {
        return SeoTrash::getInstance()->getCityObjTypeLinkById($cityId, $objTypeId, $params);
    }
}

class SeoTrash
{

    private static $_instance;

    private $citiesListResult = array();
    private $objTypesListResult = array();
    private $countApartmentsByCategories = array();

    private $params = array();

    public function __construct()
    {
        $resCounts = array();
        if (issetModule('seo')) {
            $this->citiesListResult = SeoFriendlyUrl::getActiveCityRoute($this->params);
            $this->objTypesListResult = SeoFriendlyUrl::getActiveObjTypesRoute($this->params, true, true);
            $resCounts = SeoFriendlyUrl::getCountApartmentsForCategories($this->params);
        }

        if (!empty($resCounts)) {
            foreach ($resCounts as $values) {
                $this->countApartmentsByCategories[$values['city']][$values['obj_type_id']] = $values['count'];
            }
        }
        unset($resCounts);
    }

    /**
     * @return SeoTrash
     */
    public static function getInstance()
    {
        if (empty(self::$_instance)) {
            self::$_instance = new SeoTrash();
        }

        return self::$_instance;
    }

    public function getCityUrlById($cityId, $params = array())
    {
        $cityValue = isset($this->citiesListResult[$cityId]) ? $this->citiesListResult[$cityId] : null;

        if (!$cityValue) {
            return Yii::app()->createUrl('/search', array('city[]' => intval($cityId)));
        }

        $paramsType = $paramsObjType = null;
        if (isset($params)) {
            $paramsType = (isset($params['type'])) ? $params['type'] : null;
        }

        $linkParams = array(
            'cityUrlName' => $cityValue[Yii::app()->language]['url'],
        );

        if (!empty($paramsType)) {
            $linkParams['apType'] = $paramsType;
        }

        return Yii::app()->controller->createUrl('/seo/main/viewsummaryinfo', $linkParams);
    }

    public function getCityObjTypeUrlById($cityId, $objTypeId, $params = array())
    {
        $cityValue = isset($this->citiesListResult[$cityId]) ? $this->citiesListResult[$cityId] : null;
        $objValue = isset($this->objTypesListResult[$objTypeId]) ? $this->objTypesListResult[$objTypeId] : null;

        if (!$cityValue || !$objValue) {
            return Yii::app()->createUrl('/search', array('city[]' => intval($cityId), 'objType' => intval($objTypeId)));
        }

        $paramsType = $paramsObjType = null;
        if (isset($params)) {
            $paramsType = (isset($params['type'])) ? $params['type'] : null;
        }

        $linkParams = array(
            'cityUrlName' => $cityValue[Yii::app()->language]['url'],
        );

        if (!empty($paramsType)) {
            $linkParams['apType'] = $paramsType;
        }


        $linkParams = array(
            'cityUrlName' => $cityValue[Yii::app()->language]['url'],
            'objTypeUrlName' => $objValue[Yii::app()->language]['url'],
        );


        return Yii::app()->controller->createUrl('/seo/main/viewsummaryinfo', $linkParams);
    }

    public function getCityObjTypeLinkById($cityId, $objTypeId, $params = array())
    {
        $cityValue = isset($this->citiesListResult[$cityId]) ? $this->citiesListResult[$cityId] : null;
        $objValue = isset($this->objTypesListResult[$objTypeId]) ? $this->objTypesListResult[$objTypeId] : null;

        if (!$cityValue || !$objValue) {
            return null;
        }

        $linkName = $objValue[Yii::app()->language]['name'];
        $addCount = '';
        $class = 'inactive-obj-type-url';
        if (isset($this->countApartmentsByCategories[$cityId]) && isset($this->countApartmentsByCategories[$cityId][$objTypeId])) {
            $class = 'active-obj-type-url';
            $addCount = '<span class="obj-type-count">(' . $this->countApartmentsByCategories[$cityId][$objTypeId] . ')</span>';
        }

        return CHtml::link(
            $linkName . ' ' . $addCount, $this->getCityObjTypeUrlById($cityId, $objTypeId, $params), array('class' => $class)
        );
    }
}