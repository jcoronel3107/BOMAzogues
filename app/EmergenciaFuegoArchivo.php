<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmergenciaFuegoArchivo extends Model
{
    protected $table = 'emergencia_fuego_archivos';

    protected $fillable = [
        'emergencia_fuego_id',
        'nombre_original', 'nombre_archivo', 'ruta',
        'tipo', 'mime_type', 'tamano', 'descripcion',
        'usuario_subio_id'
    ];

    public function emergencia()
    {
        return $this->belongsTo(EmergenciaFuego::class, 'emergencia_fuego_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_subio_id');
    }

    public function getTamanoLegibleAttribute()
    {
        $bytes = $this->tamano ?? 0;
        if ($bytes < 1024) return $bytes . ' B';
        if ($bytes < 1048576) return round($bytes / 1024, 2) . ' KB';
        if ($bytes < 1073741824) return round($bytes / 1048576, 2) . ' MB';
        return round($bytes / 1073741824, 2) . ' GB';
    }

    public function getIconoAttribute()
    {
        $mime = $this->mime_type ?? '';
        if (str_contains($mime, 'image')) return 'fa-file-image';
        if (str_contains($mime, 'pdf')) return 'fa-file-pdf';
        if (str_contains($mime, 'word')) return 'fa-file-word';
        if (str_contains($mime, 'excel') || str_contains($mime, 'spreadsheet')) return 'fa-file-excel';
        if (str_contains($mime, 'video')) return 'fa-file-video';
        if (str_contains($mime, 'audio')) return 'fa-file-audio';
        if (str_contains($mime, 'zip') || str_contains($mime, 'compressed')) return 'fa-file-archive';
        return 'fa-file';
    }

    public function getEsImagenAttribute()
    {
        return str_contains($this->mime_type ?? '', 'image');
    }
}