<?php

namespace App\Exports;

use App\EstacionEmergencia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithTitle;

class EmergenciasExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    protected $novedadId;

    public function __construct($novedadId = null)
    {
        $this->novedadId = $novedadId;
    }

    public function collection()
    {
        $query = EstacionEmergencia::with(['novedad.estacion']);

        if ($this->novedadId) {
            $query->where('estacion_novedad_id', $this->novedadId);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Novedad',
            'Estación',
            'Tipo Emergencia',
            'Lugar',
            'Dirección',
            'Sector',
            'Hora Ingreso',
            'Hora Salida',
            'Afectados',
            'Vehículos',
            'Bomberos',
            'Descripción',
            'Recursos Utilizados',
            'Observaciones',
        ];
    }

    public function map($emergencia): array
    {
        return [
            'NOV-' . str_pad($emergencia->novedad->id ?? 0, 6, '0', STR_PAD_LEFT),
            $emergencia->novedad->estacion->nombre ?? 'N/A',
            ucfirst($emergencia->tipo_emergencia),
            $emergencia->lugar,
            $emergencia->direccion ?? 'N/A',
            $emergencia->sector ?? 'N/A',
            $emergencia->hora_ingreso,
            $emergencia->hora_salida ?? 'N/A',
            $emergencia->numero_afectados,
            $emergencia->numero_vehiculos,
            $emergencia->numero_bomberos,
            $emergencia->descripcion ?? 'N/A',
            $emergencia->recursos_utilizados ?? 'N/A',
            $emergencia->observaciones ?? 'N/A',
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
        return 'Emergencias';
    }
}