<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Glosarium extends Model
{
    protected $table = "glosarium";
    protected $fillable = ['source','translated','created_by'];

    public function users()
    {
      $this->belongsTo('\App\User','created_by');
    }
}
