@php

    $kop = public_path('images/kop-diskominfo.png');

    $kopData = file_exists($kop) ? base64_encode(file_get_contents($kop)) : null;

    $jenisLayanan = [
        'baru' => 'Pengajuan Subdomain Baru',
        'ubah_penanggung' => 'Perubahan Penanggung Jawab Subdomain',
        'ubah_subdomain' => 'Perubahan Nama Subdomain',
        'nonaktif' => 'Penonaktifan Subdomain',
    ];

    $judulDeskripsi = match ($subdomain->jenis_layanan) {
        'ubah_penanggung' => 'ALASAN PERUBAHAN PENANGGUNG JAWAB',
        'ubah_subdomain' => 'ALASAN PERUBAHAN NAMA SUBDOMAIN',
        'nonaktif' => 'ALASAN PENONAKTIFAN SUBDOMAIN',
        default => 'DESKRIPSI WEBSITE',
    };

@endphp

<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">


    <title>
        Formulir Permohonan Subdomain
    </title>

    <style>
        @page {
            size: 210mm 330mm;
            margin: 15mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #000;
            margin: 20px;
        }

        .kop {
            width: 100%;
            margin-bottom: 15px;
        }

        .kop img {
            width: 100%;
        }

        .judul {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .section {
            margin-top: 15px;
            page-break-inside: avoid;
        }

        .section-title {
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 10px;
            padding-bottom: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 4px;
            vertical-align: top;
        }

        .label {
            width: 220px;
        }

        .separator {
            width: 10px;
        }

        .deskripsi {
            border: 1px solid #000;
            padding: 10px;
            min-height: 60px;
            line-height: 1.5;
        }

        .pernyataan {
            margin-top: 10px;
            text-align: justify;
            line-height: 1.4;
        }

        .ttd {
            margin-top: 25px;
            width: 100%;
            page-break-inside: avoid;
        }

        .ttd td {
            text-align: center;
            width: 50%;
        }

        .space-sign {
            height: 55px;
        }

        .nama {
            font-weight: bold;
            text-decoration: underline;
        }

        .catatan {
            margin-top: 15px;
            font-size: 10px;
        }
    </style>


</head>

<body>


    @if ($kopData)
        <div class="kop">
            <img src="data:image/png;base64,{{ $kopData }}">
        </div>
    @endif

    <div class="judul">
        FORMULIR PERMOHONAN SUBDOMAIN
    </div>

    {{-- DATA SUBDOMAIN --}}
    <div class="section">

        <div class="section-title">
            DATA SUBDOMAIN
        </div>

        <table>

            <tr>
                <td class="label">Nomor Tiket</td>
                <td class="separator">:</td>
                <td>{{ $subdomain->nomor_tiket }}</td>
            </tr>

            <tr>
                <td class="label">Jenis Layanan</td>
                <td class="separator">:</td>
                <td>
                    {{ $jenisLayanan[$subdomain->jenis_layanan] ?? '-' }}
                </td>
            </tr>

            <tr>
                <td class="label">Nama Instansi</td>
                <td class="separator">:</td>
                <td>{{ $subdomain->nama_instansi }}</td>
            </tr>

            @if ($subdomain->jenis_layanan == 'ubah_subdomain')
                <tr>
                    <td class="label">Nama Subdomain Lama</td>
                    <td class="separator">:</td>
                    <td>{{ $subdomain->nama_subdomain }}</td>
                </tr>

                <tr>
                    <td class="label">Nama Subdomain Baru</td>
                    <td class="separator">:</td>
                    <td>{{ $subdomain->nama_subdomain_baru }}</td>
                </tr>
            @else
                <tr>
                    <td class="label">Nama Subdomain</td>
                    <td class="separator">:</td>
                    <td>{{ $subdomain->nama_subdomain }}</td>
                </tr>
            @endif

        </table>

    </div>

    {{-- DATA PENANGGUNG JAWAB --}}
    <div class="section">

        <div class="section">

            <div class="section-title">

                @if ($subdomain->jenis_layanan == 'ubah_penanggung')
                    DATA PENANGGUNG JAWAB LAMA
                @else
                    DATA PENANGGUNG JAWAB
                @endif

            </div>

            <table>

                <tr>
                    <td class="label">Nama Lengkap</td>
                    <td class="separator">:</td>
                    <td>{{ $subdomain->nama_penanggung_jawab }}</td>
                </tr>

                <tr>
                    <td class="label">NIP</td>
                    <td class="separator">:</td>
                    <td>{{ $subdomain->nip_penanggung_jawab }}</td>
                </tr>

                <tr>
                    <td class="label">Jabatan</td>
                    <td class="separator">:</td>
                    <td>{{ $subdomain->jabatan }}</td>
                </tr>

                <tr>
                    <td class="label">Pangkat / Golongan</td>
                    <td class="separator">:</td>
                    <td>{{ $subdomain->pangkat_gol }}</td>
                </tr>

                <tr>
                    <td class="label">No. HP / WA</td>
                    <td class="separator">:</td>
                    <td>{{ $subdomain->no_hp }}</td>
                </tr>

                <tr>
                    <td class="label">Email</td>
                    <td class="separator">:</td>
                    <td>{{ $subdomain->email }}</td>
                </tr>

            </table>

        </div>

        @if ($subdomain->jenis_layanan == 'ubah_penanggung')
            <div class="section">

                <div class="section-title">
                    DATA PENANGGUNG JAWAB BARU
                </div>

                <table>

                    <tr>
                        <td class="label">Nama Lengkap</td>
                        <td class="separator">:</td>
                        <td>{{ $subdomain->nama_penanggung_jawab_baru }}</td>
                    </tr>

                    <tr>
                        <td class="label">NIP</td>
                        <td class="separator">:</td>
                        <td>{{ $subdomain->nip_penanggung_jawab_baru }}</td>
                    </tr>

                    <tr>
                        <td class="label">Jabatan</td>
                        <td class="separator">:</td>
                        <td>{{ $subdomain->jabatan_baru }}</td>
                    </tr>

                    <tr>
                        <td class="label">Pangkat / Golongan</td>
                        <td class="separator">:</td>
                        <td>{{ $subdomain->pangkat_gol_baru }}</td>
                    </tr>

                    <tr>
                        <td class="label">No. HP / WA</td>
                        <td class="separator">:</td>
                        <td>{{ $subdomain->no_hp_baru }}</td>
                    </tr>

                    <tr>
                        <td class="label">Email</td>
                        <td class="separator">:</td>
                        <td>{{ $subdomain->email_baru }}</td>
                    </tr>

                </table>

            </div>
        @endif

        <div class="catatan">

            <strong>Catatan:</strong><br>

            Penanggung jawab subdomain minimal memiliki jabatan setingkat
            Administrator atau Jabatan Fungsional Ahli Madya.

        </div>

        {{-- DESKRIPSI / ALASAN --}}
        <div class="section">

            <div class="section-title">

                @if ($subdomain->jenis_layanan == 'ubah_penanggung')
                    ALASAN PERUBAHAN PENANGGUNG JAWAB
                @elseif ($subdomain->jenis_layanan == 'ubah_subdomain')
                    ALASAN PERUBAHAN NAMA SUBDOMAIN
                @elseif ($subdomain->jenis_layanan == 'nonaktif')
                    ALASAN PENONAKTIFAN SUBDOMAIN
                @else
                    DESKRIPSI WEBSITE
                @endif

            </div>

            <div class="deskripsi">

                {!! nl2br(e($subdomain->deskripsi_website)) !!}

            </div>

        </div>

        <div class="pernyataan">

            Dengan ini kami mengajukan permohonan layanan subdomain pada
            lingkungan Pemerintah Kabupaten Murung Raya dan menyatakan bahwa
            seluruh data yang tercantum dalam formulir ini adalah benar dan
            dapat dipertanggungjawabkan. Apabila di kemudian hari terdapat
            ketidaksesuaian data, maka kami bersedia menerima konsekuensi
            sesuai ketentuan yang berlaku.

        </div>

        <table class="ttd">

            <tr>

                <td></td>

                <td>
                    Puruk Cahu,
                    {{ $subdomain->created_at->locale('id')->translatedFormat('d F Y') }}
                </td>

            </tr>

            <tr>

                <td>
                    Mengetahui,<br>
                    {{ $subdomain->jabatan_kadis }}
                </td>

                <td>
                    Penanggung Jawab
                </td>

            </tr>

            <tr>

                <td class="space-sign"></td>

                <td class="space-sign"></td>

            </tr>

            <tr>

                <td>

                    <div class="nama">
                        {{ $subdomain->nama_kadis }}
                    </div>

                    NIP. {{ $subdomain->nip_kadis }}

                </td>

                <td>

                    <div class="nama">
                        {{ $subdomain->nama_penanggung_jawab }}
                    </div>

                    NIP. {{ $subdomain->nip_penanggung_jawab }}

                </td>

            </tr>

        </table>

</body>

</html>
