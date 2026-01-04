<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberRelative extends Model
{
    use HasFactory;
    protected $guarded=[];
    const   RELATION_TYPES=['father', 'mother', 'mother-in-law', 'father-in-law', 'spouse', 'child1', 'child2'];
}
