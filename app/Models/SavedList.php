<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedList extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'list_id', ''];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function list()
    {
        return $this->belongsTo(ListModel::class); // Replace ListModel with the actual model for lists
    }
}
