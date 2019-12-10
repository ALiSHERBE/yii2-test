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
			'htmlTree'=>[
				'class' => \wokster\treebehavior\NestedSetsTreeBehavior::className(),
				'labelAttribute' => 'title',
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

	public static function toTree($collection)
	{
		// $collection = Brand::find()->orderBy(['lft' => SORT_ASC])->asArray()->all();
		// Trees mapped
		$trees = array();
		$l = 0;

		if (count($collection) > 0) {
			// Node Stack. Used to help building the hierarchy
			$stack = array();

			foreach ($collection as $node) {
				$item = $node;
				$item['children'] = array();

				// Number of stack items
				$l = count($stack);

				// Check if we're dealing with different levels
				while($l > 0 && $stack[$l - 1]['depth'] >= $item['depth']) {
					array_pop($stack);
					$l--;
				}

				// Stack is empty (we are inspecting the root)
				if ($l == 0) {
					// Assigning the root node
					$i = count($trees);
					$trees[$i] = $item;
					$stack[] = & $trees[$i];
				} else {
					// Add node to parent
					$i = count($stack[$l - 1]['children']);
					$stack[$l - 1]['children'][$i] = $item;
					$stack[] = & $stack[$l - 1]['children'][$i];
				}
			}
		}

		return $trees;
	}
}
