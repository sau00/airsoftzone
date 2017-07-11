<?php
$this->title = $item->url . ' - AirsoftZone';
?>

<?php

$categories = [
    'a' => 'Все категории',
    'w' => 'Приводы',
    'g' => 'Аксессуары и Запчасти',
    'e' => 'Экипировка и Снаряжение'
];

?>

<div class="container">

    <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-12 col-md-12">
            <p class="pull-right visible-xs">
                <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
            </p>

            <div class="row">
                <div class="col-md-6">
                    <a href="https://vk.com/<?= $item->url; ?>" target="_blank">
                        <img class="img-responsive" src="<?= $item->photo; ?>" alt="">
                    </a>
                </div>
                <div class="col-md-6">
                    <div class="caption">
                        <h3 style="margin-top: 5px;"><noindex><a href="https://vk.com/<?= $item->url; ?>" target="_blank" rel="nofollow"><?= $item->url; ?></a></noindex></h3>
                        <p class="text-muted"><a
                                href="https://vk.com/id<?= $item->user_id->vk; ?>"
                                target="_blank" rel="nofollow"><?= $item->user_id->firstname; ?> <?= $item->user_id->lastname; ?></a>
                            <br />
                            <span class="text-muted">vk.com/id<?= $item->user_id->vk; ?></span>
                        </p>

                        <p class="text-muted">Группа: <br /><a
                                href="https://vk.com/public<?= $item->group_id->group_id; ?>"
                                target="_blank" rel="nofollow"><?= $item->group_id->name; ?></a>
                        </p>
                        <p><span class="text-muted">Категория:</span> <br /> <?=$categories[$item->category]; ?></p>
                        <p><span class="text-muted">Добавлено:</span> <br /> <?=\yii\helpers\Html::displayDate(date('Y-m-d H:i:s', $item->timestamp + 10800)); ?></p>
                        <p><span class="text-muted">Описание:</span> <br /> <?=$item->description_raw; ?></p>

                    </div>
                </div>
            </div>
        </div><!--/.col-xs-12.col-sm-9-->
        <div class="col-md-12">
            <h2>Другие объявления пользователя</h2>
            <hr />
            <?php foreach ($user_items as $item): ?>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="https://vk.com/<?= $item->url; ?>" target="_blank">
                                <img class="img-responsive" src="<?= $item->photo; ?>" alt="">
                            </a>
                        </div>
                        <div class="col-md-8">
                            <div class="caption">
                                <h3 style="margin-top: 5px;"><a href="/index.php?r=site/vk-item&id=<?= $item->id; ?>" target="_blank"><?= $item->url; ?></a></h3>
                                <p class="text-muted"><a
                                            href="https://vk.com/id<?= $item->user_id->vk; ?>"
                                            target="_blank"><?= $item->user_id->firstname; ?> <?= $item->user_id->lastname; ?></a>
                                    <br />
                                    <span class="text-muted">vk.com/id<?= $item->user_id->vk; ?></span>
                                </p>

                                <p class="text-muted"><a
                                            href="https://vk.com/public<?= $item->group_id->group_id; ?>"
                                            target="_blank"><?= $item->group_id->name; ?></a>
                                </p>
                                <p class="text-muted">Категория: <?=$categories[$item->category]; ?></p>
                                <p class="text-muted">Добавлено: <?=\yii\helpers\Html::displayDate(date('Y-m-d H:i:s', $item->timestamp + 10800)); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div><!--/row-->
</div><!--/.container-->