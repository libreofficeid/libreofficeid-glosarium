<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Glosarium extends Model
{
    use HasFactory;
    protected $table = "glosarium";
    protected $fillable = ['source','translated','created_by'];

    public function users()
    {
      $this->belongsTo('\App\Models\User','created_by');
    }
}
