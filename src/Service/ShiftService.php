<?php


namespace App\Service;


use App\Entity\Shift;
use DateTime;

class ShiftService
{
    public const DAYS_WEEK_NB = 7;

    /**
     * @param DateTime $start
     * @param DateTime $end
     * @return array
     */
    public function getShiftsByMenuDates(DateTime $start, DateTime $end): array
    {
        $startAt      = clone $start;
        $firstDay     = $start->format('l');
        $menuPeriod   = date_diff($start, $end)->days + 1;
        $startKeyLoop = Shift::DAYS_INDEX_SHIFT_INDENTIFIER[$firstDay];
        $weekCount    = ceil($menuPeriod / self::DAYS_WEEK_NB);
        $allShifts    = [];

        for ($i = 1; $i <= $weekCount; $i++) {
            if ($i > 1) {
                $startKeyLoop = 0;
            }
            $allShifts[] = $this->shiftLooper($startKeyLoop, $startAt, $end);
        }

        $allShifts = array_merge([], ...$allShifts);
        return $allShifts;
    }

    /**
     * @param int $startKeyLoop
     * @param DateTime $firstDate
     * @param DateTime $endDate
     * @return array
     */
    private function shiftLooper(int $startKeyLoop, DateTime $firstDate, DateTime $endDate): array
    {
        $shifts = [];
        for ($i = $startKeyLoop, $iMax = count(Shift::SHIFT_IDENTIFIER); $i < $iMax; $i++) {
            if ($firstDate > $endDate) {
                break;
            }
            $halfShift = Shift::SHIFT_IDENTIFIER[$i];
            $shifts[] = sprintf('%s %s', $halfShift, $firstDate->format('d/m'));
            if ($i % 2 !== 0) {
                $firstDate->modify('+1 day');
            }
        }
        return $shifts;
    }
}