<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comments extends Model
{
    //the UUID
    use HasUuids;

    /**
     * name of the table
     */
    protected $table = 'comments';

    /**
     * Name of the Id
     * 
     * @var string
     */
    protected $primaryKey = 'comment_id';
    public $incrementing = false;
    public $keyType = 'string';
    protected $uuidColumn = 'comment_id';

    /**
     * The fillable atributes
     */
    protected $fillable = [
        'comment_response',
        'comment_text',
    ];

    /**
     * The relation with the works table
     * 
     * @var BelongsTo
     */    
    public function work():BelongsTo
    {
        return $this->belongsTo(Works::class,'comment_work','work_id');
    }

    /**
     * The relation with the users table
     * 
     * @return BelongsTo
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'comment_user','user_id');
    }
}
