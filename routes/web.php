<?php

use Bikaraan\BForm\Http\Controllers\BFormController;

Route::get('bform', BFormController::class.'@index');