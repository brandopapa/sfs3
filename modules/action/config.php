<?php

// $Id: config.php 5310 2009-01-10 07:57:56Z hami $

require_once "./module-cfg.php";

include_once "../../include/config.php";
include_once "../../include/sfs_case_PLlib.php";
  //============================================================ 
  $path_str = "school/action/";
  set_upload_path($path_str);  
  //�x�s���[�ɮ׵����m�A�ؿ��v���]��777(�̫ᦳ / )
  $savepath = $UPLOAD_PATH.$path_str;

  //�M�����ڥؿ��۹��m �U�����| (�̫ᦳ / ) 
  $htmpath = $UPLOAD_URL.$path_str;  
  //=========================================================

 // �t�Τɯ�
 include "module-upgrade.php";

//���o�ҲհѼƳ]�w
$m_arr =& get_module_setup("action");
extract($m_arr, EXTR_OVERWRITE);

$PHP_SELF = $_SERVER["PHP_SELF"] ;

 //���Y��
 function ImageResized( $filename_src , $small_image ,$w ,$h ,$GD2=0 ) {

    if ($GD2) {
        ImageCopyResizedTrue( $filename_src , $filename ,$w ,$h) ; 
    }else {    
        $size=$w."x".$h .'>';
        //$exec_str="/usr/bin/convert '-geometry'  $size > '$filename_src' '$small_image' "; //�`�N"��'��
        $exec_str="/usr/bin/convert '-resize'  '$size'  '$filename_src' '$small_image' "; //�`�N"��'��
        //echo $exec_str ;
        exec($exec_str);    
    }
 }    
    /*  Convert image size. true color*/
    //$src        �ӷ��ɮ�
    //$dest        �ت��ɮ�
    //$maxWidth    �Y�ϼe��
    //$maxHeight    �Y�ϰ���
    //$quality    JPEG�~��
    function ImageCopyResizedTrue($src,$dest,$maxWidth,$maxHeight,$quality=100) {

        //�ˬd�ɮ׬O�_�s�b
        if (file_exists($src)  && isset($dest)) {

            $destInfo  = pathInfo($dest);
            $srcSize   = getImageSize($src); //���ɤj�p
            $srcRatio  = $srcSize[0]/$srcSize[1]; // �p��e/��
            $destRatio = $maxWidth/$maxHeight;
            

            if ($srcSize[0] <= $maxWidth) {   //���j��̤j�e��

                exit();
            }    
                            
            if ($destRatio > $srcRatio) {
                $destSize[1] = $maxHeight;
                $destSize[0] = $maxHeight*$srcRatio;
            }
            else {
                $destSize[0] = $maxWidth;
                $destSize[1] = $maxWidth/$srcRatio;
            }


            //GIF �ɤ��䴩��X�A�]���NGIF�নJPEG
            if ($destInfo['extension'] == "gif") $dest = substr_replace($dest, 'jpg', -3);

            //�إߤ@�� True Color ���v��
            $destImage = imageCreateTrueColor($destSize[0],$destSize[1]);

            //�ھڰ��ɦWŪ������
            switch ($srcSize[2]) {
                case 1: $srcImage = imageCreateFromGif($src); break;
                case 2: $srcImage = imageCreateFromJpeg($src); break;
                case 3: $srcImage = imageCreateFromPng($src); break;
                default: return false; break;
            }

            //�����Y��
            ImageCopyResampled($destImage, $srcImage, 0, 0, 0, 0,$destSize[0],$destSize[1],
                                $srcSize[0],$srcSize[1]);

            //��X����
            switch ($srcSize[2]) {
                case 1: case 2: imageJpeg($destImage,$dest,$quality); break;
                case 3: imagePng($destImage,$dest); break;
            }
            return true;
        }
        else {
            return false;
        }
    }
?>
