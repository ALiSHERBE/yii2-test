<?php

namespace app\models;

/**
 * This is the model class for table "{{%web_car_option}}".
 *
 * @property int $id
 * @property int $car_id
 * @property int $option_id
 */
class CarOption extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%web_car_option}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['car_id', 'option_id'], 'required'],
            [['car_id', 'option_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'car_id' => 'Car ID',
            'option_id' => 'Option ID',
        ];
    }
}
