<?php

namespace MSA\LaravelGrapes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomeBlock extends Model
{
    use HasFactory;

    protected $table = 'custom_blocks';

    protected $fillable = [
      'name',
      'block_data',
    ];
}
