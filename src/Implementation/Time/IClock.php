<?php declare(strict_types=1);

namespace Dixons\Implementation\Time;


interface IClock
{
    public function currentTime(): \DateTimeImmutable;

    public function timeShiftedBy(Duration $duration): \DateTimeImmutable;
}