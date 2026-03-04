<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorksInProgress extends Model
{
    //the UUID
    use HasUuids;

    protected $table = 'wips';

    /**
     * Id parameters
     * @var string
     */
    protected $primaryKey = 'work_in_progress_id';
    public $incrementing = false;
    public $keyType = 'string';
    protected $uuidColumn = 'work_in_progress_id';

    /**
     * The attributes
     */
    protected $fillable = [
        'work_in_progress_title',
        'work_in_progress_author'
    ];

    public $timestamps = false;

    /**
     * Relation with drafts table
     * @return HasMany<Drafts, WorksInProgress>
     */
    protected function draft():HasMany
    {
        return $this->hasMany(Drafts::class,'draft_work_in_progress');
    }

    /**
     * Relation with user
     * @return BelongsTo<User, WorksInProgress>
     */
    protected function user():BelongsTo
    {
        return $this->belongsTo(User::class,'work_in_progress_author','user_id');
    }
}
