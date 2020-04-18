<?php

namespace Db\Mail2dms\func;

/**
 * 查找字符、字符串第n次出现的位置
 *@param string $str	    原始字符串
 *@param string $find	需要查找的字符、字符串
 *@param int    $n		第几次出现的字符、字符串
 *@return int   $count	返回第n次出现的位置
 */
function str_n_pos($str, $find, $n){
    for ($i=1; $i<=$n; $i++){
        $pos = strrpos($str, $find);
        $str = substr($str, 0, $pos);
        $pos_val = $pos;
    }
    $count = $pos_val-1;
    return $count;
}


/**
 * 创建目录
 * @param $aimUrl
 * @return bool
 */
function createDir($aimUrl) {
    $aimUrl = str_replace('', '/', $aimUrl);
    $aimDir = '';
    $arr = explode('/', $aimUrl);
    $result = true;
    foreach ($arr as $str) {
        $aimDir .= $str . '/';
        if (!file_exists($aimDir)) {
            $result = mkdir($aimDir);
        }
    }
    return $result;
}




