<?php

return [
    /*
     * This model will be used to create system statistics.
     * It should be implements the Vanquynguyen\SystemStatistics\Contracts\SystemStatistic interface
     * and extend Illuminate\Database\Eloquent\Model.
     */
    'statistic_model' => Vanquy\SystemStatistics\Models\SystemStatistic::class,

    /*
     * This is the name of the table that will be created by the migration and
     * used by the Statistic model shipped with this package.
     */
    'table_name' => 'system_statistics',

     /*
     * This is the database connection that will be used by the migration and
     * the Statistic model shipped with this package. In case it's not set
     * Laravel database.default will be used instead.
     */
    'database_connection' => env('SYSTEM_STATISTICS_DB_CONNECTION'),
];
