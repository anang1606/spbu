<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccNeracaLajur extends Model
{
    protected $table = 'acc_neracalajur';
    protected $fillable = [
        'idcoa',
        'namacoa',
        'typecoa',
		'adebit',
        'akredit',
        'bdebit',
		'bkredit',
        'cdebit',
		'ckredit',
        'ddebit',
		'dkredit',
        'edebit',
		'ekredit'
    ];
}
