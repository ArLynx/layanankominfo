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
        FORMULIR PERMOHONAN LAYANAN SUBDOMAIN
    </title>

    <style>
        @page {
            size: 210mm 330mm;
            /* F4 / Folio */
            margin: 10mm 12mm;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            color: #000;
            margin: 0;
            line-height: 1.25;
        }

        .kop {
            width: 100%;
            margin-bottom: 10px;
        }

        .kop img {
            width: 100%;
            display: block;
        }

        .judul {
            text-align: center;
            font-size: 16pt;
            font-weight: bold;
            margin-top: 2px;
            margin-bottom: 14px;
            text-transform: uppercase;
        }

        .section {
            margin-top: 8px;
            page-break-inside: avoid;
        }

        .section-title {
            text-align: center;
            font-size: 13pt;
            font-weight: bold;
            margin-bottom: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 2px 4px;
            vertical-align: top;
            font-size: 12pt;
        }

        .label {
            width: 215px;
            font-weight: normal;
        }

        .separator {
            width: 10px;
            text-align: center;
        }

        .deskripsi {
            border: 1px solid #000;
            padding: 8px;
            min-height: 55px;
            line-height: 1.25;
            font-size: 12pt;
            text-align: justify;
        }

        .pernyataan {
            margin-top: 8px;
            text-align: justify;
            line-height: 1.3;
            font-size: 12pt;
        }

        .ttd {
            width: 100%;
            margin-top: 12px;
            border-collapse: collapse;
        }

        .ttd td {
            border: none;
            vertical-align: top;
        }

      

        .nama {
            font-weight: bold;
            text-decoration: underline;
        }

        .catatan {
            margin-top: 8px;
            font-size: 10pt;
            line-height: 1.2;
        }

        /* =======================================================
   KHUSUS LAYANAN YANG ISINYA LEBIH BANYAK
======================================================= */

        @if ($subdomain->jenis_layanan == 'ubah_penanggung' || $subdomain->jenis_layanan == 'ubah_subdomain')

            body {
                font-size: 11pt;
            }

            td {
                font-size: 11pt;
                padding: 2px 4px;
            }

            .section-title {
                font-size: 12pt;
            }

            .judul {
                font-size: 15pt;
                margin-bottom: 12px;
            }

            .ttd {
                margin-top: 12px;
            }

            .space-sign {
                height: 65px;
            }

        @endif
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

                <td style="width:45%;"></td>

                <td style="width:10%;"></td>

                <td style="width:45%; text-align:center;">

                    Puruk Cahu,
                    {{ $subdomain->created_at->locale('id')->translatedFormat('d F Y') }}

                </td>

            </tr>

            <tr>

                <td style="text-align:center;">

                    Mengetahui,<br>
                    {{ $subdomain->jabatan_kadis }}

                </td>

                <td></td>

                <td style="text-align:center;">

                    Penanggung Jawab

                </td>

            </tr>

            <tr>

                <td style="height:50px;"></td>

                <td></td>

                <td style="height:50px;"></td>

            </tr>

            <tr>

                <td style="text-align:center;">

                    <div class="nama">
                        {{ $subdomain->nama_kadis }}
                    </div>

                    NIP. {{ $subdomain->nip_kadis }}

                </td>

                <td></td>

                <td style="text-align:center;">

                    <div class="nama">

                        @if ($subdomain->jenis_layanan == 'ubah_penanggung')
                            {{ $subdomain->nama_penanggung_jawab_baru }}
                        @else
                            {{ $subdomain->nama_penanggung_jawab }}
                        @endif

                    </div>

                    NIP.

                    @if ($subdomain->jenis_layanan == 'ubah_penanggung')
                        {{ $subdomain->nip_penanggung_jawab_baru }}
                    @else
                        {{ $subdomain->nip_penanggung_jawab }}
                    @endif

                </td>

            </tr>

        </table>
</body>

</html>
