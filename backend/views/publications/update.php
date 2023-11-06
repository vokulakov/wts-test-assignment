<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\BasePublications $model */

$this->title = 'Update Base Publications: ' . $model->postID;
$this->params['breadcrumbs'][] = ['label' => 'Base Publications', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->postID, 'url' => ['view', 'postID' => $model->postID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="base-publications-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
