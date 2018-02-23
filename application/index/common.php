<?php
    function arr_unique($arr2d){
        foreach ($arr2d as $k=>$v){
            $v = implode(',',$v);   //把数组转换成字符串
            $temp[]=$v;                  //把字符串放进数组,数组会自动开辟下标空间=>成为一个新的数组$temp
        }

        $temp = array_unique($temp); //数组去重,只针对一维数组
        foreach ($temp as $k => $v) {
            //explode(separator,string)本身会返回一个一维数组
            $temp[$k] = explode(',', $v); //将一维数组拼装成二维数组
        }
        return $temp;
    }