<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\data\Pagination;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%web_cars}}".
 *
 * @property int $id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string $price
 * @property string $phone
 * @property string|null $mileage
 * @property int $main_photo_id
 * @property int $model_id
 * @property int $brand_id
 * @property int $user_id
 */
class Car extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return '{{%web_cars}}';
	}

	public function getPhotos()
	{
		return $this->hasMany(Photo::className(), ['car_id' => 'id']);
	}

	public function getBrand()
	{
		return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
	}

	public function getModel()
	{
		return $this->hasOne(Brand::className(), ['id' => 'model_id']);
	}

	public function getOptions()
	{
		return $this->hasMany(Option::className(), ['id' => 'option_id'])->viaTable('web_car_option', ['car_id' => 'id']);
	}

	public function behaviors()
	{
		return [
			[
				'class' => TimestampBehavior::className(),
				'createdAtAttribute' => 'created_at',
				'updatedAtAttribute' => 'updated_at',
				'value' => new Expression('NOW()'),
			],
		];
	}

    /**
     * {@inheritdoc}
     */
    public function rules()
    {

	    return [
		    [['price', 'phone', 'brand_id', 'model_id'], 'required'],
		    [['price', 'phone', 'mileage'], 'string', 'max' => 255],
		    [['main_photo_id', 'model_id', 'brand_id', 'user_id'], 'integer'],
		    [['price', 'phone', 'mileage'], 'trim'],
		    [['created_at', 'updated_at'], 'safe'],
//		    [['created_at'], 'default', 'value' => date('Y-m-d H:i:s')],
	    ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
            'price' => 'Цена',
            'phone' => 'Телефон',
	        'mileage' => 'Пробег',
	        'main_photo_id' => 'Главное фото',
            'model_id' => 'Модель',
            'brand_id' => 'Марка',
            'user_id' => 'Создал',
        ];
    }

	public static function getAll($pageSize = 5)
	{
		// build a DB query to get all cars
		$query = Car::find();

		// get the total number of cars (but do not fetch the car data yet)
		$count = $query->count();

		// create a pagination object with the total count
		$pagination = new Pagination(['totalCount' => $count, 'pageSize'=>$pageSize]);

		// limit the query using the pagination and retrieve the cars
		$cars = $query->offset($pagination->offset)
			->orderBy(['id' => SORT_DESC])
			->limit($pagination->limit)
			->all();

		$data['cars'] = $cars;
		$data['pagination'] = $pagination;

		return $data;
	}

	public function getImage()
	{
		if (!empty($this->main_photo_id)){
			foreach ($this->photos as $image){
				if ($this->main_photo_id == $image->id){
					return '/'.$image->smFolder . $image->file;
				}
			}
		} else if(isset($this->photos[0])){
			return '/uploads/146x/' . $this->photos[0]->file;
		}

		return '/uploads/no-image.jpg';
	}

	public function getLgImage()
	{
		if (!empty($this->main_photo_id)){
			foreach ($this->photos as $image){
				if ($this->main_photo_id == $image->id){
					return '/' . $image->lgFolder . $image->file;
				}
			}
		} else if(isset($this->photos[0])){
			return '/uploads/720x/' . $this->photos[0]->file;
		}

		return '/uploads/no-image.jpg';
	}

	public function getSmImage()
	{
		$array = [];
		if (!empty($this->main_photo_id)){
			foreach ($this->photos as $image){
				if ($this->main_photo_id != $image->id){
					$array[] = '/'. $image->smFolder . $image->file;
				}
			}
		} else {
			foreach ($this->photos as $key => $image){
				if ($key == 0){
					continue;
				}
				$array[] = '/'. $image->smFolder . $image->file;
			}
		}

		return $array;
	}

	public function getSelectedOption()
	{
		$selectedOptions = $this->getOptions()->select('id')->asArray()->all();
		return ArrayHelper::getColumn($selectedOptions, 'id');
	}

	public function saveOptions($selectOptions)
	{
		if (is_array($selectOptions)){
			$this->clearCurrentOptions();

			foreach($selectOptions as $option_id) {
				$option = Option::findOne($option_id);
				$this->link('options', $option);
			}
		}
	}

	public function clearCurrentOptions()
	{
		CarOption::deleteAll(['car_id' => $this->id]);
	}
}
