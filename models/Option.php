<?php

namespace app\models;

use yii\data\Pagination;

/**
 * This is the model class for table "{{%web_options}}".
 *
 * @property int $id
 * @property string $title
 * @property int $parent_id
 */
class Option extends \yii\db\ActiveRecord
{
	public static $result = [];

	/**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%web_options}}';
    }

    public function getParent()
    {
	    return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }

	public function getCars()
	{
		return $this->hasMany(Car::className(), ['id' => 'car_id'])->viaTable('web_car_option', ['option_id' => 'id']);
	}

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['parent_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'parent_id' => 'Родитель',
        ];
    }

	public static function getAll($pageSize = 5)
	{
		$query = self::find();

		$count = $query->count();

		$pagination = new Pagination(['totalCount' => $count, 'pageSize'=>$pageSize]);

		$options = $query->offset($pagination->offset)
			->orderBy(['id' => SORT_DESC])
			->limit($pagination->limit)
			->all();

		$data['options'] = $options;
		$data['pagination'] = $pagination;

		return $data;
	}

	public static function tree($condition = false)
	{
		$data = Option::find();
		if ($condition !== false){
			$data = $data->where(['parent_id' => null]);
		}

		$data = $data->indexBy('id')->asArray()->all();
		$tree = [];

		foreach ($data as $id => &$node) {
			if (!$node['parent_id']) {
				$tree[$id] = &$node;
			} else {
				$data[$node['parent_id']]['children'][$node['id']] = &$node;
			}
		}

		return $tree;
	}

	public static function giveForField($tree, $depth = 0, $parent_id = null) {
		foreach ($tree as $item) {
			$dash = ($item['parent_id'] == 0) ? '' : str_repeat(' - ', $depth);
			self::$result[$item['id']] = $dash.$item['title'];
			if ($item['parent_id'] == $parent_id) {
				// reset $depth
				$depth = 0;
			}
			if (isset($item['children'])) {
				self::giveForField($item['children'], ++$depth, $item['parent_id']);
			}
		}
		return self::$result;
	}

	public function clearCurrentOptions()
	{
		CarOption::deleteAll(['option_id' => $this->id]);
	}
}
