<?php

namespace Bikaraan\BForm;

use Encore\Admin\Extension;

class BForm extends Extension
{
    public $name = 'bform';

    public $views = __DIR__.'/../resources/views';

    public $assets = __DIR__.'/../resources/assets';

    public $menu = [
        'title' => 'Bform',
        'path'  => 'bform',
        'icon'  => 'fa-gears',
    ];
}