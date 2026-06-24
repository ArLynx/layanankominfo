<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <title>
        Surat Penunjukan Penanggung Jawab Subdomain
    </title>

    <style>
        @page {
            size: 210mm 330mm;
            /* F4 */
            margin-top: 15mm;
            margin-right: 20mm;
            margin-bottom: 15mm;
            margin-left: 25mm;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 12pt;
            /* sama seperti Word ukuran 12 */
            line-height: 1.4;
            color: #000;
            margin: 0;
            padding: 0;
        }


        .kop {
            width: 100%;
            margin-bottom: 15px;
        }

        .kop img {
            width: 100%;
            height: auto;
        }

        .judul-surat {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 25px;
        }

        .judul-surat h3 {
            margin: 0;
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
        }

        .judul-surat p {
            margin-top: 5px;
            text-align: center;
        }

        p {
            text-align: justify;
            margin: 0 0 10px 0;
        }

        .data-table td {
            padding: 2px 0;
            vertical-align: top;
        }

        .label {
            width: 140px;
        }

        .separator {
            width: 15px;
        }

        .ttd {
            width: 100%;
            margin-top: 30px;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .ttd td {
            vertical-align: top;
        }

        .space-sign {
            height: 65px;
        }

        .nama {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>

</head>

<body>

    {{-- KOP SURAT --}}
    @php
        $kop = public_path('images/kop-diskominfo.png');

        $kopData = file_exists($kop) ? base64_encode(file_get_contents($kop)) : null;
    @endphp

    @if ($kopData)
        <div style="margin-bottom:20px;">

            <img src="data:image/png;base64,{{ $kopData }}" style="width:100%;">

        </div>
    @endif

    {{-- JUDUL SURAT --}}
    <div class="judul-surat">

        @if ($subdomain->jenis_layanan == 'ubah_subdomain')
            <h3>
                SURAT PENUNJUKAN PENANGGUNG JAWAB SUBDOMAIN
                <br>
                TERKAIT PERUBAHAN NAMA SUBDOMAIN
            </h3>
        @else
            <h3>
                SURAT PENUNJUKAN PENANGGUNG JAWAB SUBDOMAIN
            </h3>
        @endif

        <p>
            Nomor :
            800.1.11/_________/Diskominfo/{{ now()->format('m') }}/{{ now()->format('Y') }}
        </p>

    </div>

    <p>
        Saya yang bertanda tangan di bawah ini :
    </p>

    <table class="data-table">

        <tr>
            <td class="label">Nama</td>
            <td class="separator">:</td>
            <td>Dr. YULIANUS, M.PdP</td>
        </tr>

        <tr>
            <td class="label">Jabatan</td>
            <td class="separator">:</td>
            <td>
                Kepala Dinas Komunikasi, Informatika,
                Statistik dan Persandian Kabupaten Murung Raya
            </td>
        </tr>

        <tr>
            <td class="label">Instansi</td>
            <td class="separator">:</td>
            <td>
                Dinas Komunikasi, Informatika,
                Statistik dan Persandian Kabupaten Murung Raya
            </td>
        </tr>

    </table>

    <br>

    <p>
        Dengan ini menunjuk :
    </p>

    <table class="data-table">

        <tr>
            <td class="label">Nama</td>
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
            <td class="label">Instansi</td>
            <td class="separator">:</td>
            <td>{{ $subdomain->nama_instansi }}</td>
        </tr>

        <tr>
            <td class="label">Nomor HP</td>
            <td class="separator">:</td>
            <td>{{ $subdomain->no_hp }}</td>
        </tr>

        <tr>
            <td class="label">E-Mail</td>
            <td class="separator">:</td>
            <td>{{ $subdomain->email }}</td>
        </tr>

    </table>

    <br>

    @if ($subdomain->jenis_layanan == 'baru')
        <p>

            Sebagai penanggung jawab pengelolaan nama subdomain :

            <strong>
                {{ $subdomain->nama_subdomain }}
            </strong>

        </p>
    @elseif ($subdomain->jenis_layanan == 'ubah_penanggung')
        <p>

            Sebagai penanggung jawab baru pengelolaan nama subdomain :

            <strong>
                {{ $subdomain->nama_subdomain }}
            </strong>

            yang menggantikan penanggung jawab sebelumnya.

        </p>
    @elseif ($subdomain->jenis_layanan == 'ubah_subdomain')
        <p>

            Sebagai pejabat pengelola nama domain sebelumnya

            <strong>
                {{ $subdomain->nama_subdomain }}
            </strong>

            yang selanjutnya dilakukan perubahan nama domain menjadi

            <strong>
                {{ $subdomain->nama_subdomain_baru }}
            </strong>.

        </p>
    @elseif ($subdomain->jenis_layanan == 'nonaktif')
        <p>

            Sebagai penanggung jawab proses penonaktifan nama subdomain :

            <strong>
                {{ $subdomain->nama_subdomain }}
            </strong>.

        </p>
    @endif

    <p>

        Demikian surat penunjukan ini dibuat untuk
        dipergunakan sebagaimana mestinya.

    </p>

    {{-- TANDA TANGAN --}}
    <table class="ttd">

        <tr>

            <td width="50%"></td>

            <td>

                Puruk Cahu,
                {{ now()->translatedFormat('d F Y') }}

                <br><br>

                KEPALA DINAS KOMUNIKASI,
                INFORMATIKA, STATISTIK
                DAN PERSANDIAN

            </td>

        </tr>

        <tr>

            <td></td>

            <td class="space-sign"></td>

        </tr>

        <tr>

            <td></td>

            <td>

                <div class="nama">
                    Dr. YULIANUS, M.Pd
                </div>

                Pembina Utama Muda IV/c

                <br>

                NIP. 19720726 199802 1 004

            </td>

        </tr>

    </table>

    <div style="
    margin-top:60px;
    font-size:10pt;
">

        <strong>Tembusan disampaikan kepada Yth. :</strong>

        <div style="margin-top:5px;">

            1. Bupati Murung Raya di Puruk Cahu;<br>
            2. Pj. Sekretaris Daerah di Puruk Cahu;<br>
            3. Plt. Inspektur di Puruk Cahu.

        </div>

    </div>

</body>

</html>
