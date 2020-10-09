<?php

namespace Vanquy\SystemStatistics;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Vanquy\SystemStatistics\Models\SystemStatistic as SystemStatisticModel;

class SystemStatisticServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/sytemstatistics.php' => config_path('sytemstatistics.php'),
        ], 'config');

        $this->mergeConfigFrom(__DIR__.'/../config/sytemstatistics.php', 'sytemstatistics');

        if (! class_exists('CreateSystemStatisticsTable')) {
            $timestamp = date('Y_m_d_His', time());

            $this->publishes([
                __DIR__.'/../migrations/create_system_statistics_table.php.stub' => database_path("/migrations/{$timestamp}_create_system_statistics_table.php"),
            ], 'migrations');
        }

        $this->publishes([
            __DIR__.'/../commands/CollectSystemStatistics.php.stub' => app_path('Console/Commands/CollectSystemStatistics.php'),
        ], 'commands');
    }
}
