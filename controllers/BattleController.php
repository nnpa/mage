<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Users;
use app\models\Battle;
use app\models\BattleUser;
use app\models\BattleQueue;
use app\models\BattleHistory;
use app\models\Exp;
use app\controllers\GameController;

class BattleController extends GameController
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
        
        //стартануть битву
        if($user->battle_id != 0){
           $battle = Battle::find()->where(["id" => $user->battle_id])->one();
           if($battle->time < time() && $battle->started == 0){
               $battleUsersCount = BattleUser::find()->where(["battle_id" => $user->battle_id])->count();
               if($battleUsersCount >= 2){
                    $battle->started = 1;
                    $battle->save(true);
    
               } else {
                    $user->battle_id = 0;
                    $user->save(true);
                    $battle->started = 3;
                    $battle->save(true);
               }
           }
        }
        
        //принять участие
        if(isset($_POST["battle"]) && !empty($_POST['battle']) && $user->battle_id == 0){
            $battleId = $_POST['battle'];
            $user->battle_id = $battleId;
            $user->save(true);
            
            $user = $this->loadUser($user->id);
            
            $userBattle = new BattleUser();
            $userBattle->battle_id = $battleId;
            $userBattle->user_id   = $id;
            $userBattle->hp   = $user->hp;
            $userBattle->max_xp   = $user->hp;
            $userBattle->mp   = $user->mp;
            $userBattle->max_mp   = $user->mp;
            $userBattle->command   = $this->getCommand($battleId);
            
            $userBattle->cd   = time();
            $userBattle->damage   = 0;

            $userBattle->save(false);
            return $this->redirect(['/battle/index']);exit;
        }

        //подать заявку
        if(isset($_POST["level"]) && !empty($_POST['level']) && $user->battle_id == 0){
            $level = $_POST['level'];
            $battle = new Battle();

            if($level == 1){
                $battle->level = $user->level;
            }else{
                $battle->level = 0;
            }
            $battle->time = time() + 60 * 1;
            $battle->started = 0;
            
            $battle->save(false);
            
            
            $user = $this->loadUser($user->id);
            
            $userBattle = new BattleUser();
            $userBattle->battle_id = $battle->id;
            $userBattle->user_id   = $id;
            $userBattle->hp   = $user->hp;
            $userBattle->max_xp   = $user->hp;
            $userBattle->mp   = $user->mp;
            $userBattle->max_mp   = $user->mp;
            $userBattle->command   = 1;
            $userBattle->cd   = time();
            $userBattle->damage   = 0;

            $userBattle->save(false);
            
            $user = Users::find()->where(['id' => $id])->one();
            $user->battle_id = $battle->id;
            $user->save(true);
            return $this->redirect(['/battle/index']);exit;
        }
        
        $battles = Battle::find()->where(["level" => $user->level,"started" => 0])->orWhere(["level" => 0,"started" => 0])->all();
        
        return $this->render('index',[
            "user" => $user,
            "battles" => $battles
        ]);
    }
    
    public function getCommand($battleId){
        $command1Count = BattleUser::find()->where(["battle_id" => $battleId , "command" => 1])->count();
    
        $command2Count = BattleUser::find()->where(["battle_id" => $battleId , "command" => 2])->count();
        
        if($command1Count >= $command2Count){
            $command = 2;
        } else {
            $command = 1;

        }
        return $command;
    }
    
   public function actionInfo($id){
        $this->layout = 'main2'; 
        $battle = Battle::find()->where(["id"=>$id,"started" => 1])->one();
        if(!is_null($battle)){
            $battleHistory = BattleHistory::find()->where(["battle_id" => $id])->orderBy('id')->all();
            $Command1 = BattleUser::find()->where(["battle_id" => $id,"command" => 1])->all();
            $Command2 = BattleUser::find()->where(["battle_id" => $id,"command" => 2])->all();
            $battleHistory = BattleHistory::find()->where(["battle_id" => $id])->orderBy('id')->all();
            
            return $this->render('info',[
                "command1" => $Command1,
                "command2" => $Command2,
                "battleHistory" => $battleHistory
            ]); 
        }
        exit;
   }

    
    public function actionBattle(){
        $id = \Yii::$app->user->identity->id;
        $user = Users::find()->where(['id' => $id])->one();
        
        
        $Command1 = BattleUser::find()->where(["battle_id" => $user->battle_id,"command" => 1])->all();
        $Command2 = BattleUser::find()->where(["battle_id" => $user->battle_id,"command" => 2])->all();
        
        $endBattle = false;
        $Command1Hp = 0;
        foreach($Command1 as $command1User){
           $Command1Hp += $command1User->hp; 
        }
        
        $Command2Hp = 0;
        foreach($Command2 as $command2User){
           $Command2Hp += $command2User->hp; 
        }
        
        if($Command1Hp <= 0 || $Command2Hp <= 0){
            $endBattle = true;
        }
        
        $battleUser = BattleUser::find()->where(["battle_id" => $user->battle_id,"user_id" => $id])->one();

        $enemy = $this->getEnemy($user->battle_id, $id);
        
        $battleUserEnemy = null;
        if(!is_null($enemy)){
            $battleUserEnemy = BattleUser::find()->where(["battle_id" => $user->battle_id,"user_id" => $enemy->id])->one();
        }
        
        
        $battleHistory = BattleHistory::find()->where(["battle_id" => $user->battle_id])->orderBy('id')->all();
        
        
        $loadUser = $this->loadUser($id);
        
        $fireCost = $this->getManaCost($battleUser->max_mp,$loadUser->mental,"fire");
        $woterCost = $this->getManaCost($battleUser->max_mp,$loadUser->mental,"woter");
        $earthCost = $this->getManaCost($battleUser->max_mp,$loadUser->mental,"earth");
        $airCost = $this->getManaCost($battleUser->max_mp,$loadUser->mental,"air");
        
        
        $fire = false;
        $woter = false;
        $earth = false;
        $air   = false;
        
        if($fireCost < $battleUser->mp){
            $fire = true;
        }
        if($woterCost < $battleUser->mp){
            $woter = true;
        }
        
        if($earthCost < $battleUser->mp){
            $earth = true;
        }
        
        if($airCost < $battleUser->mp){
            $air = true;
        }
        
        
        return $this->render('battle',[
            "battleUser" =>$battleUser,
            "battleUserEnemy" => $battleUserEnemy,
            "user" => $user,
            "user2" => $enemy,
            "command1" => $Command1,
            "command2" => $Command2,
            "battleHistory" => $battleHistory,
            "fire" => $fire,
            "earth" => $earth,
            "woter" => $woter,
            "air" => $air,
            "loadUser" => $loadUser,
            "endBattle" => $endBattle
        ]);
    }
    
    public function getEnemy($battleId,$userId){
        $enemy = BattleQueue::find()->where(["battle_id" => $battleId,"user_id" => $userId])->all();
        if(!empty($enemy)){
            
            return Users::find()->where(['id' => $enemy[0]->enemy_id])->one();
        }else{
            //
            $this->setEnemy($battleId, $userId);
            $enemy = BattleQueue::find()->where(["battle_id" => $battleId,"user_id" => $userId])->all();
            
            if(empty($enemy)){
               return null; 
            }
            
            return Users::find()->where(['id' => $enemy[0]->enemy_id])->one();
        }
    }
    
    public function setEnemy($battleId,$userId){
        $battleUser = BattleUser::find()->where(["user_id" => $userId,"battle_id" => $battleId])->one();
        $command = $battleUser->command;
        if($command == 1){
            $enemyCommand = 2;
        } else {
            $enemyCommand = 1;
        }
        $enemys = BattleUser::find()->where(["battle_id" => $battleId,"command" => $enemyCommand])->all();
        
        foreach($enemys as $enemy){
            if($enemy->hp > 0){
                $battleQueue = new BattleQueue();
                $battleQueue->battle_id = $battleId;
                $battleQueue->user_id = $userId;
                $battleQueue->enemy_id = $enemy->user_id;
                $battleQueue->save(true);
            }
        }
    }
    
    public function getManaCost($mp,$mental,$type){
        if($type == "fire"){
            $cost = ($mp/100 * 25) - $mental/2;
        }
        if($type == "earth"){
            
            $cost = ($mp/100 * 20) - $mental/2;
        }
        if($type == "woter"){
            $cost = ($mp/100 * 60) - $mental/2;
        }
        if($type=="air"){
            $cost = ($mp/100 * 15) - $mental/2;
        }
        return ceil($cost);
    }
    
    public function actionAttack($type){
        
        $id = \Yii::$app->user->identity->id;
        $user = Users::find()->where(['id' => $id])->one();

        
        $enemy = $this->getEnemy($user->battle_id, $id);
        $battleUserEnemy = BattleUser::find()->where(["battle_id" => $user->battle_id,"user_id" => $enemy->id])->one();
        
        $battleUser = BattleUser::find()->where(["battle_id" => $user->battle_id,"user_id" => $user->id])->one();
        
        if($battleUser->cd > time()){
            return $this->redirect(['/battle/battle']);exit;
        }
        
        $battleUser->cd = time() + 2;
        $battleUser->save(true);
        
        $loadUser = $this->loadUser($id);
        $loadUserEnemy = $this->loadUser($enemy->id);
        
        
        
        if($type == 1){
            $element = $this->getElement($loadUser);
            
            $damage = $loadUser->damage + $loadUser->intelligence +  $loadUser->strength * 1.2 + $loadUser->$element - $loadUserEnemy->$element -$loadUserEnemy->defence * 2;
            if($damage < 0){
                $damage = 0;
            }
            $critChance = $loadUserEnemy->intuition - $loadUser->intuition;
            
            if($critChance <= 0){
                $critChance = 7;
            }
            
            $crit = $this->getCrit($critChance);
            
            if($crit){
               $damage = ceil($damage * 1.7); 
            }
            
            $agilityChance = $loadUser->dexterity - $loadUserEnemy->dexterity;
            
            if($agilityChance <= 0){
                $agilityChance = 7;
            }
                
            $agility = $this->getAgility($agilityChance);
            
            if(!$agility){
                $battleUserEnemy->hp = $battleUserEnemy->hp - $damage;
                $battleUser->damage = $battleUser->damage + $damage;
            }
            
            if($battleUserEnemy->hp < 0 ){
                $battleUserEnemy->hp = 0;
            }
            
            $battleUserEnemy->save(true);
            $battleUser->save(true);

            $dmgText = $damage;
            
            if($crit){
                $dmgText = "<span style='color:red'>" . $damage . "</span>";
            }
            
            if(!$agility){

                $text = "<b>$loadUser->login</b> нанес удар " . $this->getRandomBattleText() . " <b>$loadUserEnemy->login</b> -" . $dmgText ." (". $this->elemts[$element] .")";
            } else {
                $text = "<b>$loadUserEnemy->login</b> увернулся от удара <b>$loadUser->login</b>";
            }
            
            $battleHistory = new BattleHistory();
            $battleHistory->battle_id = $user->battle_id;
            $battleHistory->text = $text;
            $battleHistory->save(false);
            
            $queue = BattleQueue::find()->where(["battle_id" => $user->battle_id,"enemy_id" =>$enemy->id ])->one();
            $queue->delete();
        }   
        
        if($type == 2){
            $battleUser = BattleUser::find()->where(["battle_id" => $user->battle_id,"user_id" => $user->id])->one();
            
            if($battleUser->command == 1){
                $enemyCommand = 2;
            } else{
                $enemyCommand = 1;
            }
            $arthCost = $this->getManaCost($battleUser->max_mp,$loadUser->mental,"earth");
            if($battleUser->mp >= $arthCost){
                $battleUser->mp = $battleUser->mp - $arthCost;
                $battleUser->save(false);

                $battleUserEnemys = BattleUser::find()->where(["battle_id" => $user->battle_id,"command" => $enemyCommand])->andWhere(['!=', 'hp', 0])->all();
                $text = "<b>$loadUser->login</b> нанес удар <span style='color:green'>землей</span> по: ";
                $damageCount = 0;
                foreach($battleUserEnemys as $battleEnemy){
                    $loadEnemy = $this->loadUser($battleEnemy->user_id);
                    $damage = $loadUser->earth/3 + (0.4 * $loadUser->intelligence) - $loadEnemy->earth;
                    $damage = ceil($damage);
                    
                    if($damage < 0){
                        $damage = 0;
                    }
                    $battleEnemy->hp = $battleEnemy->hp - $damage;
                    $damageCount = $damageCount + $damage;
                    $battleEnemy->save(false);
                    $text .= " <b>$loadEnemy->login</b> - $damage " ;
                }
                $battleUser->damage = $battleUser->damage + $damageCount;
                $battleUser->save(false);
                
                $battleHistory = new BattleHistory();
                $battleHistory->battle_id = $user->battle_id;
                $battleHistory->text = $text;
                $battleHistory->save(false);
                
                $queue = BattleQueue::find()->where(["battle_id" => $user->battle_id,"enemy_id" =>$enemy->id ])->one();
                $queue->delete();
            }
        }
        
        if($type == 3){
            $battleUser = BattleUser::find()->where(["battle_id" => $user->battle_id,"user_id" => $user->id])->one();
            $fireCost = $this->getManaCost($battleUser->max_mp,$loadUser->mental,"fire");
            if($battleUser->mp >= $fireCost){
                $battleUser->mp = $battleUser->mp - $fireCost;
                $battleUser->save(false);
                
                $damage = $loadUser->fire + 0.6 * $loadUser->intelligence - $loadUserEnemy->fire * 2;
                $damage = ceil($damage);
                
                if($damage < 0){
                    $damage = 0;
                }
                
                $battleUserEnemy->hp = $battleUserEnemy->hp - $damage;
                $battleUserEnemy->save(false);
                $battleUser->damage = $battleUser->damage + $damage;
                $battleUser->save(false);
                
                
                $text = "<b>$loadUser->login</b> нанес удар <span style='color:red'>огнем</span> по <b>$loadUserEnemy->login</b> - $damage";
                $battleHistory = new BattleHistory();
                $battleHistory->battle_id = $user->battle_id;
                $battleHistory->text = $text;
                $battleHistory->save(false);
                
                $queue = BattleQueue::find()->where(["battle_id" => $user->battle_id,"enemy_id" =>$enemy->id ])->one();
                $queue->delete();
            }
        }
        
        if($type == 4){
            $battleUser = BattleUser::find()->where(["battle_id" => $user->battle_id,"user_id" => $user->id])->one();
            $woterCost = $this->getManaCost($battleUser->max_mp,$loadUser->mental,"woter");
            
            if($battleUser->mp >= $woterCost){
                $battleUser->mp = $battleUser->mp - $woterCost;
                
                $heal = ($loadUser->woter * 3) + $loadUser->intelligence;
                
                $battleUser->hp = $battleUser->mp + $heal;
                if($battleUser->max_xp < $battleUser->hp){
                    $battleUser->hp = $battleUser->max_xp;
                }
                $battleUser->save(false);
                $battleUser->damage = $battleUser->damage + $heal;
                $battleUser->save(false);
                $text = "<b>$loadUser->login</b> исцелил себя на  <span style='color:#7FFF00'>+$heal</span>";
                $battleHistory = new BattleHistory();
                $battleHistory->battle_id = $user->battle_id;
                $battleHistory->text = $text;
                $battleHistory->save(false);
                
                $queue = BattleQueue::find()->where(["battle_id" => $user->battle_id,"enemy_id" =>$enemy->id ])->one();
                $queue->delete();

            }
        }
        
        if($type == 5){
            $battleUser = BattleUser::find()->where(["battle_id" => $user->battle_id,"user_id" => $user->id])->one();
            $airCost = $this->getManaCost($battleUser->max_mp,$loadUser->mental,"fire");
            if($battleUser->mp >= $airCost){
                $battleUser->mp = $battleUser->mp - $airCost;
                $battleUser->save(false);
                
                $damage = $loadUser->air + (0.4 * $loadUser->intelligence) - $loadUserEnemy->air;
                $damage = ceil($damage);
                
                if($damage < 0){
                    $damage = 0;
                }
                
                $battleUserEnemy->hp = $battleUserEnemy->hp - $damage;
                $battleUserEnemy->save(false);
                
                $battleUser->damage = $battleUser->damage + $damage;
                $battleUser->save(false);
                
                $text = "<b>$loadUser->login</b> нанес удар <span style='color:LightSkyBlue'>воздухом</span> по <b>$loadUserEnemy->login</b> - $damage";
                $battleHistory = new BattleHistory();
                $battleHistory->battle_id = $user->battle_id;
                $battleHistory->text = $text;
                $battleHistory->save(false);
                
                $queue = BattleQueue::find()->where(["battle_id" => $user->battle_id,"enemy_id" =>$enemy->id ])->one();
                $queue->delete();
            }
        }

        
        return $this->redirect(['/battle/battle']);
    }
    
    public function getCrit($critChance){
        $crit = false;
        $rand = random_int(1, 100);
        if($critChance >= $rand ){
            $crit = true;
        }
        return $crit;
    }
    
    public function getAgility($agilityChance){
        $crit = false;
        $rand = random_int(1, 100);
        if($agilityChance >= $rand ){
            $crit = true;
        }
        return $crit;
    }
    
    public function getRandomBattleText(){
         $rand_keys = array_rand($this->battleText, 2);
         return $this->battleText[$rand_keys[0]];
    }
    
    public $elemts = ["fire" => "<span style='color:red'>огонь</span>","woter" => "<span style='color:blue'>вода</span>" ,"earth" => "<span style='color:green'>земдя</span>","air" => "<span style='color:LightSkyBlue'>воздух</span>"];
    
    public $battleText = [
        "по ногам",
        "в голову",
        "по корпусу",
        "в пах"
    ];
    
    public function actionEndbattle(){
        $id = \Yii::$app->user->identity->id;
        $user = Users::find()->where(['id' => $id])->one();
        
        $battleUser = BattleUser::find()->where(["battle_id" => $user->battle_id,"user_id" => $id])->one();

        $Command1 = BattleUser::find()->where(["battle_id" => $user->battle_id,"command" => 1])->all();
        $Command2 = BattleUser::find()->where(["battle_id" => $user->battle_id,"command" => 2])->all();
        
        $endBattle = false;
        $Command1Hp = 0;
        foreach($Command1 as $command1User){
           $Command1Hp += $command1User->hp; 
        }
        
        $Command2Hp = 0;
        foreach($Command2 as $command2User){
           $Command2Hp += $command2User->hp; 
        }
        
        if($Command1Hp <= 0 || $Command2Hp <= 0){
            $user->battle_id = 0;
            
            $lose = 0;
            $win  = 0;

            if($Command1Hp <= 0 AND $battleUser->command == 1){
                $lose = 1;
            }

            if($Command1Hp <= 0 AND $battleUser->command == 2){
                $win = 1;
            }
            
            if($Command2Hp <= 0 AND $battleUser->command == 1){
                $win = 1;
            }
            
            if($Command2Hp <= 0 AND $battleUser->command == 2){
                $lose = 1;
            }
            
            $user->win = $user->win + $win;
            $user->lose = $user->lose + $lose;
            
            $user->gold = $user->gold + ($user->level * 5);
            
            if($user->level + 1 <= 10){
                $exp = Exp::find()->where(["level" => $user->level + 1])->one();

                if($user->win == $exp->win){
                    $user->stats = $user->stats + $exp->stats;
                    $user->gold = $user->gold + $exp->gold;
                    $user->level = $exp->level;

                }
                $user->save(false);  
            }
            
        }
        return $this->redirect(['/inventory/index']);
    }
    
    public function getElement($user){
        $elements = [
            "fire" => $user->fire,
            "woter" => $user->woter,
            "earth" => $user->earth,
            "air" => $user->air
        ];

        arsort($elements);
        return array_key_first($elements);
    }
}
