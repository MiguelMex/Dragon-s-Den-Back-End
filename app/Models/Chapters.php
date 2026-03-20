<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chapters extends Model
{
    //the UUID
    use HasUuids;

    /**
     * Name of the table
     */
    protected $table = 'chapters';

    /**
     * Name of the id
     * 
     * @var string
     */
    protected $primaryKey = 'chapter_id';
    public $incrementing = false;
    public $keyType = 'string';
    protected $uuidColumn = 'chapter_id';

    /**
     * the fillable variables
     */
    protected $fillable = [
        'name',
        'route',
        'cover',
        'work',
    ];

    /**
     * Relation with the works table
     * 
     * @return BelongsTo<Works, Chapters>
     */
    public function work(): BelongsTo
    {
        return $this->belongsTo(Works::class,'work','work_id');
    }

    /**
     * Relation with the read  history table
     * @return HasMany<ReadHistory, Chapters>
     */
    public function readHistory(): HasMany
    {
        return $this->hasMany(ReadHistory::class,'chapter');
    }
}
