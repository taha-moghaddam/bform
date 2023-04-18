<?php

namespace Bikaraan\BForm\Http\Controllers;

use Encore\Admin\Controllers\AdminController;
use Illuminate\Support\Facades\Lang;

class BaseAdminController extends AdminController
{
    /**
     * Get content title.
     *
     * @return string
     */
    protected function title()
    {
        return Lang::hasForLocale('bform::titles.' . $this->title) ?
            __('bform::titles.' . $this->title) :
            $this->title;
    }
}
