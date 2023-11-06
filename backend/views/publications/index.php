<?php

use common\models\BasePublications;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\PublicationsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Base Publications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="base-publications-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Base Publications', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'postID',
            'tittle',
            'text:ntext',
            'authorID',
            'createdAt',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, BasePublications $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'postID' => $model->postID]);
                 }
            ],
        ],
    ]); ?>


</div>
