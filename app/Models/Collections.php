<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Collections extends Model
{
    //The UUID
    use HasUuids;

    /**
     * The primary key of the table
     * 
     * @var string
     */
    protected $primaryKey = 'collection_id';

    /**
     * The mass asignable atributes
     * 
     * @var array
     */
    protected $fillable = [
        'collection_name',
        'collection_description',
    ];

    /**
     * Relationship with the works
     */
    public function works():BelongsToMany
    {
        return $this->belongsToMany(Works::class, 'collectionsWorks','collection_id','work_id');
    }

    /**
     * Relation with the user table
     * 
     * @return BelongsTo<User, Collections>
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'collection_user');
    }
}
