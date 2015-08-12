<?php

return [
    //合作身份者id，以2088开头的16位纯数字。
    'partner_id' => '2088901744998960',

    //卖家支付宝帐户。
    'seller_id' => 'ydysedu@126.com',
    
    // 安全检验码，以数字和字母组成的32位字符。
    'key' => 'q8brccax0hd67h1gal8unwbim608w5qb',

    //签名方式
    'sign_type' => 'MD5',

    //ca证书路径地址，用于curl中ssl校验
    //请保证cacert.pem文件在当前文件夹目录中
    'cacert' => getcwd() . DIRECTORY_SEPARATOR . 'cacert.pem',

    //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
    'transport' => 'http'
];
