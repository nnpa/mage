<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Users;
use app\models\UserItems;
use app\models\Items;
use app\controllers\GameController;

class InventoryController extends GameController
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
                'only' => ['index','equip','unequip','reset'],
                'rules' => [
                    [
                        'actions' => ['index','equip','unequip','reset'],
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
        $items = UserItems::find()->where(["user_id" => $id])->all();
        
        $loadUser = $this->loadUser($id);
        return $this->render('index',[
            "user" => $user,
            "loadUser" => $loadUser,
            "items" => $items
        ]);
        
    }
    
    public function actionStat(){
        $id = \Yii::$app->user->identity->id;
        $user = Users::find()->where(['id' => $id])->one();
        
        
        if($user->stats > 0 && isset($_GET["atr"])){
            $atr = $_GET["atr"];
            
            $user->$atr  = $user->$atr + 1;
            $user->stats = $user->stats - 1;
            $user->save(false);
            
            
            return $this->redirect(['/inventory/index']);            
        }
    }
    
    public function actionUnequip($type){
            $userId = \Yii::$app->user->identity->id;
            $user = Users::find()->where(['id' => $userId])->one();
            
            $itemId = $user->$type;
            
            if($itemId != 0){
                $user->$type = 0;
                $user->save(false);
                
                $userItems = new UserItems();
                $userItems->user_id = $user->id;
                $userItems->item_id = $itemId;
                $userItems->save(false);
            }

           
        return $this->redirect(['/inventory/index']);
    }

    public function actionEquip(){
        if(isset($_GET['id']) && !empty($_GET['id']) ){
            $id = $_GET['id'];
            $item = Items::find()->where(['id' => $id])->one();
            
            $userId = \Yii::$app->user->identity->id;
            $user = Users::find()->where(['id' => $userId])->one();
            
            $userItem = UserItems::find()->where(['user_id' => $userId,"item_id" => $id])->one();
            $type= $item->type;
            
            if(!is_null($userItem)){
                if($type != 'ring'){
                    if($user->$type == 0){
                        if($this->checkAttr($user,$item)){
                            $userItem->delete();
                            $user->$type = $id;
                            $user->save(false);
                        }
                    }
                }else {
                    $free = null;
                    if($user->ring1 == 0){
                        $free = "ring1";
                    }
                    if($user->ring2 == 0){
                        $free = "ring2";
                    }
                    if($user->ring3 == 0){
                        $free = "ring3";
                    }
                    if(!is_null($free)){
                        if($this->checkAttr($user,$item)){
                            $userItem->delete();
                            $user->$free = $id;
                            $user->save(false);
                        }
                    }
                }
            }
        }
        return $this->redirect(['/inventory/index']);
    }
    
    public function checkAttr($user,$item){
        if($user->level < $item->need_level){
            return false;
        }
        if($user->strength < $item->need_strength){
            return false;
        }
        if($user->intuition < $item->need_intuition){
            return false;
        }
        if($user->dexterity < $item->need_dexterity){
            return false;
        }
        if($user->endurance < $item->need_endurance){
            return false;
        }
        if($user->intelligence < $item->need_intelligence){
            return false;
        }
        return true;
    }
    
    public function actionInfo($id){
        $this->layout = 'main2'; 
        $user = Users::find()->where(['id' => $id])->one();
        
        $loadUser = $this->loadUser($id);
        
        if(!is_null($user)){
            return $this->render('info',[
                "user" => $user,
                "loadUser" => $loadUser
            ]); 
        }
    }
    
    public function actionReset(){
        $this->actionUnequip('helm');
        $this->actionUnequip('weapon');
        $this->actionUnequip('armor');
        $this->actionUnequip('belt');
        $this->actionUnequip('earrings');
        $this->actionUnequip('necklace');
        $this->actionUnequip('ring1');
        $this->actionUnequip('ring2');
        $this->actionUnequip('ring3');
        $this->actionUnequip('shild');
        $this->actionUnequip('leggings');
        $this->actionUnequip('boots');
        
        $userId = \Yii::$app->user->identity->id;
        $user = Users::find()->where(['id' => $userId])->one();
        $user->stats = $user->level * 50;
        $user->strength = 5;
        $user->intuition = 5;
        $user->dexterity = 5;
        $user->endurance = 5;

        $user->intelligence = 0;
        $user->mental = 0;

        $user->fire = 0;
        $user->woter = 0;
        $user->earth = 0;
        $user->air = 0;
        $user->save();
        return $this->redirect(['/inventory/index']);

    }
    

}
