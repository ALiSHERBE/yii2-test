<?php

namespace app\models;

use creocoder\nestedsets\NestedSetsBehavior;

/**
 * This is the model class for table "{{%web_brands}}".
 *
 * @property int $id
 * @property string $title
 * @property int $lft
 * @property int $rgt
 * @property int $depth
 */
class Brand extends \yii\db\ActiveRecord
{

	public $brand;

	/**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%web_brands}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['lft', 'rgt', 'depth', 'brand'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['lft', 'rgt', 'depth'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'depth' => 'Depth',
        ];
    }

	public function behaviors() {
		return [
			'tree' => [
				'class' => NestedSetsBehavior::className(),
			],
		];
	}

	public function transactions()
	{
		return [
			self::SCENARIO_DEFAULT => self::OP_ALL,
		];
	}

	public static function find()
	{
		return new BrandQuery(get_called_class());
	}

	public function getParent()
	{
		return $this->parents(1)->one();
	}
}
