<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\components;

use Yii;
use yii\base\Component;
use yii\web\Application;
use yii\base\InvalidConfigException;
use common\models\Language;

class Lang extends Component {

    public function get() {
        $model = Language::find()->where(['publish' => 1])->one();
        echo $model->name;
    }

}
