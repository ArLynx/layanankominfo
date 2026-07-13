<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <title>Laporan Pelayanan</title>

    <style>
        * {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
        }

        body {
            margin: 18px 24px;
            color: #222;
        }

        .kop {
            text-align: center;
            line-height: 1.4;
        }

        .kop h2 {
            margin: 0;
            font-size: 18px;
        }

        .kop h3 {
            margin: 0;
            font-size: 16px;
        }

        .kop p {
            margin: 2px;
            font-size: 11px;
        }

        hr {
            border: none;
            border-top: 2px solid #000;
            margin: 12px 0 25px;
        }

        .judul {
            text-align: center;
            margin-bottom: 25px;
        }

        .judul h3 {
            margin: 0;
            font-size: 16px;
        }

        .info {
            width: 100%;
            margin-bottom: 25px;
        }

        .info td {
            padding: 4px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.data th,
        table.data td {
            border: 1px solid #000;
            padding: 5px 7px;
        }

        table.data th {
            background: #efefef;
        }

        .section-title {
            margin-top: 18px;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 35px;
            width: 100%;
        }

        .ttd {
            width: 250px;
            float: right;
            text-align: center;
        }

        .space {
            height: 70px;
        }
    </style>

</head>

<body>

    {{-- KOP --}}
    
    @php
        $kop = public_path('images/kop-diskominfo.png');

        $kopData = file_exists($kop) ? base64_encode(file_get_contents($kop)) : null;
    @endphp

    @if ($kopData)
        <img src="data:image/png;base64,{{ $kopData }}" style="width:100%; margin-bottom:18px;">
    @endif

    {{-- JUDUL --}}
    <div class="judul">

        <h3>

            LAPORAN REKAPITULASI PELAYANAN

        </h3>

        <p style="margin-top:8px">

            Dinas Komunikasi, Informatika, Statistika dan Persandian Kabupaten Murung Raya

        </p>

    </div>

    {{-- INFORMASI --}}

    <table class="info" style="margin-bottom:25px">

        <tr>

            <td width="150">Periode</td>

            <td width="10">:</td>

            <td>

                @if ($tanggalAwal && $tanggalAkhir)
                    {{ \Carbon\Carbon::parse($tanggalAwal)->locale('id')->translatedFormat('d F Y') }}

                    s/d

                    {{ \Carbon\Carbon::parse($tanggalAkhir)->locale('id')->translatedFormat('d F Y') }}
                @else
                    Semua Periode
                @endif

            </td>

        </tr>

        <tr>

            <td>Jenis Layanan</td>

            <td>:</td>

            <td>

                @switch($jenis)
                    @case('subdomain')
                        Subdomain
                    @break

                    @case('email_satker')
                        Email Satker
                    @break

                    @case('email_pribadi')
                        Email Pribadi
                    @break

                    @default
                        Semua Layanan
                @endswitch

            </td>

        </tr>

        <tr>

            <td>Tanggal Cetak</td>

            <td>:</td>

            <td>

                {{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('d F Y, H:i') }} WIB

            </td>

        </tr>

    </table>

    {{-- RINGKASAN --}}

    <div class="section-title">

        Ringkasan Pengajuan

    </div>

    <table class="data">

        <tr>

            <th>Uraian</th>

            <th width="120">Jumlah</th>

        </tr>

        <tr>

            <td>Total Pengajuan</td>

            <td class="text-right">

                {{ $totalPengajuan }}

            </td>

        </tr>

        <tr>

            <td>Pengajuan Selesai</td>

            <td class="text-right">

                {{ $totalSelesai }}

            </td>

        </tr>

        <tr>

            <td>Sedang Diproses</td>

            <td class="text-right">

                {{ $totalDiproses }}

            </td>

        </tr>

        <tr>

            <td>Ditolak</td>

            <td class="text-right">

                {{ $totalDitolak }}

            </td>

        </tr>

    </table>

    {{-- JENIS LAYANAN --}}

    <div class="section-title">

        Rekap Jenis Layanan

    </div>

    <table class="data">

        <tr>

            <th>Jenis Layanan</th>

            <th width="120">Jumlah</th>

        </tr>

        @foreach ($rekapJenis as $nama => $jumlah)
            <tr>

                <td>{{ $nama }}</td>

                <td class="text-right">

                    {{ $jumlah }}

                </td>

            </tr>
        @endforeach

    </table>

    {{-- STATUS --}}

    <div class="section-title">

        Rekap Status Pengajuan

    </div>

    <table class="data">

        <tr>

            <th>Status</th>

            <th width="120">Jumlah</th>

        </tr>

        @foreach ($rekapStatus as $nama => $jumlah)
            <tr>

                <td>{{ $nama }}</td>

                <td class="text-right">

                    {{ $jumlah }}

                </td>

            </tr>
        @endforeach

    </table>

    {{-- TTD --}}

    <div class="footer">

        <div class="ttd">

            Puruk Cahu,

            {{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('d F Y') }}

            <br><br>

            Administrator Sistem

            <br>

            <strong>{{ auth()->user()->name }}</strong>

            <div class="space"></div>

            ________________________

        </div>

    </div>

    <script type="text/php">
    if (isset($pdf)) {

        $font = $fontMetrics->getFont("DejaVu Sans");

        $pdf->page_text(
            500,
            915,
            "Halaman {PAGE_NUM} / {PAGE_COUNT}",
            $font,
            9,
            array(0,0,0)
        );

    }
    </script>

</body>

</html>
