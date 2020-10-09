<?php

namespace Vanquy\SystemStatistics\Components;

use Illuminate\Support\Str;
use Vanquy\SystemStatistics\Models\SystemStatistic;

class Repository
{
    /**
     * Get Statistics For Report
     *
     * @param  array  $types
     * @param  $currentDate
     * @param  $lastDate
     * @return void
     */
    public function getStatisticsForReport($types, $currentDate, $lastDate)
    {
        $reports = [];
        foreach ($types as $type) {
            $reports = array_merge($reports, $this->formatDataStatistics($type, $currentDate, $lastDate));
        }

        return $reports;
    }

    /**
     * Find Statistics By Type
     *
     * @param  $date
     * @return  \Illuminate\Database\Eloquent\Builder
     */
    protected function findStatisticsByType($type, $date)
    {
        return SystemStatistic::where('type', $type)
            ->whereDate('date', $date)
            ->firstOrFail();
    }

    /**
     * Format response for data statistics
     *
     * @param  $type
     * @param  $currentDate
     * @param  $lastDate
     * @return void
     */
    protected function formatDataStatistics($type, $currentDate, $lastDate)
    {
        $currentData = $this->findStatisticsByType($type, $currentDate)['data'];
        $lastData = $this->findStatisticsByType($type, $lastDate)['data'];
        $diff = $currentData - $lastData;

        return [
            Str::camel($type) => [
                'data' => $this->findStatisticsByType($type, $currentDate)['data'],
                'diff' => $diff,
            ],
        ];
    }
}
