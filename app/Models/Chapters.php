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
        'chapter_name',
        'chapter_route',
        'chapter_cover',
    ];

    /**
     * Relation with the works table
     * 
     * @return BelongsTo<Works, Chapters>
     */
    public function work(): BelongsTo
    {
        return $this->belongsTo(Works::class,'chapter_work','work_id');
    }

    public function readHistory(): HasMany
    {
        return $this->hasMany(ReadHistory::class,'read_history_chapter');
    }
}
