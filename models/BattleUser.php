<?php

namespace app\models;

use Yii;
use app\models\Users;
/**
 * This is the model class for table "battle_user".
 *
 * @property int $id
 * @property int $user_id
 * @property int $hp
 * @property int $max_xp
 * @property int $mp
 * @property int $max_mp
 * @property int $command
 * @property int $cd
 */
class BattleUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'battle_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'hp', 'max_xp', 'mp', 'max_mp', 'command', 'cd'], 'required'],
            [['user_id', 'hp', 'max_xp', 'mp', 'max_mp', 'command', 'cd'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'hp' => 'Hp',
            'max_xp' => 'Max Xp',
            'mp' => 'Mp',
            'max_mp' => 'Max Mp',
            'command' => 'Command',
            'cd' => 'Cd',
        ];
    }
    
    public function getUser(){
        return Users::find()->where(["id" => $this->user_id])->one();
    }
}
