<?php

namespace Domain\Common\Models;

/**
 * @property int $id
 * @property string $name
 * */
class Currency extends BaseModel
{
    public const TABLE = "currencies";

    public const ID_RUB = 1;
    public const ID_EUR = 2;
    public const ID_USD = 3;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public static function getIdByName(string $name): ?int
    {
        switch (strtolower($name)) {
            case "rub": {
                return static::ID_RUB;
            }
            case "eur": {
                return static::ID_EUR;
            }
            case "usd": {
                return static::ID_USD;
            }
            default: {
                return null;
            }
        }
    }

    public static function getFormattedName(int $id = null): ?string
    {
        switch ($id) {
            case static::ID_RUB: {
                return "р";
            }
            case static::ID_EUR: {
                return "EU";
            }
            case static::ID_USD: {
                return "US";
            }
            default: {
                return null;
            }
        }
    }

    public static function getIsoName(int $id = null): ?string
    {
        switch ($id) {
            case static::ID_RUB: {
                return "RUB";
            }
            case static::ID_EUR: {
                return "EUR";
            }
            case static::ID_USD: {
                return "USD";
            }
            default: {
                return null;
            }
        }
    }

    public static function getFormattedValue($value, int $currencyId): string
    {
        if ($currencyId === static::ID_RUB || static::hasDecimalPart($value)) {
            return number_format(round($value, 0), 0, ".", " ");
        }

        return number_format(round($value, 2), 2, ".", " ");
    }

    public static function hasDecimalPart($value): bool
    {
        return is_numeric($value) && fmod($value, 1) === 0.0;
    }
}
