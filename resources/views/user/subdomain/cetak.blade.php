<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <title>
        Formulir Permohonan Subdomain
    </title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 25px;
        }

        .header {
            width: 100%;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }

        .header table {
            width: 100%;
        }

        .logo {
            width: 75px;
        }

        .judul {
            text-align: center;
        }

        .judul h1 {
            margin: 0;
            font-size: 20px;
        }

        .judul h2 {
            margin: 5px 0 0;
            font-size: 14px;
            font-weight: normal;
        }

        .section-title {
            margin-top: 15px;
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 14px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table td {
            padding: 6px 4px;
            vertical-align: top;
        }

        .label {
            width: 220px;
        }

        .separator {
            width: 15px;
        }

        .deskripsi-box {
            border: 1px solid #000;
            min-height: 70px;
            padding: 10px;
            margin-top: 5px;
        }

        .pernyataan {
            margin-top: 20px;
            text-align: justify;
            line-height: 1.6;
        }

        .ttd {
            width: 100%;
            margin-top: 50px;
        }

        .ttd td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }

        .space-sign {
            height: 80px;
        }

        .nama {
            font-weight: bold;
            text-decoration: underline;
        }

        .footer {
            margin-top: 25px;
            text-align: right;
            font-size: 11px;
        }
    </style>
</head>

<body>

    @php
        $logo = public_path('images/logo-murung-raya.png');
        $logoData = file_exists($logo) ? base64_encode(file_get_contents($logo)) : null;

        $jenisLayanan = [
            'baru' => 'Pengajuan Subdomain Baru',
            'reset' => 'Perubahan Penanggung Jawab Subdomain',
            'hapus' => 'Perubahan Nama Subdomain',
            'ubah' => 'Penonaktifan Subdomain',
        ];
    @endphp

    <div class="header">

        <table>
            <tr>

                <td width="90">

                    @if ($logoData)
                        <img class="logo" src="data:image/png;base64,{{ $logoData }}">
                    @endif

                </td>

                <td class="judul">

                    <h1>FORMULIR PERMOHONAN SUBDOMAIN</h1>

                    <h2>
                        DINAS KOMUNIKASI DAN INFORMATIKA<br>
                        KABUPATEN MURUNG RAYA
                    </h2>

                </td>

            </tr>
        </table>

    </div>

    <div class="section-title">
        DATA PERMOHONAN
    </div>

    <table class="data-table">

        <tr>
            <td class="label">Nomor Tiket</td>
            <td class="separator">:</td>
            <td>{{ $subdomain->nomor_tiket }}</td>
        </tr>

        <tr>
            <td class="label">Nama Subdomain</td>
            <td class="separator">:</td>
            <td>{{ $subdomain->nama_subdomain }}</td>
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

        <tr>
            <td class="label">Nama Penanggung Jawab</td>
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
            <td class="label">Nomor HP</td>
            <td class="separator">:</td>
            <td>{{ $subdomain->no_hp }}</td>
        </tr>

        <tr>
            <td class="label">Email</td>
            <td class="separator">:</td>
            <td>{{ $subdomain->email }}</td>
        </tr>

    </table>

    <div class="section-title">
        DESKRIPSI WEBSITE
    </div>

    <div class="deskripsi-box">
        {{ $subdomain->deskripsi_website }}
    </div>

    <div class="pernyataan">
        Dengan ini kami mengajukan permohonan layanan subdomain pada lingkungan
        Pemerintah Kabupaten Murung Raya dan menyatakan bahwa seluruh data yang
        disampaikan adalah benar serta dapat dipertanggungjawabkan sesuai dengan
        ketentuan yang berlaku.
    </div>

    <table class="ttd">

        <tr>

            <td></td>

            <td>
                Puruk Cahu, {{ now()->translatedFormat('d F Y') }}
            </td>

        </tr>

        <tr>

            <td>
                Mengetahui,<br>
                Kepala Dinas
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

    {{-- <div class="footer">
        Dicetak pada {{ now()->translatedFormat('d F Y H:i') }} WIB
    </div> --}}

    <script>
        window.onload = function() {
            window.print();
        }
    </script>

</body>

</html>