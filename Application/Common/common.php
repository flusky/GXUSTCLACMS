<?php
function check_verify($code){
    return md5($code) == session('verify') ? true : false ;
}

function md6($string,$start=1,$length=10){
    $first=md5($string);
    $sec=md5(substr($first,$start,$length));
    return $sec;
}
