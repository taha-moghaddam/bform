<?php

namespace Bikaraan\BForm\Http\Controllers;

use Encore\Admin\Layout\Content;
use Illuminate\Routing\Controller;

class BFormController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->title('Title')
            ->description('Description')
            ->body(view('bform::index'));
    }
}