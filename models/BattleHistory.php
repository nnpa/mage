<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "battle_history".
 *
 * @property int $id
 * @property int $battle_id
 * @property string $text
 */
class BattleHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'battle_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['battle_id', 'text'], 'required'],
            [['battle_id'], 'integer'],
            [['text'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'battle_id' => 'Battle ID',
            'text' => 'Text',
        ];
    }
}
