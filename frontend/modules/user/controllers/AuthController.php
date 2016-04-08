<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\web\Controller;
use frontend\modules\user\models\SignupForm;
use common\models\User;

/**
 * Signup controller for the `user` module
 */
class AuthController extends Controller {

    public $successUrl = '/user/login';

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'index' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
                'successUrl' => $this->successUrl
            ],
        ];
    }

    public function successCallback($client) {
        $session = Yii::$app->session;
        $attributes = $client->getUserAttributes();
        $email = User::find()->where(['email' => $attributes['email']])->one();

        if ($email) {
            // email, fbid existed, login success    
            $fbid = User::find()->where(['fbid' => $attributes['id'], 'email' => $attributes['email']])->one();
            if ($fbid) {
                $active = User::find()->where(['fbid' => $attributes['id'], 'email' => $attributes['email'], 'status' => 1])->one();
                if ($active) {
                    Yii::$app->user->login($active);
                } else {
                    // email existed, redirect to login  
                    $session->set('active', 'true');
                    $session->set('email', $attributes['email']);
                    $session->set('fbid', $attributes['id']);
                    $this->successUrl = Yii::$app->urlManager->createAbsoluteUrl(['site/login']);
                }
            } else {
                // email existed, redirect to login  
                $session->set('login', '');
                $session->set('email', $attributes['email']);
                $session->set('fbid', $attributes['id']);
                $this->successUrl = Yii::$app->urlManager->createAbsoluteUrl(['site/login']);
            }
        } else {
            // email not exist, redirect to register    
            $session->set('login', 'false');
            $session->set('email', $attributes['email']);
            $session->set('fbid', $attributes['id']);
            $session->set('name', $attributes['name']);
            $this->successUrl = Yii::$app->urlManager->createAbsoluteUrl(['site/login']);
        }
    }

}
