<?php

namespace Bikaraan\BForm\Enums;

enum FieldType: string
{
    case TEXT = 'TEXT';
    case DATE = 'DATE';
    case IMAGE = 'IMAGE';

    public function fa(): string
    {
        return match ($this) {
            self::TEXT => 'متن',
            self::DATE => 'تاریخ',
            self::IMAGE => 'تصویر',
        };
    }

    public static function pluck()
    {
        $result = [];
        foreach (self::cases() as $value) {
            if ($value instanceof FieldType) {
                $result[$value->value] = $value->fa();
            }
        }
        return $result;
    }

    public static function values()
    {
        return array_map(fn (FieldType $e) => $e->value, self::cases());
    }
}
