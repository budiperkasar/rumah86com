<?php
$this->pageTitle .= ' - ' . tt("FAQ") . ' - ' . $model['page_title'];
$this->breadcrumbs = array(
    tt("FAQ") => array('index'),
    truncateText(CHtml::encode($model->getStrByLang('page_title')), 10),
);
?>
    <div>

        <div class="title highlight-left-right">
            <div>
                <h1><?php echo tt("FAQ"); ?></h1>
            </div>
        </div>
        <div class="clear"></div>
        <br/>

        <?php
        if ($articles) {
            echo '<ul class="article-other-ul">';
            foreach ($articles as $article) {
                echo '<li>' . CHtml::link($article['page_title'], $article->getUrl(), array('class' => 'a-title')) . '</li>';
            }
            echo '</ul>';
        }
        ?>

        <?php if (!empty($model)): ?>
            <h2><?php echo $model['page_title']; ?></h2>
            <div><?php echo $model['page_body']; ?></div>
        <?php endif; ?>
    </div>

<?php
if (param('enableCommentsForFaq', 1)) {
    $this->widget('application.modules.comments.components.commentListWidget', array(
        'model' => $model,
        'url' => $model->getUrl(),
        'showRating' => false,
    ));
}
?>

<?php if (param('useSchemaOrgMarkup')) {
    $dateCreated = new DateTime($model->date_updated);
    $hostname = IdnaConvert::checkDecode(Yii::app()->getRequest()->getHostInfo());

    $jsonLD = array();
    $jsonLD['@context'] = 'http://schema.org';
    $jsonLD['@type'] = 'Article';
    $jsonLD['mainEntityOfPage'] = array(
        '@type' => 'WebPage',
        '@id' => $model->getUrl(),
    );
    $jsonLD['headline'] = CHtml::encode($model['page_title']);
    $jsonLD['datePublished'] = $dateCreated->format('c');
    $jsonLD['author'] = array(
        '@type' => 'Person',
        'name' => CHtml::encode(User::getAdminName())
    );
    $jsonLD['publisher'] = array(
        '@type' => 'Organization',
        'name' => CHtml::encode(Yii::app()->name),
        'logo' => array(
            '@type' => 'ImageObject',
            'url' => $hostname . Yii::app()->theme->baseUrl . '/images/pages/logo-open-ore.png',
            'width' => 276,
            'height' => 60
        )
    );
    $jsonLD['description'] = strip_tags($model['page_body']);
    echo '<script type="application/ld+json">' . CJavaScript::jsonEncode($jsonLD) . '</script>';
}