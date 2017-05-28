<?php
$this->title = $item->title . ' купить ' . $item->city_id->name;
?>


<div class="container">

    <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
            <p class="pull-right visible-xs">
                <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
            </p>

            <div class="row">
                <div class="col-md-12">
                    <h2 class="pull-right"><?=$item->price;?> руб.</h2>
                    <h1><?=$item->title;?></h1>
                    <hr />
                </div>
                <div class="col-md-8">
                    <div id="main_area">
                        <!-- Slider -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-xs-12" id="slider">
                                    <!-- Top part of the slider -->
                                    <div class="row">
                                        <div class="col-md-12" id="carousel-bounding-box">
                                            <div class="carousel slide" id="myCarousel">
                                                <!-- Carousel items -->
                                                <div class="carousel-inner">
                                                    <?php $images = unserialize($item->images);?>
                                                    <?php foreach($images as $key => $image): ?>
                                                        <div class="<?php if($key == 0) echo 'active ';?>item" data-slide-number="<?=$key;?>">
                                                            <img src="/uploads/items/<?=$item->id;?>/<?=$image; ?>" class="img-responsive">
                                                        </div>
                                                    <?php endforeach; ?>

                                                </div>
                                                <!-- Carousel nav -->
                                                <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                                </a>
                                                <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12" id="slider-thumbs">
                                <!-- Bottom switcher of slider -->
                                <ul class="hide-bullets">
                                    <?php foreach($images as $key => $image): ?>
                                        <li class="col-md-1" style="padding: 1px;">
                                            <a class="thumbnail" id="carousel-selector-<?=$key;?>"><img src="/uploads/items/<?=$item->id;?>/<?=$image; ?>"></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <!--/Slider-->
                        </div>

                    </div>
                    <hr />

                    <p>
                        <?=$item->description;?>
                    </p>
                </div>
                <div class="col-md-4">
                    <div class="caption">
                        <p>
                            <a href="https://vk.com/id<?=$item->user_id->vk;?>" target="_blank" class="btn btn-block btn-info">vk.com/id<?=$item->user_id->vk;?></a>
                        </p>

                        <p><span class="text-muted">Контактное лицо</span> <br /> <?=$item->user_id->firstname;?> <?=$item->user_id->lastname;?></p>
                        <p><span class="text-muted">Город</span> <br /> <?=$item->city_id->name;?></p>
                        <p><span class="text-muted">Пересыл</span> <br /> <?php if($item->shipping == 1) echo 'Есть'; else echo 'Нет'?></p>
                        <p><span class="text-muted">Добавлено</span> <br /> <?=\yii\helpers\Html::displayDate($item->time);?></p>
                    </div>
                </div>
            </div>

        </div><!--/.col-xs-12.col-sm-9-->
    </div><!--/row-->
</div><!--/.container-->