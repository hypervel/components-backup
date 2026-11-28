<?php

declare(strict_types=1);

namespace Hypervel\Support;

use Carbon\CarbonImmutable as BaseCarbonImmutable;
use Carbon\CarbonInterface;
use Carbon\Factory;
use Carbon\Month;
use Carbon\WeekDay;
use Closure;
use DateTimeInterface;
use DateTimeZone;
use Hypervel\Support\Attributes\BootOnly;
use InvalidArgumentException;
use ReflectionClass;
use Symfony\Component\Uid\Ulid;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;
use UnexpectedValueException;

/**
 * @see https://carbon.nesbot.com/docs/
 * @see https://github.com/briannesbitt/Carbon/blob/master/src/Carbon/Factory.php
 *
 * @method bool canBeCreatedFromFormat(?string $date, string $format)
 * @method null|BaseCarbonImmutable create($year = 0, $month = 1, $day = 1, $hour = 0, $minute = 0, $second = 0, $timezone = null)
 * @method BaseCarbonImmutable createFromDate($year = null, $month = null, $day = null, $timezone = null)
 * @method null|BaseCarbonImmutable createFromFormat($format, $time, $timezone = null)
 * @method BaseCarbonImmutable createFromId(string|Ulid|Uuid $id)
 * @method null|BaseCarbonImmutable createFromIsoFormat(string $format, string $time, $timezone = null, ?string $locale = 'en', ?TranslatorInterface $translator = null)
 * @method null|BaseCarbonImmutable createFromLocaleFormat(string $format, string $locale, string $time, $timezone = null)
 * @method null|BaseCarbonImmutable createFromLocaleIsoFormat(string $format, string $locale, string $time, $timezone = null)
 * @method BaseCarbonImmutable createFromTime($hour = 0, $minute = 0, $second = 0, $timezone = null)
 * @method BaseCarbonImmutable createFromTimeString(string $time, DateTimeZone|string|int|null $timezone = null)
 * @method BaseCarbonImmutable createFromTimestamp(string|int|float $timestamp, DateTimeZone|string|int|null $timezone = null)
 * @method BaseCarbonImmutable createFromTimestampMs(string|int|float $timestamp, DateTimeZone|string|int|null $timezone = null)
 * @method BaseCarbonImmutable createFromTimestampMsUTC($timestamp)
 * @method BaseCarbonImmutable createFromTimestampUTC(float|int|string $timestamp)
 * @method BaseCarbonImmutable createMidnightDate($year = null, $month = null, $day = null, $timezone = null)
 * @method null|BaseCarbonImmutable createSafe($year = null, $month = null, $day = null, $hour = null, $minute = null, $second = null, $timezone = null)
 * @method BaseCarbonImmutable createStrict(?int $year = 0, ?int $month = 1, ?int $day = 1, ?int $hour = 0, ?int $minute = 0, ?int $second = 0, $timezone = null)
 * @method void disableHumanDiffOption($humanDiffOption)
 * @method void enableHumanDiffOption($humanDiffOption)
 * @method mixed executeWithLocale(string $locale, callable $func)
 * @method BaseCarbonImmutable fromSerialized($value)
 * @method array getAvailableLocales()
 * @method array getAvailableLocalesInfo()
 * @method array getDays()
 * @method null|string getFallbackLocale()
 * @method array getFormatsToIsoReplacements()
 * @method int getHumanDiffOptions()
 * @method array getIsoUnits()
 * @method array|false getLastErrors()
 * @method string getLocale()
 * @method int getMidDayAt()
 * @method string getTimeFormatByPrecision(string $unitPrecision)
 * @method null|Closure|string getTranslationMessageWith($translator, string $key, ?string $locale = null, ?string $default = null)
 * @method null|CarbonInterface|Closure getTestNow()
 * @method TranslatorInterface getTranslator()
 * @method int getWeekEndsAt(?string $locale = null)
 * @method int getWeekStartsAt(?string $locale = null)
 * @method array getWeekendDays()
 * @method bool hasFormat(string $date, string $format)
 * @method bool hasFormatWithModifiers(string $date, string $format)
 * @method bool hasMacro($name)
 * @method bool hasRelativeKeywords(?string $time)
 * @method bool hasTestNow()
 * @method BaseCarbonImmutable instance(DateTimeInterface $date)
 * @method bool isImmutable()
 * @method bool isModifiableUnit($unit)
 * @method bool isMutable()
 * @method bool isStrictModeEnabled()
 * @method bool localeHasDiffOneDayWords(string $locale)
 * @method bool localeHasDiffSyntax(string $locale)
 * @method bool localeHasDiffTwoDayWords(string $locale)
 * @method bool localeHasPeriodSyntax($locale)
 * @method bool localeHasShortUnits(string $locale)
 * @method void macro(string $name, ?callable $macro)
 * @method null|BaseCarbonImmutable make($var, DateTimeZone|string|null $timezone = null)
 * @method void mixin(object|string $mixin)
 * @method BaseCarbonImmutable now(DateTimeZone|string|int|null $timezone = null)
 * @method BaseCarbonImmutable parse(DateTimeInterface|WeekDay|Month|string|int|float|null $time, DateTimeZone|string|int|null $timezone = null)
 * @method BaseCarbonImmutable parseFromLocale(string $time, ?string $locale = null, DateTimeZone|string|int|null $timezone = null)
 * @method string pluralUnit(string $unit)
 * @method null|BaseCarbonImmutable rawCreateFromFormat(string $format, string $time, $timezone = null)
 * @method BaseCarbonImmutable rawParse(DateTimeInterface|WeekDay|Month|string|int|float|null $time, DateTimeZone|string|int|null $timezone = null)
 * @method void resetMonthsOverflow()
 * @method void resetToStringFormat()
 * @method void resetYearsOverflow()
 * @method void serializeUsing($callback)
 * @method void setHumanDiffOptions($humanDiffOptions)
 * @method void setFallbackLocale(string $locale)
 * @method void setLocale(string $locale)
 * @method void setMidDayAt($hour)
 * @method void setTestNow(mixed $testNow = null)
 * @method void setTestNowAndTimezone(mixed $testNow = null, $timezone = null)
 * @method void setToStringFormat(null|Closure|string $format)
 * @method void setTranslator(TranslatorInterface $translator)
 * @method void setWeekendDays($days)
 * @method bool shouldOverflowMonths()
 * @method bool shouldOverflowYears()
 * @method string singularUnit(string $unit)
 * @method void sleep(float|int $seconds)
 * @method BaseCarbonImmutable today(DateTimeZone|string|int|null $timezone = null)
 * @method BaseCarbonImmutable tomorrow(DateTimeZone|string|int|null $timezone = null)
 * @method string translateTimeString(string $timeString, ?string $from = null, ?string $to = null, int $mode = \Carbon\CarbonInterface::TRANSLATE_ALL)
 * @method string translateWith(TranslatorInterface $translator, string $key, array $parameters = [], $number = null)
 * @method void useMonthsOverflow($monthsOverflow = true)
 * @method void useStrictMode($strictModeEnabled = true)
 * @method void useYearsOverflow($yearsOverflow = true)
 * @method mixed withTestNow(mixed $testNow, callable $callback)
 * @method BaseCarbonImmutable yesterday(DateTimeZone|string|int|null $timezone = null)
 */
class DateFactory
{
    /**
     * The date creation methods and whether each may return null.
     * Other Carbon methods and macros return their own values.
     */
    private const array DATE_CREATORS = [
        '__set_state' => false,
        'create' => true,
        'createfromdate' => false,
        'createfromformat' => true,
        'createfromid' => false,
        'createfrominterface' => false,
        'createfromisoformat' => true,
        'createfromlocaleformat' => true,
        'createfromlocaleisoformat' => true,
        'createfrommutable' => false,
        'createfromtime' => false,
        'createfromtimestamp' => false,
        'createfromtimestampms' => false,
        'createfromtimestampmsutc' => false,
        'createfromtimestamputc' => false,
        'createfromtimestring' => false,
        'createmidnightdate' => false,
        'createsafe' => true,
        'createstrict' => false,
        'endoftime' => false,
        'fromserialized' => false,
        'instance' => false,
        'make' => true,
        'now' => false,
        'parse' => false,
        'parsefromlocale' => false,
        'rawcreatefromformat' => true,
        'rawparse' => false,
        'startoftime' => false,
        'today' => false,
        'tomorrow' => false,
        'yesterday' => false,
    ];

    /**
     * The default class that will be used for all created dates.
     *
     * @var class-string<BaseCarbonImmutable>
     */
    public const string DEFAULT_CLASS_NAME = CarbonImmutable::class;

    /**
     * The type (class) of dates that should be created.
     *
     * @var null|class-string<BaseCarbonImmutable>
     */
    protected static ?string $dateClass = null;

    /**
     * This callable may be used to intercept date creation.
     */
    protected static ?Closure $callable = null;

    /**
     * The Carbon factory that should be used when creating dates.
     */
    protected static ?Factory $factory = null;

    /**
     * Use the given handler when generating dates (class name, callable, or factory).
     *
     * The selected handler persists in static state for the worker lifetime
     * and affects date creation in every subsequent request.
     *
     * @throws InvalidArgumentException
     */
    #[BootOnly]
    public static function use(mixed $handler): void
    {
        if ($handler instanceof Factory) {
            static::useFactory($handler);
            return;
        }

        if (is_string($handler) && is_a($handler, BaseCarbonImmutable::class, true)) {
            static::useClass($handler);
            return;
        }

        if (is_callable($handler)) {
            static::useCallable($handler);
            return;
        }

        throw new InvalidArgumentException(
            'Invalid date creation handler. Please provide an immutable Carbon class, callable, or Carbon factory.'
        );
    }

    /**
     * Use the default date class when generating dates.
     *
     * Clearing the worker-wide handler affects date creation in every
     * subsequent request.
     */
    #[BootOnly]
    public static function useDefault(): void
    {
        static::$dateClass = null;
        static::$callable = null;
        static::$factory = null;
    }

    /**
     * Execute the given callable on each date creation.
     *
     * The callable persists in a static property for the worker lifetime
     * and transforms each created date across all coroutines.
     *
     * @param callable(CarbonImmutable): BaseCarbonImmutable $callable
     */
    #[BootOnly]
    public static function useCallable(callable $callable): void
    {
        static::$callable = Closure::fromCallable($callable);

        static::$dateClass = null;
        static::$factory = null;
    }

    /**
     * Use the given date type (class) when generating dates.
     *
     * The class name persists in a static property for the worker lifetime
     * and is used for every date creation across all coroutines.
     *
     * @param class-string<BaseCarbonImmutable> $dateClass
     */
    #[BootOnly]
    public static function useClass(string $dateClass): void
    {
        if (
            ! is_a($dateClass, BaseCarbonImmutable::class, true)
            || ! (new ReflectionClass($dateClass))->isInstantiable()
        ) {
            throw new InvalidArgumentException(
                'The date class must be an instantiable CarbonImmutable class.'
            );
        }

        static::$dateClass = $dateClass;

        static::$factory = null;
        static::$callable = null;
    }

    /**
     * Use the given Carbon factory when generating dates.
     *
     * The factory persists in a static property for the worker lifetime
     * and is used for every date creation across all coroutines.
     */
    #[BootOnly]
    public static function useFactory(Factory $factory): void
    {
        static::$factory = $factory;

        static::$dateClass = null;
        static::$callable = null;
    }

    /**
     * Flush all static state.
     */
    public static function flushState(): void
    {
        static::useDefault();
    }

    /**
     * Handle dynamic calls to generate dates.
     */
    public function __call(string $method, array $parameters): mixed
    {
        $defaultClassName = static::DEFAULT_CLASS_NAME;

        if (static::$factory === null && static::$callable === null) {
            $dateClass = static::$dateClass ?? $defaultClassName;

            if ($dateClass === $defaultClassName || method_exists($dateClass, $method) || $dateClass::hasMacro($method)) {
                return $dateClass::$method(...$parameters);
            }

            return $dateClass::instance($defaultClassName::$method(...$parameters));
        }

        $result = static::$factory !== null
            ? static::$factory->{$method}(...$parameters)
            : $defaultClassName::$method(...$parameters);

        $nullable = self::DATE_CREATORS[strtolower($method)] ?? null;

        if ($nullable === null || ($nullable && $result === null)) {
            return $result;
        }

        if (static::$callable !== null) {
            $result = (static::$callable)($result);
        }

        if (! $result instanceof BaseCarbonImmutable) {
            throw new UnexpectedValueException(sprintf('Date::%s() must return an immutable Carbon date, %s returned.', $method, get_debug_type($result)));
        }

        return $result;
    }
}
