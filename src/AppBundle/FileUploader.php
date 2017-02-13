<?php
/**
 * Created by PhpStorm.
 * User: Maxime
 * Date: 13/02/2017
 * Time: 15:15
 */

namespace AppBundle;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        var_dump($this->targetDir);
        var_dump($fileName);

        $file->move($this->targetDir, $fileName);

        return $fileName;
    }
}