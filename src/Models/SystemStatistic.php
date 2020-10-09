<?php

namespace Vanquy\SystemStatistics\Models;

use Illuminate\Database\Eloquent\Model;

class SystemStatistic extends Model
{
    public $timestamps = false;

    protected $table = 'system_statistics';
    protected $fillable = ['type', 'data', 'date'];
}
