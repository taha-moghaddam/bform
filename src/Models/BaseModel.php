<?php

namespace Bikaraan\BForm\Models;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\BaseModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel query()
 * @mixin \Eloquent
 */
class BaseModel extends Model
{
    use HasFactory;
    use DefaultDatetimeFormat;

    public function __construct()
    {
        parent::__construct();

        $this->table = config('admin.extensions.bform.config.db-prefix', 'bform_') . $this->getTable();
    }
}
