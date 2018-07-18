<?php declare(strict_types=1);


namespace Tests\Dixons\Implementation\Time;


use Dixons\Implementation\Time\Duration;
use PHPUnit\Framework\TestCase;

final class DurationTest extends TestCase
{

    private const DAY_IN_SECODS = 60 * 60 * 24;

    public function testCanBeCreatedWithSeconds(): void
    {
        $this->assertInstanceOf(
            Duration::class,
            Duration::inSeconds(123)
        );
    }

    public function testItTellsIfItIsInFuture(): void
    {
        $durationInFuture = Duration::inSeconds(123);

        $this->assertTrue(
            $durationInFuture->isFuture(),
            "Duration's time context incorrect! Should be future duration."
        );

        $durationInPast = Duration::inSeconds(-123);

        $this->assertFalse(
            $durationInPast->isFuture(),
            "Durations's time context incorrect! Should tell it's not future duration."
        );
    }


    public function testItTellsIfItIsInPast(): void
    {
        $durationInFuture = Duration::inSeconds(123);

        $this->assertFalse(
            $durationInFuture->isPast(),
            "Durations's time context incorrect! Should tell it's not past duration."
        );

        $durationInPast = Duration::inSeconds(-123);

        $this->assertTrue(
            $durationInPast->isPast(),
            "Duration's time context incorrect! Should be past duration."
        );
    }

    public function testIfAppliesDurationToTime(): void
    {
        $date = new \DateTimeImmutable("2018-01-01 00:00");
        $shift = Duration::inSeconds(self::DAY_IN_SECODS);
        $shiftedDate = $shift->applyTo($date);

        $this->assertNotSame($shift, $date, "Applied time should be not the same instance.");
        $this->assertSame("2018-01-02", $shiftedDate->format('Y-m-d'));
    }
}