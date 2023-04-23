<?php

namespace Bikaraan\BForm\Enums;

use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\DB;

enum FieldFillOut: string
{
    case ADMIN_NAME = 'ADMIN_NAME';
    case ADMIN_ZONE = 'ADMIN_ZONE';
    case ADMIN_IMAGE = 'ADMIN_IMAGE';

    public function fa(): string
    {
        return match ($this) {
            self::ADMIN_NAME => 'نام کاربر',
            self::ADMIN_ZONE => 'منطقه کاربر',
            self::ADMIN_IMAGE => 'تصویر کاربر',
        };
    }

    public function table(): string
    {
        return match ($this) {
            self::ADMIN_NAME => 'admin_users',
            self::ADMIN_ZONE => 'admin_users',
            self::ADMIN_IMAGE => 'admin_users',
        };
    }

    public function column(): string
    {
        return match ($this) {
            self::ADMIN_NAME => 'name',
            self::ADMIN_ZONE => 'zone_id',
            self::ADMIN_IMAGE => 'avatar',
        };
    }

    public function update($value)
    {
        if ($this->table() === 'admin_users') {
            $model = Admin::user();
            $model->{$this->column()} = $value;
            $model->save();
        }
    }

    public static function pluck()
    {
        $result = [];
        foreach (self::cases() as $value) {
            if ($value instanceof FieldFillOut) {
                $result[$value->value] = $value->fa();
            }
        }
        return $result;
    }

    public static function values()
    {
        return array_map(fn (FieldFillOut $e) => $e->value, self::cases());
    }
}
