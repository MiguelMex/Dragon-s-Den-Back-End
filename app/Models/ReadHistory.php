<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReadHistory extends Model
{
    //the UUID
    use HasUuids;

    /**
     * table name
     */
    protected $table = 'read_historys';

    /**
     * Name of the Id
     * 
     * @var string
     */
    protected $primaryKey = 'read_history_id';
    public $incrementing = false;
    public $keyType = 'string';
    protected $uuidColumn = 'read_history_id';

    /**
     * The mass assinged atributes
     * 
     * @var array
     */
    protected $fillable = [
        'read_history_read_date',
    ];

    /**
     * The relationship with the users table
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'read_history_user','user_id');
    }

    /**
     * The relationship with the works table
     * 
     * @return BelongsTo
     */
    public function work():BelongsTo
    {
        return $this->belongsTo(User::class,'read_history_work','work_id');
    }

    /**
     * The relationship with the chapters table
     * 
     * @return BelongsTo
     */
    public function chapter():BelongsTo
    {
        return $this->belongsTo(Chapters::class,'read_history_chapter','chapter_id');
    }
}
