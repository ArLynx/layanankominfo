<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <title>
        SK Penunjukan Subdomain
    </title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 25px;
            line-height: 1.6;
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
            font-size: 18px;
        }

        .judul h2 {
            margin: 3px 0;
            font-size: 14px;
        }

        .judul p {
            margin: 0;
            font-size: 11px;
        }

        .center {
            text-align: center;
        }

        .section-title {
            margin-top: 20px;
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 14px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table td {
            padding: 5px;
            vertical-align: top;
        }

        .label {
            width: 220px;
        }

    </style>
</head>

<body>

    @php
        $logo = public_path('images/logo-murung-raya.png');
        $logoData = file_exists($logo)
            ? base64_encode(file_get_contents($logo))
            : null;

        $jenisLayanan = [
            'baru' => 'Pengajuan Subdomain Baru',
            'ubah_penanggung' => 'Perubahan Penanggung Jawab Subdomain',
            'ubah_subdomain' => 'Perubahan Nama Subdomain',
            'nonaktif' => 'Penonaktifan Subdomain',
            'ubah_dns' => 'Perubahan DNS / Hosting Tujuan Subdomain',
        ];
    @endphp

    {{-- KOP SURAT --}}
    <div class="header">

        <table>

            <tr>

                <td width="90">

                    @if ($logoData)
                        <img class="logo"
                            src="data:image/png;base64,{{ $logoData }}">
                    @endif

                </td>

                <td class="judul">

                    <h1>
                        PEMERINTAH KABUPATEN MURUNG RAYA
                    </h1>

                    <h2>
                        DINAS KOMUNIKASI, INFORMATIKA,
                        STATISTIK DAN PERSANDIAN
                    </h2>

                    <p>
                        Puruk Cahu - Kabupaten Murung Raya
                    </p>

                </td>

            </tr>

        </table>

    </div>

    {{-- JUDUL --}}
    <div class="center">

        <h2>
            SURAT KEPUTUSAN PENUNJUKAN
        </h2>

        <h3>
            PENANGGUNG JAWAB SUBDOMAIN
        </h3>

        <p>
            Nomor : ..................../Diskominfo/{{ now()->format('Y') }}
        </p>

    </div>

    <p>
        Berdasarkan permohonan layanan subdomain yang diajukan melalui sistem layanan
        Dinas Komunikasi, Informatika, Statistik dan Persandian Kabupaten Murung Raya,
        dengan ini ditetapkan:
    </p>

    <div class="section-title">
        DATA PEMOHON
    </div>

    <table class="data-table">

        <tr>
            <td class="label">Nomor Tiket</td>
            <td>:</td>
            <td>{{ $subdomain->nomor_tiket }}</td>
        </tr>

        <tr>
            <td class="label">Nama Instansi</td>
            <td>:</td>
            <td>{{ $subdomain->nama_instansi }}</td>
        </tr>

        <tr>
            <td class="label">Nama Subdomain</td>
            <td>:</td>
            <td>{{ $subdomain->nama_subdomain }}</td>
        </tr>

        <tr>
            <td class="label">Jenis Layanan</td>
            <td>:</td>
            <td>
                {{ $jenisLayanan[$subdomain->jenis_layanan] ?? '-' }}
            </td>
        </tr>

        <tr>
            <td class="label">Nama Penanggung Jawab</td>
            <td>:</td>
            <td>{{ $subdomain->nama_penanggung_jawab }}</td>
        </tr>

        <tr>
            <td class="label">NIP</td>
            <td>:</td>
            <td>{{ $subdomain->nip_penanggung_jawab }}</td>
        </tr>

        <tr>
            <td class="label">Jabatan</td>
            <td>:</td>
            <td>{{ $subdomain->jabatan }}</td>
        </tr>

        <tr>
            <td class="label">Pangkat / Golongan</td>
            <td>:</td>
            <td>{{ $subdomain->pangkat_gol }}</td>
        </tr>

        <tr>
            <td class="label">Nomor HP</td>
            <td>:</td>
            <td>{{ $subdomain->no_hp }}</td>
        </tr>

        <tr>
            <td class="label">Email</td>
            <td>:</td>
            <td>{{ $subdomain->email }}</td>
        </tr>

    </table>

    <div class="section-title">
    PENETAPAN
</div>

<p style="text-align: justify;">

    Berdasarkan kebutuhan pengelolaan layanan subdomain pada lingkungan
    Pemerintah Kabupaten Murung Raya, dengan ini menunjuk:

</p>

<table class="data-table">

    <tr>
        <td class="label">Nama</td>
        <td>:</td>
        <td>{{ $subdomain->nama_penanggung_jawab }}</td>
    </tr>

    <tr>
        <td class="label">NIP</td>
        <td>:</td>
        <td>{{ $subdomain->nip_penanggung_jawab }}</td>
    </tr>

    <tr>
        <td class="label">Jabatan</td>
        <td>:</td>
        <td>{{ $subdomain->jabatan }}</td>
    </tr>

    <tr>
        <td class="label">Pangkat / Golongan</td>
        <td>:</td>
        <td>{{ $subdomain->pangkat_gol }}</td>
    </tr>

    <tr>
        <td class="label">Instansi</td>
        <td>:</td>
        <td>{{ $subdomain->nama_instansi }}</td>
    </tr>

</table>

<p style="text-align: justify; margin-top:15px;">

    Sebagai Penanggung Jawab Pengelolaan Subdomain:

    <strong>
        {{ $subdomain->nama_subdomain }}
    </strong>

    pada lingkungan Pemerintah Kabupaten Murung Raya.

</p>

<p style="text-align: justify;">

    Penanggung jawab sebagaimana dimaksud bertugas mengelola,
    memanfaatkan, memelihara serta menjaga keamanan layanan subdomain
    sesuai dengan ketentuan yang berlaku pada Pemerintah Kabupaten
    Murung Raya.

</p>

<p style="text-align: justify;">

    Surat Penunjukan ini berlaku sejak tanggal ditetapkan dan dapat
    ditinjau kembali apabila di kemudian hari terdapat perubahan
    kebijakan maupun kebutuhan organisasi.

</p>

<table
    style="
        width:100%;
        margin-top:50px;
        page-break-inside:avoid;
        text-align:center;
    ">

    <tr>

        <td colspan="2" style="text-align:right;padding-bottom:20px;">
            Puruk Cahu, {{ now()->translatedFormat('d F Y') }}
        </td>

    </tr>

    <tr>

        <td width="50%">

            Mengetahui,<br>
            Kepala Dinas Komunikasi, Informatika,<br>
            Statistik dan Persandian

        </td>

        <td width="50%">

            Administrator Sistem

        </td>

    </tr>

    <tr>

        <td style="height:90px;"></td>

        <td style="height:90px;"></td>

    </tr>

    <tr>

        <td>

            <strong>
                Drs. Dummy Kadis, M.Si
            </strong>

            <br>

            NIP. 196501011990031001

        </td>

        <td>

            <strong>
                Admin Diskominfo
            </strong>

            <br>

            NIP. 198901012020121001

        </td>

    </tr>

</table>

</body>

</html>