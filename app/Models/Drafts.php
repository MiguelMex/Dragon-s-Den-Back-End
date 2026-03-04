<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Drafts extends Model
{
    //the UUID
    use HasUuids;

    /**
     * name of table
     */
    protected $table = 'drafts';

    /**
     * Name of the Id
     * 
     * @var string
     */
    protected $primaryKey = 'draft_id';
    public $incrementing = false;
    public $keyType = 'string';
    protected $uuidColumn = 'draft_id';

    /**
     * The fillable atributes
     */
    protected $fillable = [
        'draft_name',
        'draft_route',
    ];

    /**
     * Relation with the table Works In progress
     * 
     * @return BelongsTo<WorksInProgress, Drafts>
     */
    public function WorkInProgress():BelongsTo
    {
        return $this->belongsTo(WorksInProgress::class,'draft_work_in_progress','work_in_progress_id');
    }
}
