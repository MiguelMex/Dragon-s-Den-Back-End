<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ReadListsWorks extends Model
{
    //The UUID
    use HasUuids;

    /**
     * Intemediate table doesn't need fillables
     */
}
