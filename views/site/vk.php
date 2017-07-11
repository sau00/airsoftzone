<?php
$this->title = 'Поиск по барахолкам Вконтакте';
?>

<div class="container">

    <h1><?= $this->title; ?></h1>

    <hr/>

    <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-9">

            <form action="" method="get">
                <div class="row">
                    <div class="col-md-3">
                        <select class="form-control" id="select" name="cat">
                            <?php

                            $categories = [
                                'a' => 'Все категории',
                                'w' => 'Приводы',
                                'g' => 'Аксессуары и Запчасти',
                                'e' => 'Экипировка и Снаряжение'
                            ];

                            ?>

                            <?php foreach ($categories as $key => $category): ?>
                                <option value="<?=$key;?>"<?php if ($key == Yii::$app->request->get('cat')): ?> selected<?php endif; ?>><?=$category;?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <input type="text" name="query" class="form-control" placeholder="Введите запрос, например: KJW" value="<?=$query;?>">
                            <input type="hidden" name="r" value="site/vk">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block">Найти</button>
                    </div>
                </div>
            </form>
            <h3>Найдено <?=$amount; ?> объявлений</h3>
            <hr />

            <?php foreach ($items as $item): ?>
                <div class="row">
                    <div class="col-md-4">
                        <a href="<?=\yii\helpers\Url::to(['site/vk-item', 'id' => $item->id]);?>" target="_blank" rel="nofollow">
                            <img class="img-responsive" src="<?= $item->photo; ?>" alt="">
                        </a>
                    </div>
                    <div class="col-md-8">
                        <div class="caption">
                            <h3 style="margin-top: 5px;"><a href="<?=\yii\helpers\Url::to(['site/vk-item', 'id' => $item->id]);?>" target="_blank"><?= $item->url; ?></a></h3>
                            <p class="text-muted"><a
                                        href="https://vk.com/id<?= $item->user_id->vk; ?>"
                                        rel="nofollow" target="_blank"><?= $item->user_id->firstname; ?> <?= $item->user_id->lastname; ?></a>
                                <br />
                                <span class="text-muted">vk.com/id<?= $item->user_id->vk; ?></span>
                            </p>

                            <p class="text-muted"><a
                                        href="https://vk.com/public<?= $item->group_id->group_id; ?>"
                                        target="_blank" rel="nofollow"><?= $item->group_id->name; ?></a>
                            </p>
                            <p class="text-muted">Категория: <?=$categories[$item->category]; ?></p>
                            <p class="text-muted">Добавлено: <?=\yii\helpers\Html::displayDate(date('Y-m-d H:i:s', $item->timestamp + 10800)); ?></p>
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
            <div id="vk_groups" style="margin: 0 auto;"></div>
            <script type="text/javascript">
                VK.Widgets.Group("vk_groups", {mode: 3, width: "auto"}, 145778249);
            </script>
        </div><!--/.sidebar-offcanvas-->
    </div><!--/row-->
</div>