<?php 
function currency_format($number,$decimal = 0, $dec_point = '', $thousands_sep = ".", $suffix = '₫'){
    return number_format($number,$decimal,$dec_point,$thousands_sep).$suffix;
}
function format_status($status){
    $list_status = array(
        "0" => "Chờ duyệt",
        "1" => "Công khai",
    );
    if(array_key_exists($status,$list_status)){
        return $list_status[$status];
    }
}
function format_status_product($status){
    $list_status = array(
        "0" => "Hết hàng",
        "1" => "Còn hàng",
    );
    if(array_key_exists($status,$list_status)){
        return $list_status[$status];
    }
}
function format_status_order($status){
    $list_status = array(
        "1" => "Đang xử lý",
        "2" => "Đang vận chuyển",
        "3" => "Hoàn thành",
        "0" => "Đã hủy",
    );
    if(array_key_exists($status,$list_status)){
        return $list_status[$status];
    }
}
function format_created_at($obj,$format="d/m/Y H:i:s"){
    return date_format($obj,$format);
}
