<?php
$ctaHeadingWord = Yii::t('common', 'Why') . ' ' . Yii::app()->controller->siteName;
$ctaParagraphUrl = tt('useSiteUrl', 'configuration');
$ctaParagraphWord = Yii::t('common', 'Click here for answer')
?>
<div class="cta-overlay">
    <h1><?= $ctaHeadingWord ?></h1>
    <p><a href="<?= $ctaParagraphUrl ?>"><?= $ctaParagraphWord ?></a></p>
</div>
