<?php

declare(strict_types=1);

namespace Hypervel\Tests\Support;

use Carbon\Carbon as BaseCarbon;
use Carbon\CarbonImmutable as BaseCarbonImmutable;
use Carbon\CarbonInterface;
use Carbon\Factory;
use Carbon\FactoryImmutable;
use DateTime;
use DateTimeInterface;
use Hypervel\Container\Container;
use Hypervel\Support\Carbon;
use Hypervel\Support\CarbonImmutable;
use Hypervel\Support\DateFactory;
use Hypervel\Support\Facades\Date;
use Hypervel\Tests\TestCase;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use stdClass;
use UnexpectedValueException;

class DateFacadeTest extends TestCase
{
    protected static function assertBetweenStartAndNow(int $start, int $actual): void
    {
        self::assertThat(
            $actual,
            static::logicalAnd(
                static::greaterThanOrEqual($start),
                static::lessThanOrEqual(CarbonImmutable::now()->getTimestamp())
            )
        );
    }

    public function testDefaultDateRoutesReturnHypervelCarbonImmutable(): void
    {
        $start = CarbonImmutable::now()->getTimestamp();

        $this->assertSame(CarbonImmutable::class, Date::now()::class);
        $this->assertSame(CarbonImmutable::class, Date::parse('2026-07-22')::class);
        $this->assertSame(CarbonImmutable::class, Date::today()::class);
        $this->assertSame(CarbonImmutable::class, now()::class);
        $this->assertSame(CarbonImmutable::class, today()::class);
        self::assertBetweenStartAndNow($start, Date::now()->getTimestamp());
    }

    public function testUnboundDateUsesTheDefaultFactoryWithoutBindingIt(): void
    {
        $container = new Container;
        Date::setFacadeApplication($container);

        $this->assertSame(DateFactory::class, Date::getFacadeRoot()::class);
        $this->assertFalse($container->bound('date'));
    }

    public function testCallableTransformsDatesAndPreservesOtherResults(): void
    {
        DateFactory::use(static fn (CarbonImmutable $date): CarbonImmutable => $date->addDay());

        $this->assertSame('2026-07-23', Date::parse('2026-07-22')->toDateString());
        $this->assertNull(Date::make(null));
        $this->assertIsString(Date::getLocale());

        $clock = static fn (): CarbonImmutable => CarbonImmutable::parse('2026-07-22');
        Date::setTestNow($clock);
        $this->assertSame($clock, Date::getTestNow());
        $external = Carbon::parse('2026-07-22');
        $this->assertSame($external, Date::withTestNow(null, static fn (): Carbon => $external));
    }

    public function testCallableCannotReturnAMutableDate(): void
    {
        DateFactory::use(static fn (CarbonImmutable $date): Carbon => $date->toMutable());

        $this->expectException(UnexpectedValueException::class);
        Date::parse('2026-07-22');
    }

    public function testUseSupportsInvokableObjectsAndCallableStrings(): void
    {
        DateFactory::use(new DateFacadeInvokableHandler);
        $this->assertSame('2026-07-23', Date::parse('2026-07-22')->toDateString());

        DateFactory::use(DateFacadeCallableHandler::class . '::handle');
        $this->assertSame('2026-07-24', Date::parse('2026-07-22')->toDateString());
    }

    public function testConcreteCarbonClassHandlersReturnTheExactConfiguredClass(): void
    {
        foreach ([
            CarbonImmutable::class,
            BaseCarbonImmutable::class,
            DateFacadeCustomCarbon::class,
        ] as $dateClass) {
            DateFactory::use($dateClass);

            $this->assertSame($dateClass, Date::now()::class);
        }
    }

    public function testFactoriesReturnTheirConfiguredImmutableClasses(): void
    {
        DateFactory::use(new Factory(['locale' => 'fr'], BaseCarbonImmutable::class));
        $date = Date::now();

        $this->assertSame(BaseCarbonImmutable::class, $date::class);
        $this->assertSame('fr', $date->locale());

        DateFactory::use(new FactoryImmutable(['locale' => 'de'], CarbonImmutable::class));
        $immutable = Date::now();

        $this->assertSame(CarbonImmutable::class, $immutable::class);
        $this->assertSame('de', $immutable->locale());
    }

    public function testFactoryCreatorsMustReturnImmutableDates(): void
    {
        DateFactory::useFactory(new class([], CarbonImmutable::class) extends Factory {
            public function today(): Carbon
            {
                return Carbon::today();
            }
        });

        $this->expectException(UnexpectedValueException::class);
        Date::today();
    }

    public function testFactoryTimezoneConfigurationReturnsAClonedFactory(): void
    {
        $factory = new Factory([], CarbonImmutable::class);
        DateFactory::use($factory);

        $configured = Date::withTimeZone('America/Toronto');

        $this->assertSame(Factory::class, $configured::class);
        $this->assertNotSame($factory, $configured);
        $this->assertSame('America/Toronto', $configured->now()->timezoneName);
    }

    public function testFlushStateRestoresDefaultDateFactory(): void
    {
        DateFactory::use(DateFacadeCustomCarbon::class);
        $this->assertSame(DateFacadeCustomCarbon::class, Date::now()::class);

        DateFactory::flushState();

        $this->assertSame(CarbonImmutable::class, Date::now()::class);
    }

    #[DataProvider('invalidClassHandlerProvider')]
    public function testUseAndUseClassRejectInvalidClassHandlers(string $dateClass): void
    {
        foreach (['use', 'useClass'] as $method) {
            try {
                DateFactory::{$method}($dateClass);
                $this->fail("{$method} accepted invalid date class {$dateClass}.");
            } catch (InvalidArgumentException) {
                $this->addToAssertionCount(1);
            }
        }
    }

    public static function invalidClassHandlerProvider(): array
    {
        return [
            'mutable Hypervel Carbon' => [Carbon::class],
            'mutable Carbon' => [BaseCarbon::class],
            'native DateTime' => [DateTime::class],
            'Carbon interface' => [CarbonInterface::class],
            'abstract Carbon class' => [DateFacadeAbstractCarbon::class],
            'non-Carbon wrapper' => [DateFacadeNonCarbonWrapper::class],
            'non-Carbon class' => [stdClass::class],
        ];
    }

    public function testUseRejectsInvalidScalarHandler(): void
    {
        $this->expectException(InvalidArgumentException::class);

        DateFactory::use(42);
    }

    public function testMacro(): void
    {
        Date::macro('returnNonDate', function (): string {
            return 'string';
        });

        $this->assertSame('string', Date::returnNonDate());
    }
}

class DateFacadeCustomCarbon extends CarbonImmutable
{
}

abstract class DateFacadeAbstractCarbon extends CarbonImmutable
{
}

class DateFacadeNonCarbonWrapper
{
    public static function instance(DateTimeInterface $date): static
    {
        return new static;
    }
}

class DateFacadeInvokableHandler
{
    public function __invoke(CarbonImmutable $date): CarbonImmutable
    {
        return $date->addDay();
    }
}

class DateFacadeCallableHandler
{
    public static function handle(CarbonImmutable $date): CarbonImmutable
    {
        return $date->addDays(2);
    }
}
