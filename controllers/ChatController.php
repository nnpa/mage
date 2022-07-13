<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Users;
use app\models\Chat;

use app\controllers\GameController;

class ChatController extends GameController
{
    public $enableCsrfValidation = false;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $id = \Yii::$app->user->identity->id;
        $user = Users::find()->where(['id' => $id])->one();
        
        $chat = Chat::find()->where([])->orderBy("time")->all();
        $text = "";
        foreach($chat as $message){
            $text .= $message->text;
        }
        echo $text;exit;
    }
    
    public function actionSend($message){
        $id = \Yii::$app->user->identity->id;
        $user = Users::find()->where(['id' => $id])->one();
        
        date_default_timezone_set('Europe/Moscow');

        
        $chatCount = Chat::find()->where([])->count();
        
        if($chatCount > 20){
            $deleteChat = Chat::find()->where([])->orderBy(['id'=> SORT_ASC])->one();
            $deleteChat->delete();
        }
        
        $time = time();
        
        $message = htmlspecialchars($message);
        $chat = new Chat();
        $chat->text = " [" . gmdate("H:i", $time) . "] [<b>$user->login</b>] : $message <br>";
        $chat->time = $time;
        $chat->save(false);
        exit;
    }
    
    
}
