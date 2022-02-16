<?php

namespace Support;

use App\Constants;
use Domain\Common\Models\Currency;
use Domain\Users\Models\Admin;
use Domain\Users\Models\BaseUser\BaseUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\HtmlString;
use LogicException;
use Support\CBRcurrencyConverter\CBRcurrencyConverter;

class H
{
    /**
     * Log info about script user and its group
     *
     * @return void
     */
    public static function logInfo(): void
    {
        $debug = debug_backtrace();
        Log::info(
            sprintf(
                'User:%s---Group:%s---%s:%s()',
                exec('id -un'),
                exec('id -gn'),
                $debug[1]['class'] ?? null,
                $debug[1]['function'] ?? null
            )
        );
    }

    public static function userOrAdmin(): BaseUser
    {
        /** @var \Domain\Users\Models\User\User|null $user */
        $user = Auth::user();
        if ($user) {
            return $user;
        }
        /** @var \Domain\Users\Models\Admin|null $admin */
        $admin = Auth::guard(Constants::AUTH_GUARD_ADMIN)->user();
        if ($admin) {
            return $admin;
        }

        throw new LogicException("Has to be at least anonymous user.");
    }

    public static function admin(): ?Admin
    {
        /** @var \Domain\Users\Models\Admin $admin */
        $admin = Auth::guard(Constants::AUTH_GUARD_ADMIN)->user();

        return $admin;
    }

    public static function priceRub(float $value = null, int $currencyId = Currency::ID_RUB): ?float
    {
        if ($value === null) {
            return null;
        }

        $currencyIso = Currency::getIsoName($currencyId);
        if (! $currencyIso) {
            return null;
        }

        return floor(CBRcurrencyConverter::convertRub($currencyIso, $value));
    }

    public static function priceRubFormatted(float $value = null, int $currencyId = Currency::ID_RUB): string
    {
        $rub = static::priceRub($value, $currencyId);
        if ($rub === null) {
            return '';
        }

        return sprintf('%s %s', Currency::getFormattedValue($rub, Currency::ID_RUB), Currency::getFormattedName(Currency::ID_RUB));
    }

    /**
     * @param float|null $value
     * @param int $currencyId
     *
     * @return string
     */
    public static function priceFormatted(float $value = null, int $currencyId = Currency::ID_RUB): string
    {
        if ($currencyId === Currency::ID_RUB) {
            return static::priceRubFormatted($value, $currencyId);
        }

        if ($value === null) {
            return '';
        }

        return sprintf('%s %s', Currency::getFormattedValue($value, $currencyId), Currency::getFormattedName($currencyId));
    }

    public static function getPhone1(): HtmlString
    {
        return new HtmlString('<a href="tel:+74953638799">+7 (495) 363 87 99</a>');
    }

    public static function getPhone2(): HtmlString
    {
        return new HtmlString('<a href="tel:+79153639363">+7 (915) 363 93 63</a>');
    }

    public static function getMail(): HtmlString
    {
        return new HtmlString('<a href="mailto:parket-lux@mail.ru">parket-lux@mail.ru</a>');
    }

    public static function website(): string
    {
        return "parket-lux.ru";
    }

    /**
     * Generate a random string, using a cryptographically secure
     * pseudorandom number generator (random_int)
     *
     * For PHP 7, random_int is a PHP core function
     * For PHP 5.x, depends on https://github.com/paragonie/random_compat
     *
     * @param int $length How many characters do we want?
     * @param string $keyspace A string of all possible characters
     *                         to select from
     * @return string
     *
     * @throws \Exception
     * @see https://stackoverflow.com/a/31284266/12540255
     */
    public static function random_str(
        int $length,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        if ($max < 1) {
            throw new \Exception('$keyspace must be at least two characters long');
        }
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }

        return $str;
    }

    /**
     * @param mixed|string $value
     *
     * @return mixed|string|null
     */
    public static function trimAndNullEmptyString($value)
    {
        if (! is_string($value)) {
            return $value;
        }

        $trimmedValue = trim($value);
        if ($trimmedValue === '') {
            return null;
        } else {
            return $value;
        }
    }

    public static function getMimeTypeName($mimeType): string
    {
        switch ($mimeType) {
            case Constants::MIME_DOC:
            case Constants::MIME_DOCX: {
                return "MS Word";
            }
            case Constants::MIME_PPT:
            case Constants::MIME_PPTX: {
                return "MS PowerPoint";
            }
            case Constants::MIME_XLS:
            case Constants::MIME_XLSX: {
                return "MS Excel";
            }
            case Constants::MIME_GIF: {
                return "gif";
            }
            case Constants::MIME_JPEG: {
                return "jpeg";
            }
            case Constants::MIME_PNG: {
                return "png";
            }
            case Constants::MIME_HTML: {
                return "html";
            }
            case Constants::MIME_PDF: {
                return "pdf";
            }
            default: {
                return "";
            }
        }
    }

    /**
     * @param string $tableName
     * @param string $tableColumn
     * @param string $foreignTableName
     * @param string $foreignTableColumn
     *
     * @return string
     */
    public static function foreignIndexName(string $tableName, string $tableColumn, string $foreignTableName, string $foreignTableColumn): string
    {
        return sprintf('%s_%s_%s_%s', $tableName, $tableColumn, $foreignTableName, $foreignTableColumn);
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return mixed
     */
    public static function runtimeCache(string $key, $value)
    {
        return Cache::store('array')->rememberForever(
            $key,
            is_callable($value)
                ? $value
                : fn () => $value
        );
    }
}
