<?php

namespace App\Http\ViewComposers;

use App\product_cat;
use Illuminate\View\View;

class dataComposer
{
    public $tree_product_cats = [];
    /**
     * Create a movie composer.
     *
     * @return void
     */
    public function __construct()
    {
        $cats = product_cat::where('status', '1')->get();
        $product_cats = json_decode($cats, true);
        $this->tree_product_cats = re_index($product_cats, 1);
    }
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('tree_product_cats', $this->tree_product_cats);
    }
}
