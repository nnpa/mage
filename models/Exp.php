<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "exp".
 *
 * @property int $id
 * @property int $level
 * @property int $stats
 * @property int $gold
 * @property int $win
 */
class Exp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'exp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['level', 'stats', 'gold', 'win'], 'required'],
            [['level', 'stats', 'gold', 'win'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level' => 'Level',
            'stats' => 'Stats',
            'gold' => 'Gold',
            'win' => 'Win',
        ];
    }
}
