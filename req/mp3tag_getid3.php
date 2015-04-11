<?php
// Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
require_once(realpath(__DIR__).'/../js/getid3/getid3.php');

function getmp3info($mp3path){
 $getID3 = new getID3;
 $ThisFileInfo = $getID3->analyze(realpath($mp3path));
 return array($ThisFileInfo['tags']['id3v2']['title'][0],
                  $ThisFileInfo['tags']['id3v2']['artist'][0],
                  $ThisFileInfo['tags']['id3v2']['album'][0],
                  $ThisFileInfo['tags']['id3v2']['track_number'][0],
                  $ThisFileInfo['tags']['id3v2']['genre'][0],
                  floor($ThisFileInfo['playtime_seconds'] / 60),
                  $ThisFileInfo['playtime_seconds'] % 60
                 );
}
