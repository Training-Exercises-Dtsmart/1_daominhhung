<?php

namespace app\modules\models\form;

use Yii;
use app\models\Product;
use yii\db\Exception;
use yii\web\UploadedFile;

class ProductForm extends Product
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [['name', 'price', 'stock', 'description', 'user_id', 'category_id'], "required"],
            [['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ]);
    }

    /**
     * @throws Exception
     */
    public function uploadFiles($data)
    {
        $avatarFiles = UploadedFile::getInstancesByName('image');

        $uploadPath = Yii::getAlias('@app/modules/models/upload/product/');
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $oldImages = explode(',', $this->image);
        $uploadedFiles = [];

        if (!empty($avatarFiles)) {
            foreach ($avatarFiles as $file) {
                $filename = uniqid() . '.' . $file->extension;
                $filePath = $uploadPath . $filename;
                if ($file->saveAs($filePath)) {
                    $uploadedFiles[] = $filename;
                } else {
                    return false;
                }
            }
            $this->image = implode(',', $uploadedFiles);
        }

        if ($this->save()) {
            if (!empty($uploadedFiles)) {
                foreach ($oldImages as $oldImage) {
                    $oldFilePath = $uploadPath . $oldImage;
                    if (is_file($oldFilePath) && file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
            }
            return true;
        }
        return false;
    }
}
