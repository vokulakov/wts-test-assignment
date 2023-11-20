<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\PublicationsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="base-publications-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'postID') ?>

    <?= $form->field($model, 'tittle') ?>

    <?= $form->field($model, 'text') ?>

    <?= $form->field($model, 'authorID') ?>

    <?= $form->field($model, 'createdAt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
