<?php

namespace common\models;

use common\libraries\CustomWidgets;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "image".
 *
 * @property int $id
 * @property string|null $model user, order, product, etc.
 * @property int|null $model_id
 * @property string|null $category
 * @property string|null $filename
 * @property string|null $image_src
 * @property string|null $thumb_src
 * @property string|null $description
 * @property string|null $create_time
 * @property string|null $update_time
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile[]|null
     */
    public $imageFiles;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model_id'], 'integer'],
            [['create_time', 'update_time', 'imageFiles'], 'safe'],
            [['model', 'category', 'filename', 'image_src', 'thumb_src', 'description'], 'string', 'max' => 255],
//            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'model' => Yii::t('app', 'Model'),
            'model_id' => Yii::t('app', 'Model ID'),
            'category' => Yii::t('app', 'Category'),
            'filename' => Yii::t('app', 'Filename'),
            'image_src' => Yii::t('app', 'Image Src'),
            'thumb_src' => Yii::t('app', 'Thumb Src'),
            'description' => Yii::t('app', 'Description'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    public static function uploadImages($model, $model_id, $current_image_url, $path = 'uploads/feed/') {
        $imageModel = new Image(); //for validating $imageFiles

        $directoryPath = '@api/web/' . $path;
        $uploadPath = Yii::getAlias($directoryPath);

        // Check if the upload directory exists or create it
        if (!file_exists($uploadPath) && !mkdir($uploadPath, 0777, true)) {
            return CustomWidgets::returnFail('Failed to create upload directory');
        }

        $imageModel->imageFiles = UploadedFile::getInstancesByName('images'); // Fetch uploaded files

        // Validate uploaded files against model rules
        if (!$imageModel->validate()) {
            // Validation failed, return error message
            $errors = $imageModel->getErrors('imageFiles');
            return CustomWidgets::returnFail('Validation error: ' . reset($errors));
        }

        // Validate if files were uploaded
        if (empty($imageModel->imageFiles)) {
            return CustomWidgets::returnFail('No files uploaded');
        }

        if (count($imageModel->imageFiles) > 6) {
            return CustomWidgets::returnFail('Maximum allowed: 6 images');
        }

        $uploadedFiles = [];

        foreach ($imageModel->imageFiles as $index => $uploadedFile) {
            $filename = uniqid() . '.' . $uploadedFile->extension;
            $destination = $uploadPath . $filename;

            if ($uploadedFile->error !== UPLOAD_ERR_OK) {
                return CustomWidgets::returnFail('File upload error: ' . $index . ' - Error: ' . $uploadedFile->error);
            }

            // Move the uploaded file to the destination
            if ($uploadedFile->saveAs($destination)) {
                $uploadedFiles[] = $filename;
            } else {
                return CustomWidgets::returnFail('Failed to save file');
            }
        }

        return self::createEntries($uploadedFiles, $model, $model_id, $current_image_url, $path);
    }

    public static function createEntries($filenames, $model, $model_id, $current_image_url, $path = '') {
        $path = str_replace('@', '', $path);

        //if current_image_url is passed and there is only 1 image, replace that image
        if ($current_image_url != null && count($filenames) == 1) {
            $image = Image::find()
                ->where(['image_src' => $current_image_url])
                ->one();

            if (isset($image)) {
                $image->filename = $filenames[0];
                $image->image_src = $path . $filenames[0];
                $image->save(false);
                return CustomWidgets::returnSuccess([$image], 'Updated');
            }
        }

        $models = [];
        foreach ($filenames as $filename) {
            $image = new Image();
            $image->model = $model;
            $image->model_id = $model_id;
            $image->filename = $filename;
            $image->image_src = $path . $filename;
            $image->save(false);
            $models[] = $image;
        }
        return CustomWidgets::returnSuccess($models, 'Uploaded');
    }

    public static function readImage($model, $model_id, $category = null, $categorized = false) {
        $models = Image::find()
            ->where(['model' => $model])
            ->andWhere(['model_id' => $model_id])
            ->orderBy(['id' => SORT_DESC]);

        if ($category != null) {
            $models = $models->andWhere(['category' => $category]);
        }

        $models = $models->all();

        if (count($models) < 1) {
            return CustomWidgets::returnFail('no images found');
        }

        $results = [];
//        $baseUrl = Preferences::readPreference('client_app', 'image_url') ?? '';
        foreach ($models as $model) {
            // Check if image_src starts with "http" or "https"
            $imageSrc = $model->image_src;
            if (!preg_match('/^https?:\/\//', $imageSrc)) {
                $imageSrc = CustomWidgets::apiUrl() . '/' . $imageSrc; // Prepend base URL if it doesn't start with http/https
            }

            if ($categorized) {
                $cat = $model->category;
                if (array_key_exists($cat, $results)) {
                    $results[$cat][] = $imageSrc;
                } else {
                    $results[$cat] = [$imageSrc];
                }
            } else {
                $results[] =  $imageSrc;
            }
        }
        return CustomWidgets::returnSuccess($results);
    }

    // Example Yii2 controller action to delete a file
    public static function deleteFile($filename, $path)
    {
        $model = Image::find()
            ->where(['image_src' => $filename])
            ->one();

        if (!isset($model)) {
            return CustomWidgets::returnFail('cannot find image');
        }

        $realPath = Yii::getAlias($filename);

        // Check if the file exists before attempting to delete it
        if (file_exists($realPath)) {
            // Attempt to delete the file
            if (unlink($realPath)) {
                $model->delete();
                return CustomWidgets::returnSuccess([], 'File deleted successfully');
            } else {
                return CustomWidgets::returnFail('Unable to delete this file');
            }
        } else {
            return CustomWidgets::returnFail('File does not exist');
        }
    }

}
