<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    |  following language lines contain  default error messages used by
    |  validator class. Some of se rules have multiple versions such
    | as  size rules. Feel free to tweak each of se messages here.
    |
    */

    "accepted"             => " :attribute 必须接受(选中).",
    "active_url"           => " :attribute 不是有效的 URL.",
    "after"                => " :attribute 必须在  :date 之后.",
    "alpha"                => " :attribute 只能包含字母.",
    "alpha_dash"           => " :attribute 只能包含字母、数字和'-'.",
    "alpha_num"            => " :attribute 只能包含字母和数字.",
    "array"                => " :attribute 必须是数组.",
    "before"               => " :attribute 必须在 :date 之前.",
    "between"              => [
        "numeric" => " :attribute 必须在 :min 和 :max 之间.",
        "file"    => " :attribute 文件大小必须在 :min 和 :max kbs.",
        "string"  => " :attribute 字符串长度必须在 :min 和 :max 之间.",
        "array"   => " :attribute 数组长度必须在 :min 和 :max 之间.",
    ],
    "boolean"              => " :attribute 必须是一个布尔值.",
    "confirmed"            => " :attribute 确认项不一致.",
    "date"                 => " :attribute 不是有效日期.",
    "date_format"          => " :attribute 不匹配日期格式 :format.",
    "different"            => " :attribute 和 :or 值不能相同.",
    "digits"               => " :attribute 必须是 :digits 位数字.",
    "digits_between"       => " :attribute 必须是 :min 到 :max 位数字.",
    "email"                => " :attribute 必须是邮箱的邮箱地址.",
    "filled"               => " :attribute 是必输项.",
    "exists"               => " 选的 :attribute 无效.",
    "image"                => " :attribute 必须是图片.",
    "in"                   => " 选择的 :attribute 无效.",
    "integer"              => " :attribute 必须是整数.",
    "ip"                   => " :attribute 必须是有效的IP地址.",
    "max"                  => [
        "numeric" => " :attribute 必须小于 :max.",
        "file"    => " :attribute 文件大小必须小于 :max kb.",
        "string"  => " :attribute 字符串长度必须小于 :max 位.",
        "array"   => " :attribute 数组长度必须小于 :max .",
    ],
    "mimes"                => " :attribute 必须是: :values 类型的文件.",
    "min"                  => [
        "numeric" => " :attribute 最小必须是 :min.",
        "file"    => " :attribute 文件大小最小必须是 :min kbs.",
        "string"  => " :attribute 字符串长度最小必须是 :min 位.",
        "array"   => " :attribute 数组长度最小必须是 :min .",
    ],
    "not_in"               => " 选择的 :attribute 无效.",
    "numeric"              => " :attribute 必须是数字.",
    "regex"                => " :attribute 格式无效.",
    "required"             => " :attribute 是必输项.",
    "required_if"          => "当 :or 值是 :value 时,  :attribute 是必输项 .",
    "required_with"        => "当 :values 存在时,  :attribute 是必输项.",
    "required_with_all"    => "当 :values 存在时,  :attribute 是必输项 when :values is present.",
    "required_without"     => "当 :values 不存在是,  :attribute 是必输项 .",
    "required_without_all" => " :attribute 是必输项 when none of :values are present.",
    "same"                 => " :attribute 和 :or 必须匹配.",
    "size"                 => [
        "numeric" => " :attribute 长度必须是 :size.",
        "file"    => " :attribute 文件大小必须是 :size kbs.",
        "string"  => " :attribute 字符串长度必须是 :size 位.",
        "array"   => " :attribute 数组长度必须是 :size .",
    ],
    "unique"               => " :attribute 已经存在(重复).",
    "url"                  => " :attribute URL格式无效.",
    "timezone"             => " :attribute 必须是有效的时区.",

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using 
    | convention "attribute.rule" to name  lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    |  following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
