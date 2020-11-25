<?php
$addClass = $lastClass = '';

$isLast = ($p % $this->numBlocks) ? false : true;
$lastClass = ($isLast) ? 'right_null' : '';

if (!empty($item->date_up_search) && !is_null($item->date_up_search)) {
    $addClass = 'up_in_search';
}



$description = '';
if ($item->canShowInView('description')) {
    $description = $item->getStrByLang('description');
}

?>


    <div class="col-md-4">
        <div class="card card-blog">
            <div class="card-image">
<!--                <a href="#"> <img class="img" src="http://adamthemes.com/demo/code/cards/images/blog02.jpeg"> </a>-->
                <div class="image_block">

                    <?php if (Yii::app()->user->checkAccess('backend_access') || (param('useUserads') && $item->isOwner())): ?>
                        <div class="apartment_item_edit">
                            <a href="<?php echo $item->getEditUrl(); ?>">
                                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/doc_edit.png"
                                     alt="<?php echo tt('Update apartment', 'apartments'); ?>"
                                     title="<?php echo tt('Update apartment', 'apartments'); ?>">
                            </a>
                        </div>
                    <?php endif; ?>


                    <div class="apartment_type"><?php echo HApartment::getNameByType($item->type); ?></div>
                    <?php
//                        var_dump($item);
                    ?>
                    <?php if ($item->is_special_offer): ?>
                        <div class="like" title="<?php echo tc('Special offer!'); ?>"></div>
                    <?php endif; ?>

                    <?php /*if($item->rating):?>
					<div class="rating">
						<?php
						$this->widget('CStarRating',array(
							'model'=>$item,
							'attribute' => 'rating',
							'readOnly'=>true,
							'id' => 'rating_' . $item->id,
							'name'=>'rating'.$item->id,
							'cssFile' => Yii::app()->theme->baseUrl.'/css/rating/rating.css',
							'minRating' => Comment::MIN_RATING,
							'maxRating' => Comment::MAX_RATING,
						));
						?>
					</div>
				<?php endif;*/ ?>

                    <?php if ($item->rating): ?>
                        <?php $countComments = (isset($item->countComments) && $item->countComments) ? $item->countComments : 0; ?>

                        <div class="rating item-small-block-rating">
                            <div class="item-rating-grade">
                                <?php //echo number_format((float)round($item->rating, 1, PHP_ROUND_HALF_DOWN), 1, '.', '');?>
                                <?php echo $item->rating; ?>
                            </div>
                            <?php if ($countComments): ?>
                                <div class="item-view-all-comments">
                                    <a href="<?php echo $item->getUrl(); ?>">
                                        <?php echo Yii::t('common', '{n} review|{n} reviews', $countComments); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($item->images) && !empty($item->images)): ?>
                        <!--<div class="flexslider flexslider-apartment-image flexslider-loading-image">-->
                        <div class="flexsliders flexslider-apartment-images">
                            <ul class="slides">
                                <?php $im = 1; ?>
                                <?php foreach ($item->images as $image) : ?>
                                    <?php if ($im > 1) {
                                        break;
                                    } ?>
                                    <li>
                                        <?php
                                        $imgTag = CHtml::image(Yii::app()->theme->baseUrl . '/images/ajax-loader-wild.gif', Images::getAlt($image), array(
                                            'class' => 'apartment_type_img',
                                            'title' => Images::getAlt($image),
                                            'alt' => Images::getAlt($image),
                                            'class' => 'lazy-soon',
                                            'data-src' => Images::getThumbUrl($image, 610, 342),
                                        ));
//                                        echo CHtml::link($imgTag, $item->getUrl(), array('title' => Images::getAlt($image)));
                                        ?>
                                        <img src="<?= Images::getThumbUrl($image, 610, 342) ?>">
                                    </li>
                                    <?php $im++; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="custom-navigation">
                            <a href="#" class="flex-prev"><?php Yii::t('bootstrap', 'Previous'); ?></a>
                            <div class="custom-controls-container"></div>
                            <a href="#" class="flex-next"><?php Yii::t('bootstrap', 'Next'); ?></a>
                        </div>
                    <?php else: ?>
                        <?php
                        $res = Images::getMainThumb(610, 342, $item->images);
                        $imgAlt = (isset($res['alt']) && $res['alt']) ? $res['alt'] : CHtml::encode($item->getStrByLang('title'));

                        $img = CHtml::image($res['thumbUrl'], $imgAlt, array(
                            'title' => $item->getStrByLang('title'),
                            'class' => 'apartment_type_img',
                            'alt' => $imgAlt,
                        ));
                        echo CHtml::link($img, $item->getUrl(), array('title' => $item->getStrByLang('title')));
                        ?>
                    <?php endif; ?>
                </div>

                <div class="ripple-cont"></div>
            </div>
            <div class="table">
                <div class="row category">
                    <div class="col-md-6">
                        <h6 class="text-success boldText"><?php echo HApartment::getLocationString($item); ?></h6>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success boldText text-right">
                            <i class="fa fa-money"></i>
                            <?php
                            if ($item->is_price_poa)
                                echo tt('is_price_poa', 'apartments');
                            else
                                echo $item->getPrettyPrice();
                            ?>
                        </h6>
                    </div>

                </div>

                <h4 class="card-caption">
                    <a href="<?= $item->getUrl() ?>">
                        <?php
                        $title = CHtml::encode($item->getStrByLang('title'));
                        if (utf8_strlen($title) >= 30)
                            $title = utf8_substr($title, 0, 30);

//                        echo CHtml::link(HApartment::getTitleForView($item), $item->getUrl(), array('title' => $title));
                          echo $title;
                        ?>
                    </a>
                </h4>
                <p class="card-description">
                    <?php if ($item->canShowInView('description')) { ?>
                <div class="desc">
                    <?php
                    if (utf8_strlen($description) > 110)
                        $description = utf8_substr($description, 0, 110) . '...';

                    echo $description;

                    //echo truncateText($description, 40);
                    ?>
                </div>
                <?php } ?>
                </p>

                <div class="row">
                    <div class="col-md-6 text-left">
                        <div class="author">
                            <a href="#"> <img src="http://adamthemes.com/demo/code/cards/images/avatar3.png" alt="..." class="avatar img-raised"> <span>Mary Dunst</span> </a>
                        </div>

                    </div>
                    <div class="col-md-6 text-right">
                        <a class="btn btn-success" href="<?= $item->getUrl() ?>" role="button">Selengkapnya</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
