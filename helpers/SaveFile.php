<?php

namespace app\helpers;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

class SaveFile
{
    public function saveFile($file_temp, array $file_mime_type, array $file_extension, array $field, $keterangan, $model, $storage, $path = NULL)
    {
        
        if ($this->getMimeType($file_temp->tempName, $file_mime_type) && $this->getExtension($file_temp->tempName, $file_temp->name, $file_extension) && $file_temp->size <= 15728640) {
            $nama_file = hash('sha256', bin2hex(random_bytes(strlen(preg_replace('/[^A-Za-z0-9.-]/', '_', $file_temp->baseName)))));
            $file = $nama_file . $this->getExtension($file_temp->tempName, $file_temp->name, $file_extension);
            $model = "\\app\\models\\{$model}";
            $modelFile = new $model;
            $modelFile->nama_file_asli = $file_temp->baseName . '.' . $file_temp->extension;
            $modelFile->mime_type = FileHelper::getMimeType($file_temp->tempName, null, true);
            $modelFile->nama_file = $file;
            $modelFile->keterangan = $keterangan;
            foreach ($field as $key => $field) {
                $modelFile->$key = $field;
            }

            if ($modelFile->save(false)) {
                
                $stream = fopen($file_temp->tempName, 'r+');
                Yii::$app->$storage->writeStream($path . $file, $stream, ['ContentType' => $modelFile->mime_type]);
                
                fclose($stream);

                if (Yii::$app->$storage->has($path . $file)) {
                    return true;

                }
                return false;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getMimeType($file, array $file_mime_type)
    {
        $mimeType = FileHelper::getMimeType($file, null, true);
        $result = in_array($mimeType, $file_mime_type);

        return $result;
    }

    public function getExtension($file, $nama_file, array $file_extension)
    {
        $mimeType = FileHelper::getMimeType($file, null, true);
        $extension = FileHelper::getExtensionsByMimeType($mimeType);
        $extension_ = strrchr($nama_file, ".");

        if (in_array($extension, $file_extension)) {
            return $extension;
        } elseif (in_array($extension_, $file_extension)) {
            return $extension_;
        }

        return false;
    }
}
