<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Psy\Command\HistoryCommand;

class Works extends Model
{
    /**
     * Uses UUID
     */
    use HasUuids;

    /**
     * table name
     */
    protected $table = 'works';

    /**
     * Name of the Id
     */
    protected $primaryKey = 'work_id';
    public $incrementing = false;
    public $keyType = 'string';
    protected $uuidColumn = 'work_id';

    /**
     * all fillable rows
     */
    protected $fillable = [
        'work_title',
        'work_description',
        'work_status',
        'work_cover',
    ];

    /**
     * Relation with the users table
     * 
     * @return BelongsTo<User, Works>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class,'work_author');
    }

    /**
     * Relation with the AgeRestrictions table
     * 
     * @return BelongsTo<AgeRestrictions, Works>
     */
    public function ageRestriction(): BelongsTo
    {
        return $this->belongsTo(AgeRestrictions::class,'work_age_restriction');
    }

    /**
     * Relation to the chapter table
     * 
     * @return HasMany<Chapters, Works>
     */
    public function chapter(): HasMany
    {
        return $this->hasMany(Chapters::class,'chapter_work');
    }

    /**
     * Relation qith the comment table
     * 
     * @return HasMany<Comments, Works>
     */
    public function comment():HasMany
    {
        return $this->hasMany(Comments::class,'comment_work');
    }

    /**
     * Relation with the intermediate table with genres
     * 
     * @return BelongsToMany<Genres, Works, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genres::class,'genresWorks','work_id','genre_id');
    }

    /**
     * Relation with the readHistory table
     * @return HasMany<ReadHistory, Works>
     */
    public function readHistory(): HasMany
    {
        return $this->hasMany(ReadHistory::class,'read_history_work');
    }

    /**
     * Relation to inteemediate table with readLists
     * @return BelongsToMany<ReadLists, Works, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function readList():BelongsToMany
    {
        return $this->belongsToMany(ReadLists::class,'read_lists_works','work_id','read_list_id');
    }

    public function collection():BelongsToMany
    {
        return $this->belongsToMany(Collections::class,'collections_works','work_id','collection_id');
    }
}
