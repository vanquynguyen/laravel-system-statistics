<?php

namespace Vanquy\SystemStatistics\Components;

use Illuminate\Support\Facades\DB;

class Collector
{
    /**
     * Collect query statistics by date
     *
     * @param  array  $queries
     * @param  $date
     * @return void
     */
    public function forDate($queries, $date)
    {
        $query = array_reduce($queries, function ($acc, $item) {
            return $acc->selectSub($item['query'], $item['type']);
        }, DB::query());

        return collect($query->first());
    }

    /**
     * Get query from model or table name
     *
     * @param  $name
     * @return void
     */
    public function getQuery($name)
    {
        return $name instanceof Model
            ? $name->newQuery()
            : DB::table($name);
    }

    /**
     * Count total system
     *
     * @param  $name
     * @param  $constraints
     * @param  $date
     * @param  $column
     * @return void
     */
    public function countTotalSystem(
        $name,
        $constraints = null,
        $date = null,
        $column = 'created_at'
    ) {
        $query = $this->getQuery($name);

        $query = $query->selectRaw('COUNT(*)');
        if ($date) {
            $query = $query->whereBetween($column, [
                $date->copy()->startOfDay(),
                $date->copy()->endOfDay(),
            ]);
        }

        if ($constraints) {
            call_user_func($constraints, $query);
        }

        return $query instanceof EloquentBuilder
            ? $query->toBase()
            : $query;
    }

    /**
     * Sum total system
     *
     * @param  $name
     * @param  $constraints
     * @param  $columnSum
     * @param  $date
     * @param  $column
     * @return void
     */
    public function sumTotalSystem(
        $name,
        $constraints = null,
        $columnSum = 'point',
        $date = null,
        $column = 'created_at'
    ) {
        $query = $this->getQuery($name);
        $query = $query->selectRaw("SUM($columnSum)");
        if ($date) {
            $query = $query->whereBetween($column, [
                $date->copy()->startOfDay(),
                $date->copy()->endOfDay(),
            ]);
        }

        if ($constraints) {
            call_user_func($constraints, $query);
        }

        return $query instanceof EloquentBuilder
            ? $query->toBase()
            : $query;
    }
}
