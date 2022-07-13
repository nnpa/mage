<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Battle;
use app\models\Users;

class GameController extends Controller
{
    
    public function beforeAction($action)
    {
        if(is_object(\Yii::$app->user->identity)){
           
           $id = \Yii::$app->user->identity->id;
            $user = Users::find()->where(['id' => $id])->one();
            $user->active = time() + 60 * 2;
            $user->save(false);
            
            if($user->battle_id != 0){
                $battle = Battle::find()->where(["id" => $user->battle_id])->one();
                if($battle->started == 1){
                    if($this->action->id != 'attack' AND $this->action->id != 'end' AND $this->action->id != 'battle' AND $this->action->id != 'info'){
                        return $this->redirect(['/battle/battle']);
                    }
                }
            } 
            
            
        }

        return parent::beforeAction($action);
    }
    
    public function loadUser($id){
        $itemUser = Users::find()->where(['id' => $id])->one();
        
        $user = new Users();
        $user->login = $itemUser->login;

        $user->strength = $itemUser->strength;
        $user->intuition = $itemUser->intuition;
        $user->dexterity = $itemUser->dexterity;
        $user->endurance = $itemUser->endurance;
        $user->intelligence = $itemUser->intelligence;
        $user->mental = $itemUser->mental;
        $user->fire = $itemUser->fire;
        $user->woter = $itemUser->woter;
        $user->earth = $itemUser->earth;
        $user->air = $itemUser->air;
        
        
        $item = $itemUser->getItem('helm');
        $user = $this->loadFromItem($user,$item);
        
        $item = $itemUser->getItem('earrings');
        $user = $this->loadFromItem($user,$item);
        
        $item = $itemUser->getItem('necklace');
        $user = $this->loadFromItem($user,$item);
        
        $item = $itemUser->getItem('ring1');
        $user = $this->loadFromItem($user,$item);
        
        $item = $itemUser->getItem('ring2');
        $user = $this->loadFromItem($user,$item);
        
        $item = $itemUser->getItem('ring3');
        $user = $this->loadFromItem($user,$item);
        
        $item = $itemUser->getItem('armor');
        $user = $this->loadFromItem($user,$item);
      
        $item = $itemUser->getItem('shild');
        $user = $this->loadFromItem($user,$item);
        
        $item = $itemUser->getItem('weapon');
        $user = $this->loadFromItem($user,$item);
        
        $item = $itemUser->getItem('leggings');
        $user = $this->loadFromItem($user,$item);
        
        $item = $itemUser->getItem('belt');
        $user = $this->loadFromItem($user,$item);
        
        $item = $itemUser->getItem('boots');
        $user = $this->loadFromItem($user,$item);
        
        $user->hp = $user->hp + $user->endurance * 5;
        $user->mp = $user->mp + $user->mental * 5;
        
        return $user;
    }
    
    public function loadFromItem($user,$item){
        if(is_object($item)){

            $user->strength = $user->strength  + $item->strength;
            $user->intuition =  $user->intuition  + $item->intuition; 
            $user->dexterity = $user->dexterity + $item->dexterity;
            $user->endurance = $user->endurance +  $item->endurance;
            $user->intelligence = $user->intelligence +  $item->intelligence;
            $user->mental = $user->mental + $item->mental;
            $user->fire = $user->fire +  $item->fire;
            $user->woter = $user->woter + $item->woter;
            $user->earth = $user->earth + $item->earth;
            $user->air = $user->air + $item->air;
            
            $user->defence = $user->defence + $item->defence;
            $user->hp = $user->hp + $item->hp;
            $user->damage = $user->damage + $item->damage;

        }
        return $user;
    }
    
}
