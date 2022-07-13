<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Users;
use app\models\Items;
use app\models\UserItems;
use app\controllers\GameController;


class ShopController extends GameController
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
    
    
    public function actionIndex(){
        $items = [];
        
        if(isset($_GET['type']) && !empty($_GET['type'])){
            $type = $_GET['type'];
            $items = Items::find()->where(['type' => $type])->orderBy('cost')->all();
        }
        $id = \Yii::$app->user->identity->id;
        $user = Users::find()->where(['id' => $id])->one();
        
        return $this->render('index',['items' => $items,'user' =>$user]);
    }
    
    public function actionBuy(){
        if(isset($_GET['id']) && !empty($_GET['id'])){
            $id = $_GET['id'];
            $item = Items::find()->where(['id' => $id])->one();
            
            $userId = \Yii::$app->user->identity->id;
            $user = Users::find()->where(['id' => $userId])->one();
            if($user->gold >= $item->cost){
                $userItems = new UserItems();
                $userItems->user_id = $user->id;
                $userItems->item_id = $id;
                $userItems->save(false);
                $user->gold = $user->gold - $item->cost;
                $user->save(false);
            }
        }
        return $this->redirect("/shop/index");
    }
    
    public function actionSell(){
        if(isset($_GET['id']) && !empty($_GET['id'])){
            $id = $_GET['id'];
            $item = Items::find()->where(['id' => $id])->one();
        
            $userId = \Yii::$app->user->identity->id;
            $user = Users::find()->where(['id' => $userId])->one();
            
            $userItem = UserItems::find()->where(['user_id' => $userId,"item_id" => $id])->one();
            if(!is_null($userItem)){
                $gold = $item->cost/2;
                $user->gold = $user->gold + $gold;
                $user->save(false);
                
                $userItem->delete();
            }
            
        }
        return $this->redirect("/inventory/index");
    }
    
    public function actionInfo($id){
        $this->layout = 'main2'; 

        $item = Items::find()->where(["id" => $id])->one();
        
        if(!is_null($item)){
            return $this->render('info',["item"=>$item]);
            
        }
        exit;
    }
}
