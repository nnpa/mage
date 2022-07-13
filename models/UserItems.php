<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_items".
 *
 * @property int $id
 * @property int $user_id
 * @property int $item_id
 */
class UserItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'item_id'], 'required'],
            [['user_id', 'item_id'], 'integer'],
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
            'item_id' => 'Item ID',
        ];
    }
    
    public function getItem(){
        return $this->hasOne(Items::className(), ['id' => 'item_id']);
    }
}
