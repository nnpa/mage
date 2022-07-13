<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Items".
 *
 * @property int $id
 * @property string $name
 * @property int $cost
 * @property string $type
 * @property string $description
 * @property int $level
 * @property int $damage
 * @property string $img
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
 * @property int $defence
 * @property int $hp
 * @property int $mp
 * @property int $need_level
 * @property int $need_strength
 * @property int $need_intuition
 * @property int $need_dexterity
 * @property int $need_endurance
 */
class Items extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'cost', 'type', 'description', 'level', 'damage', 'img', 'strength', 'intuition', 'dexterity', 'endurance', 'intelligence', 'mental', 'fire', 'woter', 'earth', 'air', 'defence', 'hp', 'mp', 'need_level', 'need_strength', 'need_intuition', 'need_dexterity', 'need_endurance'], 'required'],
            [['cost', 'level', 'damage', 'strength', 'intuition', 'dexterity', 'endurance', 'intelligence', 'mental', 'fire', 'woter', 'earth', 'air', 'defence', 'hp', 'mp', 'need_level', 'need_strength', 'need_intuition', 'need_dexterity', 'need_endurance'], 'integer'],
            [['description'], 'string'],
            [['name', 'type', 'img'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'cost' => 'Cost',
            'type' => 'Type',
            'description' => 'Description',
            'level' => 'Level',
            'damage' => 'Damage',
            'img' => 'Img',
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
            'defence' => 'Defence',
            'hp' => 'Hp',
            'mp' => 'Mp',
            'need_level' => 'Need Level',
            'need_strength' => 'Need Strength',
            'need_intuition' => 'Need Intuition',
            'need_dexterity' => 'Need Dexterity',
            'need_endurance' => 'Need Endurance',
        ];
    }
}
