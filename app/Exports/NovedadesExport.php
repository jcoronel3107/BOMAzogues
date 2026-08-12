<?php

namespace App\Exports;

use App\EstacionNovedad;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Http\Request;

class NovedadesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    protected $filtro;

    public function __construct($filtro = null)
    {
        $this->filtro = $filtro;
    }

    public function collection()
    {
        $query = EstacionNovedad::with([
            'estacion',
            'usuarioElabora',
            'usuarioRevisa',
            'usuarioAprueba',
            'emergencias',
            'vehiculos.vehiculo',
            'personal.user'
        ]);

        if ($this->filtro) {
            if (isset($this->filtro['estado']) && $this->filtro['estado'] != '') {
                $query->where('estado', $this->filtro['estado']);
            }
            
            if (isset($this->filtro['fecha_desde']) && $this->filtro['fecha_desde']) {
                $query->whereDate('fecha', '>=', $this->filtro['fecha_desde']);
            }
            if (isset($this->filtro['fecha_hasta']) && $this->filtro['fecha_hasta']) {
                $query->whereDate('fecha', '<=', $this->filtro['fecha_hasta']);
            }
            
            if (isset($this->filtro['estacion_id']) && $this->filtro['estacion_id'] != '') {
                $query->where('estacion_id', $this->filtro['estacion_id']);
            }
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'Código',
            'Fecha',
            'Estación',
            'Estado',
            'Elaborado por',
            'Revisado por',
            'Aprobado por',
            'Fecha Elaboración',
            'Fecha Revisión',
            'Fecha Aprobación',
            'Total Emergencias',
            'Total Personal',
            'Total Vehículos',
            'Observaciones',
        ];
    }

    public function map($novedad): array
    {
        $estados = [
            'elaboracion' => 'Pendiente',
            'revision' => 'En Revisión',
            'aprobado' => 'Aprobado'
        ];

        return [
            'NOV-' . str_pad($novedad->id, 6, '0', STR_PAD_LEFT),
            $novedad->fecha instanceof \Carbon\Carbon ? $novedad->fecha->format('d/m/Y') : date('d/m/Y', strtotime($novedad->fecha)),
            $novedad->estacion->nombre ?? 'N/A',
            $estados[$novedad->estado] ?? $novedad->estado,
            $novedad->usuarioElabora->name ?? 'N/A',
            $novedad->usuarioRevisa->name ?? 'N/A',
            $novedad->usuarioAprueba->name ?? 'N/A',
            $novedad->fecha_elaboracion ? ($novedad->fecha_elaboracion instanceof \Carbon\Carbon ? $novedad->fecha_elaboracion->format('d/m/Y H:i') : date('d/m/Y H:i', strtotime($novedad->fecha_elaboracion))) : 'N/A',
            $novedad->fecha_revision ? ($novedad->fecha_revision instanceof \Carbon\Carbon ? $novedad->fecha_revision->format('d/m/Y H:i') : date('d/m/Y H:i', strtotime($novedad->fecha_revision))) : 'N/A',
            $novedad->fecha_aprobacion ? ($novedad->fecha_aprobacion instanceof \Carbon\Carbon ? $novedad->fecha_aprobacion->format('d/m/Y H:i') : date('d/m/Y H:i', strtotime($novedad->fecha_aprobacion))) : 'N/A',
            $novedad->emergencias->count(),
            $novedad->personal->count(),
            $novedad->vehiculos->count(),
            $novedad->observaciones ?? 'Sin observaciones',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }

    public function title(): string
    {
        return 'Novedades de Estación';
    }
}