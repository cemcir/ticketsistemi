<?php

namespace App\Core\Utilities\FileOperations;


use App\Core\Utilities\Constants\Concrete\TurkishMessage;
use App\Core\Utilities\Results\ErrorDataResult;
use App\Core\Utilities\Results\IDataResult;
use App\Core\Utilities\Results\SuccessDataResult;
// dosya işlemleri için çekirdek sınıf kodları oluşturduk
class Upload
{
    private static array $imageExtensions=['png','bmp','jpeg','pjpeg','jpg','gif'];
    private static array $fileExtensions=['msword','docx','vnd.ms-excel','xlsx','vnd.ms-powerpoint','pdf'];
    private static int $imageSize=20000000;
    private static int $fileSize=20000000;


    public static function ImageUpload($image, $path)
    {
        // Orijinal uzantıyı küçük harf olarak al
        $extension = strtolower($image->getClientOriginalExtension());

        // jfif dosyalarını jpg uzantısı ile kaydet
        if ($extension === 'jfif') {
            $extension = 'jpg';
        }

        // Rastgele isim oluştur
        $name = rand(1, 100000000) . '.' . $extension;

        // Hedef klasör yoksa oluştur
        if (!file_exists(public_path($path))) {
            mkdir(public_path($path), 0755, true);
        }

        $image->move(public_path($path), $name);

        // Yüklenen dosyanın göreli yolu döner (örnek: frontend/images/product/123456.jpg)
        return $path . '/' . $name;
    }

    // Coklu Resim Göndermek İçin Kullanılır
    public static function ManyImageUpload($images,$path):IDataResult
    {
        $data=[];
        foreach ($images as $image) {
            if(!in_array($image->getClientOriginalExtension(),self::$imageExtensions)) {
                return new ErrorDataResult(null,TurkishMessage::FileNotExtensions());
            }
            else if($image->getSize()>self::$imageSize) {
                return new ErrorDataResult(null,TurkishMessage::FileMaxSize());
            }
        }

        foreach ($images as $image) {
            $name=rand(1,100000000).".".$image->getClientOriginalExtension();
            $image->move(public_path($path),$name);
            $data[]=$path."/".$name;
        }
        if(empty($data)) {
            return new ErrorDataResult($data,TurkishMessage::FilePathNotCreated());
        }
        return new SuccessDataResult($data,TurkishMessage::FilePathCreated());
    }

    // Tek Dosya Yüklemek İçin Kullanılır
    public static function FileUpload($file,$path):IDataResult
    {
        if(!in_array($file->getClientOriginalExtension(),self::$fileExtensions)) {
            return new ErrorDataResult(null,TurkishMessage::FileNotExtensions());
        }
        else if($file->getSize()>self::$fileSize) {
            return new ErrorDataResult(null,TurkishMessage::FileMaxSize());
        }

        $name=rand(1,100000000).".".$file->getClientOriginalExtension();
        $upload=$file->move(public_path($path),$name);
        $name=$path."/".$name;

        if($upload) {
            return new SuccessDataResult($name,TurkishMessage::FilePathCreated());
        }
        return new ErrorDataResult([],TurkishMessage::FilePathNotCreated());
    }

}
