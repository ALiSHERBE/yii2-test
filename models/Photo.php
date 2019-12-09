<?php

namespace app\models;

use Yii;
use yii\db\Exception;
use yii\imagine\Image;

/**
 * This is the model class for table "{{%web_photos}}".
 *
 * @property int $id
 * @property int $car_id
 * @property string $file
 */
class Photo extends \yii\db\ActiveRecord
{
	public $image;

	public function getAssociatedArray()
	{
		if($this->_associatedArray === null){
			$this->_associatedArray = $this->getAssociatedProducts()->select('id')->column();
		}
		return $this->_associatedArray;
	}

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%web_photos}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
    	// TODO  car_id required
        return [
            [['car_id'], 'integer'],
	        [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, gif', 'maxFiles' => 3, 'on' => 'add'],
	        [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif', 'maxFiles' => 2, 'on' => '1'],
	        [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif', 'maxFiles' => 1, 'on' => '2'],
        ];
    }

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'car_id' => 'Машина',
			'file' => 'Изображение',
		];
	}

	public function upload($currentImages, $carId)
	{
		if ($this->validate()) {
			$this->deleteCurrentImages($currentImages);
			$data = $this->saveImage($carId);
			return boolval($this->saveDB($data));
		} else {
			// maxFiles поставить 2 то работает, но это не совпадает по логике
			// можно решение?)
			Yii::$app->session->setFlash('success', "Странное поведение Yii2, попробуйте удалить еще 1 файл и сможете загрузить 2 шт.");
		}
	}

	public function saveDB($data)
	{
		try {
			return Yii::$app->db->createCommand()->batchInsert(self::tableName(), ['file', 'car_id'], $data)->execute();
		} catch (Exception $e) {
			return false;
		}
	}

	private static function getFolder()
	{
		return Yii::getAlias('@web') . Yii::getAlias('@orImage') . '/';
	}

	public static function getLgFolder()
	{
		return Yii::getAlias('@web') . Yii::getAlias('@lgImage') . '/';
	}

	public static function getSmFolder()
	{
		return Yii::getAlias('@web') . Yii::getAlias('@smImage') . '/';
	}

	private function generateFileName($key)
	{
		return strtotime('now').'_'.Yii::$app->getSecurity()->generateRandomString(8) . '.' . $this->file[$key]->extension;
	}

	/**
	 * if none use getFolder, convert static method
	 */
	public function deleteCurrentImages($currentImages)
	{
		foreach ($currentImages as $currentImage) {
			if($this->fileExists($currentImage['file']))
			{
				unlink(self::getFolder() . $currentImage['file']);
			}
		}
	}

	public function deleteCurrentImage($mage)
	{
		if (file_exists(self::getSmFolder() . $mage['file'])){
			unlink(self::getSmFolder() . $mage['file']);
		}
		if (file_exists(self::getLgFolder() . $mage['file'])){
			unlink(self::getLgFolder() . $mage['file']);
		}

	}

	public function fileExists($currentImage)
	{
		if(!empty($currentImage) && $currentImage != null)
		{
			return file_exists(self::getFolder() . $currentImage);
		}
	}

	/**
	 * @return array
	 */
	private function saveImage($carId)
	{
		$arrayFileNames = [];

		foreach ($this->file as $key => $file) {
			$fileName = $this->generateFileName($key);
			$arrayFileNames[] = ['file' => $fileName, 'car_id' => $carId];
			$file->saveAs(self::getFolder() . $fileName);
			$this->imageThumbnail($fileName);
		}
		$this->deleteCurrentImages($arrayFileNames);

		return $arrayFileNames;
	}

	private function imageThumbnail($fileName)
	{
		$image = self::getFolder(). $fileName;
		// Обрежет по ширине на 600px, по высоте пропорционально
		// $imageAspect = Image::resize($image, 720, 540);

		Image::$thumbnailBackgroundColor = 'FFF';
		Image::thumbnail( $image, 720, 540, $mode = \Imagine\Image\ManipulatorInterface::THUMBNAIL_INSET )
			->save(self::getLgFolder() . $fileName, ['quality' => 90]);

		Image::thumbnail( $image, 146, 106, $mode = \Imagine\Image\ManipulatorInterface::THUMBNAIL_INSET )
			->save(self::getSmFolder() . $fileName, ['quality' => 90]);
	}


}
