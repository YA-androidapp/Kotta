<?php
// Copyright (c) 2014-2016 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.

output_file(arsep($base_dir,$_REQUEST['output_path']));

function output_file($path){
   if (!file_exists($path)) {
      die('Error: File does not exist ( '.$path.' )');
  }
  if (!($fp = fopen($path, 'r'))) {
      die('Error: Cannot open the file ( '.$path.' )');
  }
  fclose($fp);
  if (($content_length = filesize($path)) == 0) {
      die('Error: File size is 0 ('.$path.')');
  }

  header('Content-Disposition: inline; filename=\''.basename($path).'\'');
  header('Content-Length: '.$content_length);
  header('Content-Type: '.get_mime_type($path));
 // header('Content-Type: application/octet-stream');
 // header('Content-Type: audio/mpeg');

  if (!readfile($path)) {
      die('Cannot read the file('.$path.')');
  }
}

function get_mime_type($path){
   $finfo = finfo_open(FILEINFO_MIME_TYPE);
   $mimeType = finfo_file($finfo, $path);
   finfo_close($finfo);

   return $mimeType;
}
