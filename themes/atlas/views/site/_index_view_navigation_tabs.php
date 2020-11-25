<?php
$widgetData = $widgetSummaryData = array('widgetTitles' => $widgetTitles);
$navTabsCriteria = [
        '_filter' => [
                'obj_type_id' => 1
        ]
];

$newWorkerCriteria = ['_filter' => ['obj_type_id' => 1]];
$availableSoonCriteria = ['_filter' => ['obj_type_id' => 2]];
$availableCriteria = ['_filter' => ['obj_type_id' => 5]];
$infalPackageCriteria = ['_filter' => ['obj_type_id' => 6]];
?>

<nav>
    <div class="nav nav-tabs" id="nav-tab">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab">PENDATANG BARU</a>
        <a class="nav-item nav-link c-green-light" id="nav-profil-tab" data-toggle="tab" href="#nav-profil" role="tab">SEGERA TERSEDIA</a>
        <a class="nav-item nav-link c-green-light" id="nav-kontak-tab" data-toggle="tab" href="#nav-kontak" role="tab">SUDAH TERSEDIA</a>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel">
        <div class="container padding-tb10-rl20 max-width-100">
            <?php
            $criteria = $page->getCriteriaForNav($newWorkerCriteria);
            $criteria = HGeo::setForIndexCriteria($criteria);

            $widgetData = CMap::mergeArray($widgetData, array('criteria' => $criteria));

            $this->widget('ApartmentsNavWidget', $widgetData);

            ?>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-profil" role="tabpanel">
        <div class="container padding-tb10-rl20 max-width-100">
            <?php

            $widgetData = CMap::mergeArray($widgetData, array('criteria' => $page->getCriteriaForNav($availableSoonCriteria)));
            $this->widget('ApartmentsNavWidget', $widgetData);

            ?>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-kontak" role="tabpanel">
        <div class="container padding-tb10-rl20 max-width-100">
            <?php

            $widgetData = CMap::mergeArray($widgetData, array('criteria' => $page->getCriteriaForNav($availableCriteria)));
            $this->widget('ApartmentsNavWidget', $widgetData);

            ?>
        </div>
    </div>
</div>
