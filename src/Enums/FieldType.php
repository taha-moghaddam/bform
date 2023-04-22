<?php

namespace Bikaraan\BForm\Enums;

enum FieldType: string
{
    case TEXT = 'TEXT';
    case DATE = 'DATE';
    case IMAGE = 'IMAGE';
    case ZONE = 'ZONE';

    public function fa(): string
    {
        return match ($this) {
            self::TEXT => 'متن',
            self::DATE => 'تاریخ',
            self::IMAGE => 'تصویر',
            self::ZONE => 'منطقه',
        };
    }

    public function func(): string
    {
        return match ($this) {
            self::TEXT => 'text',
            self::DATE => 'jdate',
            self::IMAGE => 'filepond',
            self::ZONE => 'select',
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
