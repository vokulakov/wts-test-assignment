<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;

use frontend\models\PublicationAdd;
use frontend\models\PublicationList;

use common\models\BasePublications;

class PublicationController extends Controller
{
    public $enableCsrfValidation = false;

    const LIMIT_DEFAULT = 15; //сколько записей вернуть
    const OFFSET_DEFAULT = 0; //сколько записей ранее уже было загружено

    public function behaviors()
    {
        return [
            [
                'class' => ContentNegotiator::class,
                'only' => ['add', 'all', 'my'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ],
                'languages' => [
                    'en'
                ]
            ],
            'access' => [
                'class' => AccessControl::class,
                'only' => ['add', 'all', 'my'],
                'rules' => [
                    [
                        'actions' => ['add', 'all', 'my'],
                        'allow' => true,
                        'roles' => ['?'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'add' => ['post'],
                    'all' => ['get'],
                    'my' => ['get']
                ],
            ]
        ];
    }

    /*
     * Опубликовать пост
     */
    public function actionAdd()
    {
        $request = Yii::$app->request;

        if (!$request->isPost)
        {
            return false;
        }

        $model = new PublicationAdd();
        $params = $request->post();

        if ($model->load($params, "") && $model->add())
        {
            return json_encode(
                [
                    'status' => 'success',
                    'data' => [
                        'accessToken' => $model->accessToken
                    ],
                    'errors' => $model->errors
                ],
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(
            [
                'status' => 'error',
                'data' => null,
                'errors' => $model->errors
            ],
            JSON_PRETTY_PRINT
        );

    }

    /*
     * Получить все публикации
     */
    public function actionAll()
    {
        $request = Yii::$app->request;
        if (!$request->isGet)
        {
            return false;
        }

        $model = new PublicationList();
        $params = $request->get();
        $params['limit'] = $params['limit'] ?? self::LIMIT_DEFAULT;
        $params['offset'] = $params['offset'] ?? self::OFFSET_DEFAULT;

        if ($model->load($params, "") && $model->getAllPublication())
        {
            return JSON::encode(
                [
                    'status' => 'success',
                    'data' => [
                        'publications' => $model->publications
                    ],
                    'errors' => $model->errors
                ],
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(
            [
                'status' => 'error',
                'data' => null,
                'errors' => $model->errors
            ],
            JSON_PRETTY_PRINT
        );

    }

    /*
     * Получить список моих публикаций/ публикаций пользователя
     */
    public function actionMy()
    {
        $request = Yii::$app->request;
        if (!$request->isGet)
        {
            return false;
        }

        $model = new PublicationList();
        $params = $request->get();
        $params['limit'] = $params['limit'] ?? self::LIMIT_DEFAULT;
        $params['offset'] = $params['offset'] ?? self::OFFSET_DEFAULT;

        if ($model->load($params, "") && $model->getUserPublications())
        {
            return JSON::encode(
                [
                    'status' => 'success',
                    'data' => [
                        'accessToken' => $model->accessToken,
                        'publications' => $model->publications
                    ],
                    'errors' => $model->errors
                ],
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(
            [
                'status' => 'error',
                'data' => null,
                'errors' => $model->errors
            ],
            JSON_PRETTY_PRINT
        );

    }

}