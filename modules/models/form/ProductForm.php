<?php

namespace app\modules\models\form;

use Psy\Util\Json;
use Yii;
use app\models\Product;
use yii\db\Exception;
use yii\web\UploadedFile;

class ProductForm extends Product
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [['name', 'price', 'stock', 'description', 'user_id'], "required"],
            [['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ]);
    }


    public function uploadFile($data)
    {
        $avatarFile = UploadedFile::getInstanceByName('image');
        if ($avatarFile = UploadedFile::getInstanceByName('image')) {
            $uploadPath = Yii::getAlias('@app/modules/models/upload/product/');
            $filename = uniqid() . '.' . $avatarFile->extension;
            $filePath = $uploadPath . $filename;

            if ($avatarFile->saveAs($filePath)) {
                $this->image = $filename;
                return $filename;
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     * @throws Exception
     */
    public function uploadFiles($data)
    {
        $avatarFiles = UploadedFile::getInstancesByName('image');
        if ($avatarFiles) {
            foreach ($avatarFiles as $file) {
                $product = new Product();
                $product->load($data, '');
                $uploadPath = Yii::getAlias('@app/modules/models/upload/product/');
                $filename = uniqid() . '.' . $file->extension;
                $filePath = $uploadPath . $filename;
                if ($file->saveAs($filePath)) {
                    $product->image = $filename;
                    $product->save();
                } else {
                    Yii::error('Lỗi khi lưu file ' . $file->name);
                }
            }
        } else {
            Yii::error('Không có file ảnh được tải lên');
        }
    }

}

