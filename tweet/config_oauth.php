<?php
// Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
require('../conf/tweet.php');
require('twitteroauth.php');
libxml_use_internal_errors(true);

if($_SESSION['oauth_token']===NULL && $_SESSION['oauth_token_secret']===NULL){

 $to = new TwitterOAuth($consumer_key,$consumer_secret);
 $tok = $to->getRequestToken($myurl.'callback.php');
 $token = $tok['oauth_token'];
 $_SESSION['request_token'] = $token;
 $_SESSION['request_token_secret'] = $tok['oauth_token_secret'];

 require_once('lib_config_oauth.php');
 die();
} else {
 $access_token = $_SESSION['oauth_token'];
 $access_token_secret = $_SESSION['oauth_token_secret'];

 $_SESSION['consumer_key'] = $consumer_key;
 $_SESSION['consumer_secret'] = $consumer_secret;
 $_SESSION['access_token'] = $access_token;
 $_SESSION['access_token_secret'] = $access_token_secret;

 $touser = new TwitterOAuth($consumer_key,$consumer_secret,$access_token,$access_token_secret);
 $requser = $touser->OAuthRequest('https://api.twitter.com/1.1/account/verify_credentials.json','GET');
 $jsonuser = json_decode($requser, true, 512, JSON_BIGINT_AS_STRING);
 $_SESSION['oa_user_id'] = (string)$jsonuser['id'];
 $_SESSION['oa_user_name'] = (string)$jsonuser['name'];
 $_SESSION['oa_screen_name'] = (string)$jsonuser['screen_name'];
 $_SESSION['oa_statuses_count'] = (string)$jsonuser['statuses_count'];
 $_SESSION['oa_description'] = (string)$jsonuser['description'];
 $_SESSION['oa_location'] = (string)$jsonuser['location'];
 $_SESSION['oa_url'] = (string)$jsonuser['url'];
 $_SESSION['oa_created_at'] = (string)$jsonuser['created_at'];
 $_SESSION['oa_lang'] = (string)$jsonuser['lang'];
 $_SESSION['oa_verified'] = (string)$jsonuser['verified'];
 $_SESSION['oa_protected'] = (string)$jsonuser['protected'];
 $_SESSION['oa_friends_count'] = (string)$jsonuser['friends_count'];
 $_SESSION['oa_followers_count'] = (string)$jsonuser['followers_count'];
 $_SESSION['oa_time_zone'] = (string)$jsonuser['time_zone'];
 $_SESSION['oa_utc_offset'] = (string)$jsonuser['utc_offset'];
 $_SESSION['oa_geo_enabled'] = (string)$jsonuser['geo_enabled'];
 $_SESSION['oa_profile_image_url'] = (string)$jsonuser['profile_image_url'];
 if ($jsonuser['profile_use_background_image'] == 'true') {
  $_SESSION['oa_profile_background_image_url'] = (string)$jsonuser['profile_background_image_url'];
  $_SESSION['oa_profile_background_tile'] = (string)$jsonuser['profile_background_tile'];
 }
 $_SESSION['oa_profile_background_color'] = (string)$jsonuser['profile_background_color'];
 $_SESSION['oa_profile_text_color'] = (string)$jsonuser['profile_text_color'];
 $_SESSION['oa_profile_link_color'] = (string)$jsonuser['profile_link_color'];
 $_SESSION['oa_profile_sidebar_fill_color'] = (string)$jsonuser['profile_sidebar_fill_color'];
 $_SESSION['oa_profile_sidebar_border_color'] = (string)$jsonuser['profile_sidebar_border_color'];

 $to = new TwitterOAuth($consumer_key,$consumer_secret,$access_token,$access_token_secret);
 $req0 = $to->OAuthRequest('https://api.twitter.com/1.1/application/rate_limit_status.json','GET',array('resources'=>'statuses'));
 $json0 = json_decode($req0, true, 512, JSON_BIGINT_AS_STRING);

 if ($json0['resources']['statuses']['/statuses/oembed']['remaining'] < 10){
  $result  = '* API制限に引っかかりそうです';
  $result .= ' statuses/oembed: ';
  $result .= ' remaining:'.$json0['resources']['statuses']['/statuses/oembed']['remaining'];
  $result .= '/limit:'.$json0['resources']['statuses']['/statuses/oembed']['limit'];
  $result .= ' (reset:'.date('Y/m/d H:i:s', $json0['resources']['statuses']['/statuses/oembed']['reset']).')';
  die($result);
 } else {
  $_SESSION['remaining_hits'] = $json0['resources']['statuses']['/statuses/oembed']['remaining'];
 }
}
