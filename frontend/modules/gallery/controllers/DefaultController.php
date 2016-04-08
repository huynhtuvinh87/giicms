<?php

namespace frontend\modules\gallery\controllers;

use yii\web\Controller;
use common\models\Media;
use yii\data\ActiveDataProvider;

/**
 * Default controller for the `gallery` module
 */
class DefaultController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Media::find()->where(['user_id' => \Yii::$app->user->id])->orderBy(['created_at' => SORT_DESC]),
            'pagination' => array(
                'pageSize' => 6,
            ),
        ]);
        $media = Media::find()->where(['user_id' => \Yii::$app->user->id])->orderBy(['created_at' => SORT_DESC])->all();
        if (!empty($_GET['page']))
            return $this->renderAjax('_list', ['dataProvider' => $dataProvider]);
        else
            return $this->renderAjax('index', ['media' => $media, 'dataProvider' => $dataProvider]);
    }

}
