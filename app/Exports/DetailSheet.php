<?php

namespace App\Exports;

use App\Models\EmailPribadi;
use App\Models\EmailSatker;
use App\Models\Subdomain;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class DetailSheet implements FromCollection, WithTitle, WithStyles, ShouldAutoSize, WithEvents
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $tanggalAwal = $this->request->tanggal_awal;
        $tanggalAkhir = $this->request->tanggal_akhir;
        $jenis = $this->request->jenis;

        $data = collect();

        // ===========================
        // SUBDOMAIN
        // ===========================

        if (!$jenis || $jenis == 'subdomain') {
            $query = Subdomain::query();

            if ($tanggalAwal) {
                $query->whereDate('created_at', '>=', $tanggalAwal);
            }

            if ($tanggalAkhir) {
                $query->whereDate('created_at', '<=', $tanggalAkhir);
            }

            foreach ($query->get() as $item) {
                $data->push(['', $item->nomor_tiket, 'Subdomain', $item->nama_penanggung_jawab, $item->nama_instansi, ucfirst($item->status), $item->created_at->format('d-m-Y')]);
            }
        }

        // ===========================
        // EMAIL SATKER
        // ===========================

        if (!$jenis || $jenis == 'email_satker') {
            $query = EmailSatker::query();

            if ($tanggalAwal) {
                $query->whereDate('created_at', '>=', $tanggalAwal);
            }

            if ($tanggalAkhir) {
                $query->whereDate('created_at', '<=', $tanggalAkhir);
            }

            foreach ($query->get() as $item) {
                $data->push(['', $item->nomor_tiket, 'Email Satker', $item->nama_penanggung_jawab, $item->nama_instansi, ucfirst($item->status), $item->created_at->format('d-m-Y')]);
            }
        }

        // ===========================
        // EMAIL PRIBADI
        // ===========================

        if (!$jenis || $jenis == 'email_pribadi') {
            $query = EmailPribadi::query();

            if ($tanggalAwal) {
                $query->whereDate('created_at', '>=', $tanggalAwal);
            }

            if ($tanggalAkhir) {
                $query->whereDate('created_at', '<=', $tanggalAkhir);
            }

            foreach ($query->get() as $item) {
                $data->push(['', $item->nomor_tiket, 'Email Pribadi', $item->nama, $item->nama_instansi, ucfirst($item->status), $item->created_at->format('d-m-Y')]);
            }
        }

        // ===========================
        // HEADER
        // ===========================

        $hasil = collect();

        $hasil->push(['No', 'Nomor Tiket', 'Jenis Layanan', 'Pemohon', 'Instansi', 'Status', 'Tanggal']);

        foreach ($data as $i => $row) {
            $row[0] = $i + 1;

            $hasil->push($row);
        }

        return $hasil;
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();

        // Header
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);

        $sheet->getStyle('A1:G1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('1F4E78');

        $sheet->getStyle('A1:G1')->getFont()->getColor()->setARGB('FFFFFF');

        $sheet
            ->getStyle("A1:{$lastColumn}{$lastRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        return [];
    }

    public function title(): string
    {
        return 'Detail Pengajuan';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->freezePane('A2');

                $sheet->setAutoFilter('A1:G1');

                $sheet->getRowDimension(1)->setRowHeight(24);

                $sheet->getStyle('A:G')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                $sheet->getStyle('A:A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle('F:F')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle('G:G')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
