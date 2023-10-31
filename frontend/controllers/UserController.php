<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;

use common\models\User;

class UserController extends Controller
{
    /*
     * https://www.yiiframework.com/doc/guide/2.0/en/security-best-practices
     * csrf блокирует post-запросы
     */
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            [
                'class' => ContentNegotiator::class,
                'only' => ['signup', 'login'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'application/xml' => Response::FORMAT_XML
                ],
                'languages' => [
                    'en'
                ]
            ],
            'access' => [
                'class' => AccessControl::class,
                'only' => ['signup', 'login'],
                'rules' => [
                    [
                        'actions' => ['signup', 'login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'signup' => ['post'],
                    'login' => ['post']
                ],
            ]
        ];
    }

    /*
     * Регистрация пользователя
     */
    public function actionSignup()
    {
        $request = Yii::$app->request;

        if (!$request->isPost)
        {
            return false;
        }

        return json_encode([]);
    }

    /*
     * Авторизация пользователя
     */
    public function actionLogin()
    {
        $request = Yii::$app->request;

        if (!$request->isPost)
        {
            return false;
        }

        return json_encode([]);
    }

}
