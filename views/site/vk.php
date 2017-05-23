<?php
$this->title = 'Агрегатор объявлений групп Вконтакте';
?>

<div class="container">

    <h1><?= $this->title; ?></h1>

    <hr/>

    <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-9">

            <form action="/index.php?r=site/vk" method="get">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <input type="text" name="query" class="form-control" placeholder="Введите запрос, например: KJW" value="<?=$query;?>">
                            <input type="hidden" name="r" value="site/vk">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-default">Искать объявления</button>
                    </div>
                </div>
            </form>
            <hr />

            <p class="pull-right visible-xs">
                <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
            </p>

            <?php if(!$items): ?>
                <h2>По вашему запросу ничего не найдено</h2>
            <?php endif; ?>

            <?php foreach ($items as $item): ?>
                <div class="row">
                    <div class="col-md-4">
                        <a href="#">
                            <img class="img-responsive" src="<?= $item->photo; ?>" alt="">
                        </a>
                    </div>
                    <div class="col-md-8">
                        <div class="caption">
                            <h2 style="margin-top: 5px;"><a href="https://vk.com/<?= $item->url; ?>"
                                                            target="_blank"><?= $item->url; ?></a></h2>
                            <p class="text-muted"><a
                                        href="https://vk.com/id<?= $item->author_id; ?>"
                                        target="_blank">vk.com/id<?= $item->author_id; ?></a>
                            </p>
                            <p class="text-muted"><a href="https://vk.com/public<?= $item->group_id; ?>"
                                                     target="_blank">
                                    <?php
                                    $groups = [
                                        '76629546' => 'СТРАЙКБОЛЬНАЯ БАРАХОЛКА | страйкбол',
                                        '13212026' => 'Единая Страйкбольная Группа Страйкбол',
                                        '45753674' => 'Страйкбол базар AIRSOFT4YOU'
                                    ];

                                    echo $groups[$item->group_id];
                                    ?>
                                </a></p>
                        </div>
                    </div>
                </div>

                <hr/>
            <?php endforeach; ?>
            <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination]); ?>
        </div><!--/.col-xs-12.col-sm-9-->

        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
            <script type="text/javascript" src="//vk.com/js/api/openapi.js?144"></script>

            <!-- VK Widget -->
            <div id="vk_groups"></div>
            <script type="text/javascript">
                VK.Widgets.Group("vk_groups", {mode: 3}, 145778249);
            </script>
        </div><!--/.sidebar-offcanvas-->
    </div><!--/row-->
</div>