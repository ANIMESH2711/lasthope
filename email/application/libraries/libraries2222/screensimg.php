<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class screensimg {

    public function get_screen_image(array $file_name = array()) {
        /*
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $basePath = SCREEN_BASE_PATH;
            if (!empty($file_name) AND is_array($file_name)) {
                $title = image_folder_name($file_name['title']);
                if (!is_dir($basePath . $file_name['user_id'])) {
                    $folderPath = $basePath . $file_name['user_id'];
                    mkdir($folderPath, 0777);
                    $basePath = $basePath;
                } else {
                    $basePath = $basePath;
                }
            }
            $path = strtolower($basePath . $file_name['user_id'] .'/' .$title .'_' . time() . ".png");
            $im = imagegrabscreen();
            imagejpeg($im, $path, 75);
            imagedestroy($im);
            return true;
        } else {
            return false;
        }
        */
        return false;
    }
}
