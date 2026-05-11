<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;

class BarangExport implements FromCollection, WithEvents
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Barang::with(['jenisBarang', 'statusBarang', 'kondisiBarang', 'namaRuang.lokasiPenyimpanan']);

        if (!empty($this->filters['nama_ruang_id'])) {
            $query->where('nama_ruang_id', $this->filters['nama_ruang_id']);
        }

        if (!empty($this->filters['lokasi_penyimpanan_id'])) {
            $query->whereHas('namaRuang', function ($q) {
                $q->where('lokasi_penyimpanan_id', $this->filters['lokasi_penyimpanan_id']);
            });
        }

        // Tambahkan filter lainnya jika diperlukan
        if (!empty($this->filters['jenis_barang_id'])) {
            $query->where('jenis_barang_id', $this->filters['jenis_barang_id']);
        }

        if (!empty($this->filters['status_barang_id'])) {
            $query->where('status_barang_id', $this->filters['status_barang_id']);
        }

        $barangs = $query->get();

        // Create header rows
        $headerRows = collect([
            ['YAYASAN AL BIRUNI'],
            ['Tegal, Jawa Tengah'],
            [''], // Empty row
            ['LAPORAN INPUT BARANG'],
            ['Tanggal: ' . Carbon::now()->format('d/m/Y')],
            [''], // Empty row
            [
                'Kode Barang',
                'Nama Barang',
                'Jenis Barang',
                'Status Barang',
                'Kondisi Barang',
                'Nama Ruang',
                'Lokasi Penyimpanan',
                'Jumlah Barang',
                'Harga Satuan',
                'Harga Total',
                'Tanggal Perolehan',
                'Keterangan',
            ]
        ]);

        // Add data rows
        $dataRows = $barangs->map(function($barang) {
            return [
                $barang->kode_barang,
                $barang->nama_barang,
                $barang->jenisBarang->jenis_barang ?? '',
                $barang->statusBarang->nama_status ?? '',
                $barang->kondisiBarang->nama_kondisi ?? '',
                $barang->namaRuang->nama_ruang ?? '',
                $barang->namaRuang->lokasiPenyimpanan->nama_lokasi ?? '',
                $barang->jml_barang,
                $barang->harga_satuan,
                $barang->harga_total,
                $barang->tanggal_perolehan ? Carbon::parse($barang->tanggal_perolehan)->format('d/m/Y') : '',
                $barang->keterangan,
            ];
        });

        return $headerRows->concat($dataRows);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;

                // Merge cells for header
                $sheet->mergeCells('A1:L1');
                $sheet->mergeCells('A2:L2');
                $sheet->mergeCells('A4:L4');
                $sheet->mergeCells('A5:L5');

                // Style header
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

                $sheet->getStyle('A2')->getFont()->setSize(12);
                $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');

                $sheet->getStyle('A4')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A4')->getAlignment()->setHorizontal('center');

                $sheet->getStyle('A5')->getFont()->setSize(11);
                $sheet->getStyle('A5')->getAlignment()->setHorizontal('center');

                // Style table headers
                $sheet->getStyle('A7:L7')->getFont()->setBold(true);
                $sheet->getStyle('A7:L7')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFE6F3FF');
                $sheet->getStyle('A7:L7')->getAlignment()->setHorizontal('center');

                // Auto size columns
                foreach(range('A','L') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                // Add borders to data (starting from row 8)
                $lastRow = $sheet->getHighestRow();
                if ($lastRow > 7) {
                    $sheet->getStyle('A8:L'.$lastRow)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                }
            },
        ];
    }
}
