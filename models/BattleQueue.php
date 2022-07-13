<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "battle_queue".
 *
 * @property int $id
 * @property int $user_id
 * @property int $enemy_id
 * @property int $battle_id
 */
class BattleQueue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'battle_queue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'enemy_id', 'battle_id'], 'required'],
            [['user_id', 'enemy_id', 'battle_id'], 'integer'],
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
            'enemy_id' => 'Enemy ID',
            'battle_id' => 'Battle ID',
        ];
    }
}
