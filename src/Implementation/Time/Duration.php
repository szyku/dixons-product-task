<?php declare(strict_types=1);


namespace Dixons\Implementation\Time;


final class Duration
{
    private const PAST = 1;

    /** @var \DateInterval */
    private $interval;

    private function __construct(string $intervalString, bool $past)
    {
        $this->interval = \DateInterval::createFromDateString($intervalString);
        $this->interval->invert = $past;
    }

    /**
     * Returns a Duration object
     */
    public static function inSeconds(int $seconds): self
    {
        $past = $seconds < 0;
        $seconds = abs($seconds);

        return new self("PT{$seconds}S", $past);
    }

    public function isPast(): bool
    {
        return $this->interval->invert === self::PAST;
    }

    public function isFuture(): bool
    {
        $isNotZeroTime = !$this->isZeroTime();
        $isNotPast = !$this->isPast();

        return $isNotPast && $isNotZeroTime;
    }

    private function isZeroTime(): bool
    {
        $i = $this->interval;
        return (bool)
            (
                $i->y
                & $i->m
                & $i->d
                & $i->h
                & $i->i
                & $i->s
                & $i->f
            );
    }
}