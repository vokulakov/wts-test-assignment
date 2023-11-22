<?php

namespace frontend\controllers;

use Yii;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Response;

use frontend\models\CommentsForm;

class CommentsController extends BaseApiController
{
    public $enableCsrfValidation = false;

    function behaviors()
    {
        return [
            [
                'class' => ContentNegotiator::class,
                'only' => ['add', 'delete', 'all'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ],
                'languages' => [
                    'en'
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'add' => ['post'],
                    'delete' => ['post'],
                    'all' => ['get']
                ],
            ]
        ];
    }

    /**
     * Получение всех комментариев к посту
     */
    public function actionAll()
    {
        $params = $this->getRequestParams(Yii::$app->request);
        $model = new CommentsForm();

        if ($model->load($params, "") && $model->getCommentsFromPostId())
        {
            return [
                'status' => 'success',
                'data' => [
                    'comments' => $model->comments
                ],
                'errors' => $model->errors
            ];
        }

        return [
            'status' => 'error',
            'data' => null,
            'errors' => $model->errors
        ];
    }

    /**
     * Добавление комментария к посту
     */
    public function actionAdd()
    {
        $request = Yii::$app->request;
        $params = $request->post();

        $model = new CommentsForm();
        if ($model->load($params, "") && $model->addCommentToPost())
        {
            return [
                'status' => 'success',
                'data' => [
                    'accessToken' => $model->accessToken
                ],
                'errors' => $model->errors
            ];
        }

        return [
            'status' => 'error',
            'data' => null,
            'errors' => $model->errors
        ];
    }

    /**
     * Удаление комментария с поста
     */
    public function actionDelete()
    {
        $request = Yii::$app->request;
        $params = $request->post();

        $model = new CommentsForm();
        if ($model->load($params, "") && $model->deleteCommentFromPost())
        {
            return [
                'status' => 'success',
                'data' => [
                    'accessToken' => $model->accessToken,
                    'commentId' => $model->commentId
                ],
                'errors' => $model->errors
            ];
        }

        return [
            'status' => 'error',
            'data' => null,
            'errors' => $model->errors
        ];
    }
}