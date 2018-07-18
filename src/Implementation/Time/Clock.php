<?php declare(strict_types=1);


namespace Dixons\Implementation\Time;


final class Clock implements IClock
{

    public function currentTime(): \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }

    public function timeShiftedBy(Duration $duration): \DateTimeImmutable
    {
        return $duration->applyTo(new \DateTimeImmutable());
    }
}