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
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class RingkasanSheet implements FromCollection, WithTitle, WithStyles, ShouldAutoSize, WithEvents
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

        $subdomain = Subdomain::query();
        $emailSatker = EmailSatker::query();
        $emailPribadi = EmailPribadi::query();

        if ($tanggalAwal) {
            $subdomain->whereDate('created_at', '>=', $tanggalAwal);
            $emailSatker->whereDate('created_at', '>=', $tanggalAwal);
            $emailPribadi->whereDate('created_at', '>=', $tanggalAwal);
        }

        if ($tanggalAkhir) {
            $subdomain->whereDate('created_at', '<=', $tanggalAkhir);
            $emailSatker->whereDate('created_at', '<=', $tanggalAkhir);
            $emailPribadi->whereDate('created_at', '<=', $tanggalAkhir);
        }

        switch ($jenis) {
            case 'subdomain':
                $emailSatker->whereRaw('1=0');
                $emailPribadi->whereRaw('1=0');
                break;

            case 'email_satker':
                $subdomain->whereRaw('1=0');
                $emailPribadi->whereRaw('1=0');
                break;

            case 'email_pribadi':
                $subdomain->whereRaw('1=0');
                $emailSatker->whereRaw('1=0');
                break;
        }

        $totalPengajuan = (clone $subdomain)->count() + (clone $emailSatker)->count() + (clone $emailPribadi)->count();

        $totalSelesai = (clone $subdomain)->where('status', 'selesai')->count() + (clone $emailSatker)->where('status', 'selesai')->count() + (clone $emailPribadi)->where('status', 'selesai')->count();

        $totalDiproses = (clone $subdomain)->where('status', 'diproses')->count() + (clone $emailSatker)->where('status', 'diproses')->count() + (clone $emailPribadi)->where('status', 'diproses')->count();

        $totalDitolak = (clone $subdomain)->where('status', 'tutup')->count() + (clone $emailSatker)->where('status', 'tutup')->count() + (clone $emailPribadi)->where('status', 'tutup')->count();

        return new Collection([
            [''],
            [''],
            [''],
            [''],
            [''],
            [''],
            [''],
            [''],

            ['LAPORAN REKAPITULASI PELAYANAN'],
            [''],

            ['Periode', $tanggalAwal && $tanggalAkhir ? \Carbon\Carbon::parse($tanggalAwal)->locale('id')->translatedFormat('d F Y') . ' s/d ' . \Carbon\Carbon::parse($tanggalAkhir)->locale('id')->translatedFormat('d F Y') : 'Semua Periode'],

            [
                'Jenis Layanan',
                match ($jenis) {
                    'subdomain' => 'Subdomain',
                    'email_satker' => 'Email Satker',
                    'email_pribadi' => 'Email Pribadi',
                    default => 'Semua Layanan',
                },
            ],

            ['Tanggal Export', now('Asia/Jakarta')->locale('id')->translatedFormat('d F Y H:i') . ' WIB'],

            ['Dicetak Oleh', auth()->user()->name],

            [''],

            ['RINGKASAN PENGAJUAN', 'Jumlah'],

            ['Total Pengajuan', $totalPengajuan],
            ['Pengajuan Selesai', $totalSelesai],
            ['Proses Pembuatan', $totalDiproses],
            ['Ditolak', $totalDitolak],

            [''],

            ['REKAP JENIS LAYANAN', 'Jumlah'],

            ['Subdomain', (clone $subdomain)->count()],
            ['Email Satker', (clone $emailSatker)->count()],
            ['Email Pribadi', (clone $emailPribadi)->count()],

            [''],

            ['REKAP STATUS', 'Jumlah'],

            ['Pengajuan', (clone $subdomain)->where('status', 'terbuka')->count() + (clone $emailSatker)->where('status', 'terbuka')->count() + (clone $emailPribadi)->where('status', 'terbuka')->count()],

            ['Pemeriksaan Dokumen', (clone $subdomain)->where('status', 'baru')->count() + (clone $emailSatker)->where('status', 'baru')->count() + (clone $emailPribadi)->where('status', 'baru')->count()],

            ['Persetujuan Pimpinan', (clone $subdomain)->where('status', 'tunda')->count() + (clone $emailSatker)->where('status', 'tunda')->count() + (clone $emailPribadi)->where('status', 'tunda')->count()],

            ['Proses Pembuatan', (clone $subdomain)->where('status', 'diproses')->count() + (clone $emailSatker)->where('status', 'diproses')->count() + (clone $emailPribadi)->where('status', 'diproses')->count()],

            ['Selesai', (clone $subdomain)->where('status', 'selesai')->count() + (clone $emailSatker)->where('status', 'selesai')->count() + (clone $emailPribadi)->where('status', 'selesai')->count()],

            ['Ditolak', (clone $subdomain)->where('status', 'tutup')->count() + (clone $emailSatker)->where('status', 'tutup')->count() + (clone $emailPribadi)->where('status', 'tutup')->count()],
        ]);
    }

    public function title(): string
    {
        return 'Ringkasan';
    }

    public function styles(Worksheet $sheet)
    {
        // Merge Judul
        $sheet->mergeCells('A9:B9');

        // Judul
        $sheet->getStyle('A1:A4')->getFont()->setBold(true);

        $sheet->getStyle('A9')->getFont()->setBold(true)->setSize(16);

        $sheet->getStyle('A9')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->getRowDimension(9)->setRowHeight(28);

        $sheet->getStyle('A1:A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Semua border
        $lastRow = $sheet->getHighestRow();

        $sheet
            ->getStyle("A16:B{$lastRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Header Section
        foreach ([16, 22, 27] as $row) {
            $sheet
                ->getStyle("A{$row}:B{$row}")
                ->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('1F4E78');

            $sheet
                ->getStyle("A{$row}:B{$row}")
                ->getFont()
                ->setBold(true)
                ->getColor()
                ->setARGB('FFFFFF');
        }

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $drawing = new Drawing();

                $drawing->setName('Logo');

                $drawing->setDescription('Diskominfo');

                $drawing->setPath(public_path('images/kop-diskominfo.png'));

                $drawing->setHeight(110);

                $drawing->setCoordinates('A1');

                $drawing->setWorksheet($event->sheet->getDelegate());

                $sheet = $event->sheet->getDelegate();

                $sheet->freezePane('A10');

                $sheet->getColumnDimension('A')->setWidth(40);

                $sheet->getColumnDimension('B')->setWidth(45);

                $sheet->getStyle('A:B')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                $sheet->getStyle('B:B')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getHeaderFooter()->setOddFooter('&L&Sistem Layanan Diskominfo Kabupaten Murung Raya&RHalaman &P dari &N');

                $sheet
                    ->getPageSetup()

                    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);

                $sheet
                    ->getPageSetup()

                    ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);

                $pageMargins = $sheet->getPageMargins();

                $pageMargins->setTop(0.4);

                $pageMargins->setBottom(0.4);

                $pageMargins->setLeft(0.3);

                $pageMargins->setRight(0.3);

                $sheet
                    ->getPageSetup()

                    ->setHorizontalCentered(true);

                $sheet
                    ->getPageSetup()

                    ->setPrintArea('A1:B28');

                // Label
                $sheet->getStyle('A11:A14')->getFont()->setBold(true);

                // Value
                $sheet->getStyle('B11:B14')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            },
        ];
    }
}
