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
        'title',
        'author'
    ];

    /**
     * Relation with drafts table
     * @return HasMany<Drafts, WorksInProgress>
     */
    public function drafts():HasMany
    {
        return $this->hasMany(Drafts::class,'work_in_progress');
    }

    /**
     * Relation with user
     * @return BelongsTo<User, WorksInProgress>
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'author','user_id');
    }
}
