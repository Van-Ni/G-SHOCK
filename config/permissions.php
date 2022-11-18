<?php 

return [
    'access' => [
        'list_product' => 'list_product',
        'add_product' => 'add_product',
        'delete_product' => 'delete_product',
        'update_product' => 'update_product',
        'list_cat_pr' => 'list_cat_pr',
        'add_cat_pr' => 'add_cat_pr',
        'update_cat_pr' => 'update_cat_pr',
        'delete_cat_pr' => 'delete_cat_pr',
    ],
    "module_table" => [
        'Sản phẩm' => 'product',
         'Danh mục sản phẩm'=>'cat_pr',
    ],
    "module_children" => [
        'Danh sách' => 'list',
        'Thêm' => 'add',
        'Cập nhật' => 'update',
        'Xóa' => 'delete',
    ]
    
];

?>