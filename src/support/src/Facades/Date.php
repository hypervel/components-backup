<?php

declare(strict_types=1);

namespace Hypervel\Support\Facades;

use Closure;
use Hypervel\Support\DateFactory;

/**
 * @see https://carbon.nesbot.com/docs/
 * @see https://github.com/briannesbitt/Carbon/blob/master/src/Carbon/Factory.php
 *
 * @method static bool canBeCreatedFromFormat(string|null $date, string $format)
 * @method static null|\Carbon\CarbonImmutable create(mixed $year = 0, mixed $month = 1, mixed $day = 1, mixed $hour = 0, mixed $minute = 0, mixed $second = 0, mixed $timezone = null)
 * @method static \Carbon\CarbonImmutable createFromDate(mixed $year = null, mixed $month = null, mixed $day = null, mixed $timezone = null)
 * @method static null|\Carbon\CarbonImmutable createFromFormat(mixed $format, mixed $time, mixed $timezone = null)
 * @method static \Carbon\CarbonImmutable createFromId(string|\Symfony\Component\Uid\Ulid|\Symfony\Component\Uid\Uuid $id)
 * @method static null|\Carbon\CarbonImmutable createFromIsoFormat(string $format, string $time, mixed $timezone = null, string|null $locale = 'en', \Symfony\Contracts\Translation\TranslatorInterface|null $translator = null)
 * @method static null|\Carbon\CarbonImmutable createFromLocaleFormat(string $format, string $locale, string $time, mixed $timezone = null)
 * @method static null|\Carbon\CarbonImmutable createFromLocaleIsoFormat(string $format, string $locale, string $time, mixed $timezone = null)
 * @method static \Carbon\CarbonImmutable createFromTime(mixed $hour = 0, mixed $minute = 0, mixed $second = 0, mixed $timezone = null)
 * @method static \Carbon\CarbonImmutable createFromTimestamp(string|int|float $timestamp, \DateTimeZone|string|int|null $timezone = null)
 * @method static \Carbon\CarbonImmutable createFromTimestampMs(string|int|float $timestamp, \DateTimeZone|string|int|null $timezone = null)
 * @method static \Carbon\CarbonImmutable createFromTimestampMsUTC(mixed $timestamp)
 * @method static \Carbon\CarbonImmutable createFromTimestampUTC(float|int|string $timestamp)
 * @method static \Carbon\CarbonImmutable createFromTimeString(string $time, \DateTimeZone|string|int|null $timezone = null)
 * @method static \Carbon\CarbonImmutable createMidnightDate(mixed $year = null, mixed $month = null, mixed $day = null, mixed $timezone = null)
 * @method static null|\Carbon\CarbonImmutable createSafe(mixed $year = null, mixed $month = null, mixed $day = null, mixed $hour = null, mixed $minute = null, mixed $second = null, mixed $timezone = null)
 * @method static \Carbon\CarbonImmutable createStrict(int|null $year = 0, int|null $month = 1, int|null $day = 1, int|null $hour = 0, int|null $minute = 0, int|null $second = 0, mixed $timezone = null)
 * @method static void disableHumanDiffOption(mixed $humanDiffOption)
 * @method static void enableHumanDiffOption(mixed $humanDiffOption)
 * @method static mixed executeWithLocale(string $locale, callable $func)
 * @method static void flushState()
 * @method static \Carbon\CarbonImmutable fromSerialized(mixed $value)
 * @method static array getAvailableLocales()
 * @method static array getAvailableLocalesInfo()
 * @method static array getDays()
 * @method static null|string getFallbackLocale()
 * @method static array getFormatsToIsoReplacements()
 * @method static int getHumanDiffOptions()
 * @method static array getIsoUnits()
 * @method static array|false getLastErrors()
 * @method static string getLocale()
 * @method static int getMidDayAt()
 * @method static null|\Carbon\CarbonInterface|Closure getTestNow()
 * @method static string getTimeFormatByPrecision(string $unitPrecision)
 * @method static null|Closure|string getTranslationMessageWith(mixed $translator, string $key, string|null $locale = null, string|null $default = null)
 * @method static \Symfony\Contracts\Translation\TranslatorInterface getTranslator()
 * @method static array getWeekendDays()
 * @method static int getWeekEndsAt(string|null $locale = null)
 * @method static int getWeekStartsAt(string|null $locale = null)
 * @method static bool hasFormat(string $date, string $format)
 * @method static bool hasFormatWithModifiers(string $date, string $format)
 * @method static bool hasMacro(mixed $name)
 * @method static bool hasRelativeKeywords(string|null $time)
 * @method static bool hasTestNow()
 * @method static \Carbon\CarbonImmutable instance(\DateTimeInterface $date)
 * @method static bool isImmutable()
 * @method static bool isModifiableUnit(mixed $unit)
 * @method static bool isMutable()
 * @method static bool isStrictModeEnabled()
 * @method static bool localeHasDiffOneDayWords(string $locale)
 * @method static bool localeHasDiffSyntax(string $locale)
 * @method static bool localeHasDiffTwoDayWords(string $locale)
 * @method static bool localeHasPeriodSyntax(mixed $locale)
 * @method static bool localeHasShortUnits(string $locale)
 * @method static void macro(string $name, callable|null $macro)
 * @method static null|\Carbon\CarbonImmutable make(mixed $var, \DateTimeZone|string|null $timezone = null)
 * @method static void mixin(object|string $mixin)
 * @method static \Carbon\CarbonImmutable now(\DateTimeZone|string|int|null $timezone = null)
 * @method static \Carbon\CarbonImmutable parse(\DateTimeInterface|\Carbon\WeekDay|\Carbon\Month|string|int|float|null $time, \DateTimeZone|string|int|null $timezone = null)
 * @method static \Carbon\CarbonImmutable parseFromLocale(string $time, string|null $locale = null, \DateTimeZone|string|int|null $timezone = null)
 * @method static string pluralUnit(string $unit)
 * @method static null|\Carbon\CarbonImmutable rawCreateFromFormat(string $format, string $time, mixed $timezone = null)
 * @method static \Carbon\CarbonImmutable rawParse(\DateTimeInterface|\Carbon\WeekDay|\Carbon\Month|string|int|float|null $time, \DateTimeZone|string|int|null $timezone = null)
 * @method static void resetMonthsOverflow()
 * @method static void resetToStringFormat()
 * @method static void resetYearsOverflow()
 * @method static void serializeUsing(mixed $callback)
 * @method static void setFallbackLocale(string $locale)
 * @method static void setHumanDiffOptions(mixed $humanDiffOptions)
 * @method static void setLocale(string $locale)
 * @method static void setMidDayAt(mixed $hour)
 * @method static void setTestNow(mixed $testNow = null)
 * @method static void setTestNowAndTimezone(mixed $testNow = null, mixed $timezone = null)
 * @method static void setToStringFormat(null|Closure|string $format)
 * @method static void setTranslator(\Symfony\Contracts\Translation\TranslatorInterface $translator)
 * @method static void setWeekendDays(mixed $days)
 * @method static bool shouldOverflowMonths()
 * @method static bool shouldOverflowYears()
 * @method static string singularUnit(string $unit)
 * @method static void sleep(float|int $seconds)
 * @method static \Carbon\CarbonImmutable today(\DateTimeZone|string|int|null $timezone = null)
 * @method static \Carbon\CarbonImmutable tomorrow(\DateTimeZone|string|int|null $timezone = null)
 * @method static string translateTimeString(string $timeString, string|null $from = null, string|null $to = null, int $mode = \Carbon\CarbonInterface::TRANSLATE_ALL)
 * @method static string translateWith(\Symfony\Contracts\Translation\TranslatorInterface $translator, string $key, array $parameters = [], mixed $number = null)
 * @method static void use(mixed $handler)
 * @method static void useCallable(callable $callable)
 * @method static void useClass(string $dateClass)
 * @method static void useDefault()
 * @method static void useFactory(\Carbon\Factory $factory)
 * @method static void useMonthsOverflow(mixed $monthsOverflow = true)
 * @method static void useStrictMode(mixed $strictModeEnabled = true)
 * @method static void useYearsOverflow(mixed $yearsOverflow = true)
 * @method static mixed withTestNow(mixed $testNow, callable $callback)
 * @method static \Carbon\CarbonImmutable yesterday(\DateTimeZone|string|int|null $timezone = null)
 *
 * @see \Hypervel\Support\DateFactory
 */
class Date extends Facade
{
    public const string DEFAULT_FACADE = DateFactory::class;

    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'date';
    }

    /**
     * Resolve the facade root instance from the container.
     */
    protected static function resolveFacadeInstance(string $name): mixed
    {
        if (! isset(static::$resolvedInstance[$name]) && (static::$app === null || ! static::$app->bound($name))) {
            // Laravel swaps the default in. The framework binds `date`, so this only serves a
            // missing or bare container, and caching the default keeps the test-only swap() out.
            static::$resolvedInstance[$name] = new (static::DEFAULT_FACADE);
        }

        return parent::resolveFacadeInstance($name);
    }
}
