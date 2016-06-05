<?php
define("DSEP",DIRECTORY_SEPARATOR);

function asep($path1,$path2){
   return add_path_separator($path1,$path2);
}

function add_path_separator($path1,$path2){
   return $path1.((mb_substr($path1,-1)==DSEP)?'':DSEP).$path2;
}

function arsep($path1,$path2){
   return add_realpath_separator($path1,$path2);
}

function add_realpath_separator($path1,$path2){
   return realpath($path1).((mb_substr($path1,-1)==DSEP)?'':DSEP).$path2;
}
