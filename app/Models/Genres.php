<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genres extends Model
{
    //The UUID
    use HasUuids;

    /**
     * Name of the Id
     * 
     * @var string
     */
    protected $primaryKey = 'genre_id';

    /**
     * the mass asingnable attributes
     */
    protected $fillable = [
        'genre_name',
    ];

    /**
     * Relation with the works table
     * 
     * @var BelongsToMany
     */
    public function work(): BelongsToMany
    {
        return $this->belongsToMany(Works::class,'genresWorks','genre_id','work_id');
    }
}
