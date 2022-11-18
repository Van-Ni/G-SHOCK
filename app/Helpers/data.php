<?php

use Illuminate\Http\Response;

function data_tree($category, $parent_id = 0, $level = 0)
{
    $result = [];
    foreach ($category as $item) {
        if ($item['parent_id'] == $parent_id) {
            $item->level = $level;
            $result[] = $item;
            // unset($category[$item['id']]);
            $child = data_tree($category, $item['id'], $level + 1);
            $result = array_merge($result, $child);
        }
    }
    return $result;
}
function re_index($arr, $start_index = 1)
{
    $arr = array_combine(
        range(
            $start_index,
            count($arr) + ($start_index - 1)
        ),
        array_values($arr)
    );
    return $arr;
}
function show_arr($arr)
{
    echo "<pre>";
    print_r($arr);
    echo "<pre>";
}
function data_tree_cat($category, $parent_id = 0, $ulElement = "", $slug_parent = "")
{
    //=============
    //load class ul 
    //=============
    $class = !empty($ulElement) ? $ulElement : "list-item";
    echo "<ul class='{$class}'>";
    foreach ($category as $item) {
        if ($item['parent_id'] == $parent_id) {
            //=============
            //tạo đường link
            //=============
            $slug_parent = $slug_parent;
            $href = url("danh-muc/{$slug_parent}{$item['slug']}");
            echo "<li><a href='{$href}'>{$item['cat_name']}</a>";
            //=============
            //xóa item vừa lặp
            //=============
            unset($category[$item['id']]);
            //=============
            // tạo icon cho parent cat
            //=============
            if ($item['parent_id'] == 0) {
                echo "<i class='fa fa-angle-right arrow-cat' aria-hidden='true'></i>";
            }
            data_tree_cat(
                $category,
                $item['id'],
                $ulElement = "sub-menu",
                $item['slug'] . "/"
            );
        }
    }
    echo "</li>";
    echo "</ul>";
}

function data_tree_cat_respon($category, $parent_id = 0, $ulElement = "", $slug_parent = "")
{
    //=============
    //load class ul 
    //=============
    $class = !empty($ulElement) ? $ulElement : "main-menu-respon";
    echo "<ul id='{$class}'>";
    foreach ($category as $item) {
        if ($item['parent_id'] == $parent_id) {
            //=============
            //tạo đường link
            //=============
            $slug_parent = $slug_parent;
            $href = url("danh-muc/{$slug_parent}{$item['slug']}");
            echo "<li><a href='{$href}'>{$item['cat_name']}</a>";
            //=============
            //xóa item vừa lặp
            //=============
            unset($category[$item['id']]);
            //=============
            // tạo icon cho parent cat
            //=============
            //=============
            // tạo icon cho parent cat
            //=============
            if ($item['parent_id'] == 0) {
                echo "<span class='fa fa-angle-right arrow'></span>";
            }
            data_tree_cat(
                $category,
                $item['id'],
                $ulElement = "sub-menu",
                $item['slug'] . "/"
            );
        }
    }
    echo "</li>";
    echo "</ul>";
}
function active_module($module)
{
    if (session('module_active') === $module)
        return "active";
    return "";
}
