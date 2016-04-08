<?php

namespace frontend\modules\user;

/**
 * user module definition class
 */
class UserModule extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\user\controllers';
    public $layout = '/forum';

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();

        // custom initialization code goes here
    }

}
