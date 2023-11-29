<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\BasePublications $model */

$this->title = $model->postID;
$this->params['breadcrumbs'][] = ['label' => 'Base Publications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="base-publications-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'postID' => $model->postID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'postID' => $model->postID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'postID',
            'tittle',
            'text:ntext',
            'authorID',
            'createdAt',
        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $comments,
        'columns' => [
            'commentId',
            'commentContent',
            [
                'attribute' => 'createdAt',
                'format' => ['date', 'php:Y-m-d H:i:s']
            ],
            [
                'attribute' => 'updatedAt',
                'format' => ['date', 'php:Y-m-d H:i:s']
            ],
            'authorId',
        ]
    ]) ?>

</div>
