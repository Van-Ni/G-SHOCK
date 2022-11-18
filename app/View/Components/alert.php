<?php

namespace App\View\Components;

use Illuminate\View\Component;

class alert extends Component
{
    public $name = "Nguyen Van Ni";
    public $acts = "Practise laravel";
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name,$acts)
    {
        //
        $this->name = $name;
        $this->acts = $acts;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.alert');
    }
}
