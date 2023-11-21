<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class BaseApiController extends Controller
{

    /**
     * Получение параметров запроса публикаций
     * @param $request
     * @return array
     */
    public function getPublicationsRequestParams($request): array
    {
        $params = $request->get();
        $params['limit'] = $params['limit'] ?? Yii::$app->params['limitDefault'];
        $params['offset'] = $params['offset'] ?? Yii::$app->params['offsetDefault'];

        return $params;
    }

}
