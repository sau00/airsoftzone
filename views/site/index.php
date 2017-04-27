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
                        <a href="http://vk.com/id<?=$item->user_id->vk;?>" target="_blank">
                            <img class="img-responsive" src="<?=$item->vk_image;?>" alt="">
                        </a>
                    </div>
                    <div class="col-md-8">
                        <div class="caption">
                            <h3><a href="http://vk.com/id<?=$item->user_id->vk;?>" target="_blank"><?=$item->user_id->name;?> (http://vk.com/id<?=$item->user_id->vk;?>)</a></h3>
                            <?=$item->description;?>
                        </div>
                    </div>
                </div>
                <hr />
            <?php endforeach; ?>
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