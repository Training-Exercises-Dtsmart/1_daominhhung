<?php
namespace app\modules\models;

use yii\base\Model;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;
    public function rules(): array
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, pdf', 'maxSize' => 1024 * 1024 * 5],
        ];
    }
    public function upload()
    {
        if ($this->validate()) {
            $filePath = 'uploads/' . $this->file->baseName . '.' . $this->file->extension;
            return $this->file->saveAs($filePath);
        } else {
            return false;
        }
    }
}