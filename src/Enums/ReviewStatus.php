<?php

namespace Bikaraan\BForm\Enums;

enum ReviewStatus: string
{
    case VERIFIED = 'VERIFIED';
    case REJECTED = 'REJECTED';
    case PENDING = 'PENDING';

    public function class(): string
    {
        return match ($this) {
            self::PENDING => 'default',
            self::VERIFIED => 'success',
            self::REJECTED => 'danger',
        };
    }

    public function fa(): string
    {
        return match ($this) {
            self::PENDING => 'انتظار',
            self::VERIFIED => 'تایید',
            self::REJECTED => 'رد',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::PENDING => 'fa-hourglass-half fa-spin',
            self::VERIFIED => 'fa-circle-check',
            self::REJECTED => 'fa-circle-xmark',
        };
    }

    public function label(): string
    {
        return "<label class='label label-{$this->class()}'>"
            . "<i class='fa-regular {$this->icon()}'></i> "
            . $this->fa()
            . "</label>";
    }

    public static function pluck()
    {
        $result = [];
        foreach (self::cases() as $value) {
            if ($value instanceof ReviewStatus) {
                $result[$value->value] = $value->fa();
            }
        }
        return $result;
    }

    public static function values()
    {
        return array_map(fn (ReviewStatus $e) => $e->value, self::cases());
    }
}
