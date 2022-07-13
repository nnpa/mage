<?php

namespace app\models;

use Yii;
use app\models\BattleUser;

/**
 * This is the model class for table "battle".
 *
 * @property int $id
 * @property int $started
 * @property int $time
 */
class Battle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'battle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['started', 'time'], 'required'],
            [['started', 'time'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'started' => 'Started',
            'time' => 'Time',
        ];
    }
    
    public function getUsers(){
        return BattleUser::find()->where(["battle_id" =>$this->id])->all();
    }
}
