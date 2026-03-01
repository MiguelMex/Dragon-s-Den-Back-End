<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ReadLists extends Model
{
    //the UUID
    use HasUuids;

    /**
     * Name of the Id
     * @var string
     */
    protected $primaryKey = 'read_list_id';

    //the mass asignable attributes
    protected $fillable = [
        'read_list_name',
        'read_list_desription',
    ];

    /**
     * Relation with the user table
     * @return BelongsTo<User, ReadLists>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'read_list_user');
    }

    /**
     * Relation with the intermediate table with works
     * @return BelongsToMany<Works, ReadLists, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function work(): BelongsToMany
    {
        return $this->belongsToMany(Works::class,'readListsWorks','read_list_id','work_id');
    }
}
