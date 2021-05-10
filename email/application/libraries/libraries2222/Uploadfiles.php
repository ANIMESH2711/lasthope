<?php 
/*** @author Naveen Rastogi* @copyright Feb-2015*/ 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 /** 
 *
 * @create :: Feb-2015 
 * UploadFiles class for all files/images moved on server 
 * 
 * @access public 
 */
class UploadFiles
{
    public function uploadImages($photo, $name, $path)
    {
        $this->isDirExist($path);
        if ($photo['size'] <= 100 * 1024 * 1024) {
            $_temp_name = $photo['tmp_name'];
            $_pathImg = $path . $name;
            if (move_uploaded_file($_temp_name, $_pathImg)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function createThumbs($pathToImages, $pathToThumbs, $thumbWidth)
    {
        $dir = fopen($pathToImages, 'r');
        $info = pathinfo($pathToImages);
        $fname = $info['basename'];
        $valid_formats = array(
            'jpg',
            'png',
            'gif',
            'bmp');
        if (in_array(strtolower($info['extension']), $valid_formats)) {
            if (strtolower($info['extension']) == 'jpg')
                $img = imagecreatefromjpeg("{$pathToImages}");
            elseif (strtolower($info['extension']) == 'png')
                $img = imagecreatefrompng("{$pathToImages}");
            elseif (strtolower($info['extension']) == 'gif')
                $img = imagecreatefromgif("{$pathToImages}");
            elseif (strtolower($info['extension']) == 'bmp')
                $img = imagecreatefromwbmp("{$pathToImages}");
            else
                $img = imagecreatefromjpeg("{$pathToImages}");
            $width = imagesx($img);
            $height = imagesy($img);
            $new_width = $thumbWidth;
            $new_height = floor($height * ($thumbWidth / $width));
            $tmp_img = imagecreatetruecolor($new_width, $new_height);
            imagecopyresampled($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width,
                $height);
            if (strtolower($info['extension']) == 'jpg')
                imagejpeg($tmp_img, "{$pathToThumbs}{$fname}");
            elseif (strtolower($info['extension']) == 'png')
                imagepng($tmp_img, "{$pathToThumbs}{$fname}");
            elseif (strtolower($info['extension']) == 'gif')
                imagegif($tmp_img, "{$pathToThumbs}{$fname}");
            elseif (strtolower($info['extension']) == 'bmp')
                imagewbmp($tmp_img, "{$pathToThumbs}{$fname}");
            else
                imagejpeg($tmp_img, "{$pathToThumbs}{$fname}");
        }
        fclose($dir);
    }
    
    final function isDirExist($path)
    {
        $list = explode('/',$path);
        $folderPath = array();
        foreach($list as $lt)
        {
            if(is_numeric($lt)) 
            { 
                $folderPath[] = $lt; 
                break; 
            } else 
            { 
                $folderPath[] = $lt; 
            }
        }
        $folderPath = join('/',$folderPath);
        if(!is_dir($folderPath))
        {
            $isDirectory = mkdir($folderPath,0777);
        }
    }
} 
?>