<?php
    $this->title = 'Доска страйкбольных объявлений AirsoftZone';
?>

<div class="container">

    <h1><?=$this->title;?></h1>
    <hr />
    <form action="/index.php?r=site/vk" method="get">
        <div class="row">
            <div class="col-md-3">
                <select class="form-control" id="select" name="cat">
                    <option value="">Любая категория</option>
                    <?php foreach ($categories as $key => $category): ?>
                        <?php
                            if($category->id == Yii::$app->request->get('cat'))
                                $selected = 'selected';
                            else
                                $selected = '';

                            if($category->parent_id == null) {
                                echo '<option value="' . $category->id . '" ' . $selected . '><strong>' . $category->name . '</strong></option>';
                            }

                            foreach($categories as $child_key => $child_category) {

                                if($child_category->id == Yii::$app->request->get('cat'))
                                    $selected = 'selected';
                                else
                                    $selected = '';

                                if($child_category->parent_id == $category->id) {
                                    echo '<option value="' . $child_category->id . '" ' . $selected . '>  — ' . $child_category->name . '</option>';
                                }
                            }
                        ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <input type="text" name="query" class="form-control" placeholder="Поиск по объявлениям" value="<?=Yii::$app->request->get('query');?>">
                    <input type="hidden" name="r" value="site/index">
                </div>
            </div>
            <div class="col-md-2">
                <select class="form-control" id="select" name="city">
                    <option value="">Все города</option>
                    <?php foreach ($cities as $key => $city): ?>
                        <option value="<?=$city->id;?>"<?php if ($city->id == Yii::$app->request->get('city')): ?> selected<?php endif; ?>><?=$city->name;?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2" >
                <button type="submit" class="btn btn-success btn-block">Найти</button>
            </div>
        </div>
    </form>

    <h3>Найдено <?=count($items); ?> объявлений</h3>

    <hr />

    <div class="row row-offcanvas row-offcanvas-right">


        <div class="col-xs-12 col-sm-9">

            <?php foreach ($items as $item): ?>
                <div class="row">
                    <div class="col-md-4">
                        <a href="#">
                            <img class="img-responsive" src="/uploads/items/<?=$item->id;?>/<?php $images = unserialize($item->images); echo $images[0];?>" alt="">
                        </a>
                    </div>
                    <div class="col-md-8">
                        <div class="caption">
                            <h2 style="margin-top: 5px;"><a href="<?=\yii\helpers\Url::to(['site/item', 'id' => $item->id]);?>"><?=$item->title;?></a></h2>
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