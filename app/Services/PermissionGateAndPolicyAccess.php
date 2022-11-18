<?php 
namespace App\Services;
use App\Product;
use Illuminate\Support\Facades\Gate;

class PermissionGateAndPolicyAccess{

    public function setGateAndPolicyAccess(){
        $this->defineGateProduct();
        $this->defineGateProductCat();
    }
    public function defineGateProduct(){
        Gate::define('list_product', 'App\Policies\ProductPolicy@view');
        Gate::define('add_product', 'App\Policies\ProductPolicy@create');
        Gate::define('delete_product', 'App\Policies\ProductPolicy@delete');
        Gate::define("update_product", function ($user, $id) {
            $product = Product::find($id);
            if (
                $user->checkPermissionUser(config('permissions.access.update_product'))
                && $user->id == $product->user_id
            ) {
                return true;
            }
            return false;
        });
    }
    public function defineGateProductCat(){
        //product cat
        Gate::define('list_cat_pr', 'App\Policies\ProductCatPolicy@view');
        Gate::define('add_cat_pr', 'App\Policies\ProductCatPolicy@create');
        Gate::define('delete_cat_pr', 'App\Policies\ProductCatPolicy@delete');
        Gate::define('update_cat_pr', 'App\Policies\ProductCatPolicy@update');
    }
}
