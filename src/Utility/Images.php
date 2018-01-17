<?php

namespace App\Utility;

class Images
{
    public static function convertImage($originalImage, $outputImage, $quality)
    {
        try {
            // jpg, png, gif or bmp?
            $exploded = explode('.', $originalImage);
            $ext = $exploded[count($exploded) - 1];

            if (preg_match('/jpg|jpeg/i', $ext))
                $imageTmp = imagecreatefromjpeg($originalImage);
            else if (preg_match('/png/i', $ext))
                $imageTmp = imagecreatefrompng($originalImage);
            else if (preg_match('/gif/i', $ext))
                $imageTmp = imagecreatefromgif($originalImage);
            else if (preg_match('/bmp/i', $ext))
                $imageTmp = imagecreatefrombmp($originalImage);
            else
                return 0;

            // quality is a value from 0 (worst) to 100 (best)
            imagejpeg($imageTmp, $outputImage, $quality);
            imagedestroy($imageTmp);
        }
        catch(\Exception $ex) {

        }

        return 1;
    }

    public static function resizeImage($filename, $to_filename)
    {
        list($width, $height) = getimagesize($filename);

        if ($height > 800) {
            $newwidth = (800 / $height) * $width;
            $newheight = 800;
        }
        else {
            $newheight = $height;
        }

        # wider
        if ($width > 600) {
            $newheight = (600 / $width) * $height;
            $newwidth = 600;
        }
        else {
            $newwidth = $width;
        }

        $thumb = imagecreatetruecolor($newwidth, $newheight);
        $source = imagecreatefromjpeg($filename);

        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        imagejpeg($thumb, $to_filename);
    }

    public static function thumbImage($filename, $to_filename)
    {
        list($width, $height) = getimagesize($filename);

        if ($height > 200) {
            $newwidth = (200 / $height) * $width;
            $newheight = 200;
        }

        # wider
        if ($width > 150) {
            $newheight = (150 / $width) * $height;
            $newwidth = 150;
        }

        $thumb = imagecreatetruecolor($newwidth, $newheight);
        $source = imagecreatefromjpeg($filename);

        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        imagejpeg($thumb, $to_filename);
    }

}