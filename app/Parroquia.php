<?php




namespace App;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parroquia extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'ciudad',
        'provincia',
    ];

    // Relaciones
    public function estaciones()
    {
        return $this->hasMany(Station::class);
    }

    public function incendios()
    {
        return $this->hasMany(Incendio::class);
    }

    public function emergencias()
    {
        return $this->hasMany(Emergencia::class);
    }
}