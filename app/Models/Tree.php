<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tree extends Model
{
    use HasFactory;

    public $table = 'LAN_INVENTORI';
    public $timestamps = FALSE;

    protected $fillable = [
        'INV_LOKASLAND',
        'INV_INVENTORI',
        'INV_POKOKCODE',
        'INV_KODPEMAJU',
        'INV_GARISPUST',
        'INV_UKURLILIT',
        'INV_HIGHTREES',
        'INV_AGEGTREES',
        'INV_LEBARTREE',
        'INV_CODEROOTS',
        'INV_KOORDINAY',
        'INV_KOORDINAX',
        'INV_ACCURACYS',
        'INV_RISIKOTRE',
        'INV_PEMERIKSA',
        'INV_INSPEDATE',
        'INV_SAHOPERSS', 
        'INV_SAHKEDUAS',
        'INV_SAHDATESS',
        'INV_TKHSAHDUA',
        'INV_STATUSFLG',
        'INV_NOMBOFAIL',
        'INV_NOFAILOSC',
        'INV_KODJALANS',
        'INV_ATTACHMEN',
        'INV_STATCHECK',
        'INV_NAMAPBTSS',
        'INV_CODEAREAS',
        'INV_CATATANSS',
        'INV_NAMABUILD',
        'INV_ENTRYOPER',
        'INV_ENTRYDATE',
        'INV_MODFYOPER',
        'INV_MODFYDATE',
        'INV_SAHSTATUS',
        'INV_SAHSTADUA',
        'INV_ARKITEKLS',
        'INV_TKHSAHAKT',
        'INV_QR',
        'INV_KATEGORI',
        'INV_KARBON'
    ];

    protected $primaryKey = 'INV_NOMBORIDS';
}