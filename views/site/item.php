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
                    <a href="#">
                        <img class="img-responsive" src="/uploads/items/<?=$item->id;?>/<?php $images = unserialize($item->images); echo $images[0];?>" alt="">
                    </a>

                    <hr />

                    <p>
                        <?=$item->description;?>
                    </p>
                </div>
                <div class="col-md-4">
                    <div class="caption">
                        <p>
                            <a href="https://vk.com/<?=$item->user_id->vk;?>" target="_blank" class="btn btn-block btn-info btn-lg">vk.com/<?=$item->user_id->vk;?></a>
                        </p>

                        <p><span class="text-muted">Город</span> <br /> <?=$item->city_id->name;?></p>
                        <p><span class="text-muted">Пересыл</span> <br /> <?php if($item->shipping == 1) echo 'Есть'; else echo 'Нет'?></p>
                        <p><span class="text-muted">Добавлено</span> <br /> <?=\yii\helpers\Html::displayDate($item->time);?></p>
                    </div>
                </div>
            </div>

        </div><!--/.col-xs-12.col-sm-9-->
    </div><!--/row-->
</div><!--/.container-->