<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Users".
 *
 * @property int $id
 * @property string $login
 * @property string $email
 * @property string $password
 * @property int $confirm_password
 * @property string $confirm_code
 * @property string $reset_code
 * @property int $level
 * @property int $hp
 * @property int $mp
 * @property int $win
 * @property int $lose
 * @property int $exp
 * @property int $gold
 * @property int $strength
 * @property int $intuition
 * @property int $dexterity
 * @property int $endurance
 * @property int $intelligence
 * @property int $mental
 * @property int $fire
 * @property int $woter
 * @property int $earth
 * @property int $air
 * @property int $stats
 * @property int $hp_regen_time
 * @property int $mp_regen_time
 * @property int $battle_id
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'email', 'password', 'confirm_code', 'reset_code', 'level', 'hp', 'mp', 'win', 'lose', 'exp', 'gold', 'strength', 'intuition', 'dexterity', 'endurance', 'intelligence', 'mental', 'fire', 'woter', 'earth', 'air', 'stats', 'hp_regen_time', 'mp_regen_time', 'battle_id'], 'required'],
            [[ 'level', 'hp', 'mp', 'win', 'lose', 'exp', 'gold', 'strength', 'intuition', 'dexterity', 'endurance', 'intelligence', 'mental', 'fire', 'woter', 'earth', 'air', 'stats', 'hp_regen_time', 'mp_regen_time', 'battle_id'], 'integer'],
            [['login', 'email', 'password', 'confirm_code', 'reset_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'email' => 'Email',
            'password' => 'Password',
            'confirm_password' => 'Confirm Password',
            'confirm_code' => 'Confirm Code',
            'reset_code' => 'Reset Code',
            'level' => 'Level',
            'hp' => 'Hp',
            'mp' => 'Mp',
            'win' => 'Win',
            'lose' => 'Lose',
            'exp' => 'Exp',
            'gold' => 'Gold',
            'strength' => 'Strength',
            'intuition' => 'Intuition',
            'dexterity' => 'Dexterity',
            'endurance' => 'Endurance',
            'intelligence' => 'Intelligence',
            'mental' => 'Mental',
            'fire' => 'Fire',
            'woter' => 'Woter',
            'earth' => 'Earth',
            'air' => 'Air',
            'stats' => 'Stats',
            'hp_regen_time' => 'Hp Regen Time',
            'mp_regen_time' => 'Mp Regen Time',
            'battle_id' => 'Battle ID',
        ];
    }

    public function getAuthKey() {
       return $this->authKey;
    }

    public function getId() {
        return $this->id;
    }

    public function validateAuthKey($authKey) {
        return $authKey === $this->authKey;
    }

    public static function findIdentity($id) {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException();
    }
    
    public static function findByUserName($userName){
        $user = self::find()->where(["login" => $userName])->one();
        return $user;
    }
    
    public function validatePassword($password) {
        
        return $this->password === $password;
    }
    
    public function getItem($type){
        
        $id = $this->$type;  
        $item = Items::find()->where(["id" => $id])->one();
        return $item;
    }

}
