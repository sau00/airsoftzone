<?php
    $this->title = 'Доска страйкбольных объявлений AirsoftZone';
?>

<div class="container">

    <h1><?=$this->title;?></h1>

    <hr />

    <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-9">
            <p class="pull-right visible-xs">
                <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
            </p>

            <?php foreach ($items as $item): ?>
                <div class="row">
                    <div class="col-md-4">
                        <a href="#">
                            <img class="img-responsive" src="/uploads/items/<?=$item->id;?>/<?php $images = unserialize($item->images); echo $images[0];?>" alt="">
                        </a>
                    </div>
                    <div class="col-md-8">
                        <div class="caption">
                            <h2 style="margin-top: 5px;"><a href="/index.php?r=site/item&id=<?=$item->id;?>"><?=$item->title;?></a></h2>
                            <h4><?=$item->price;?> руб.</h4>
                            <p class="text-muted"><?=$item->category_id->name;?></p>
                            <p class="text-muted">г. <?=$item->city_id->name;?></p>
                            <p class="text-muted"><?=\yii\helpers\Html::displayDate($item->time);?></p>
                        </div>
                    </div>
                </div>

                <hr />
            <?php endforeach; ?>
            <?=\yii\widgets\LinkPager::widget(['pagination' => $pagination]);?>
        </div><!--/.col-xs-12.col-sm-9-->

        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
            <script type="text/javascript" src="//vk.com/js/api/openapi.js?144"></script>

            <!-- VK Widget -->
            <div id="vk_groups" style="margin: 0 auto;"></div>
            <script type="text/javascript">
                VK.Widgets.Group("vk_groups", {mode: 3}, 145778249);
            </script>
        </div><!--/.sidebar-offcanvas-->
    </div><!--/row-->
</div>