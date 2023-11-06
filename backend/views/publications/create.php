<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\BasePublications $model */

$this->title = 'Create Base Publications';
$this->params['breadcrumbs'][] = ['label' => 'Base Publications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="base-publications-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
