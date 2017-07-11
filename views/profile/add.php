<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="container">

    <div class="row">
        <div class="col-md-3">
            <h3>Привет, <?=\Yii::$app->user->identity->firstname;?>!</h3>
            <hr />
            <a href="<?=\yii\helpers\Url::to(['profile/add']);?>" class="btn btn-block btn-success">Подать объявление</a>
            <a href="<?=\yii\helpers\Url::to(['profile/index']);?>" class="btn btn-block btn-primary">Мои объявления</a>
        </div>

        <div class="col-md-9">
            <h3>Создать объявление</h3>

            <div class="items-form">

                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                <?= $form->field($model, 'user_id')->hiddenInput(['value' => \Yii::$app->user->identity->id])->label(false) ?>

                <?= $form->field($model, 'city_id')->dropDownList($cities, ['prompt' => 'Выберите город'])->label(false); ?>

                <?= $form->field($model, 'category_id')->dropDownList($categories, ['prompt' => 'Выберите категорию'])->label(false); ?>

                <hr />

                <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Название объявления') ?>

                <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('Краткое описание') ?>

                <?= $form->field($model, 'price')->textInput()->label('Цена') ?>

                <?= $form->field($model, 'shipping')->dropDownList([0 => 'Нет', 1 => 'Да'])->label('Отправка почтой') ?>

                <?= $form->field($model, 'image_file')->fileInput() ?>

                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    </div>
</div>


<div class="container">

    <div class="row row-offcanvas row-offcanvas-right">

    </div><!--/row-->
</div>
