@php

    $kop = public_path('images/kop-diskominfo.png');

    $kopData = file_exists($kop) ? base64_encode(file_get_contents($kop)) : null;

    $jenisLayanan = [
        'baru' => 'Pengajuan Baru',
        'reset' => 'Reset Password',
        'reaktivasi' => 'Reaktivasi Akun',
        'ubah_akun' => 'Perubahan Nama Akun',
        'ubah_penanggung' => 'Perubahan Penanggung Jawab',
    ];

@endphp

<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">


    <title>
        FORMULIR PERMOHONAN EMAIL SATUAN KERJA
    </title>

    <style>
        @page {
            size: 210mm 330mm;
            /* F4 / Folio */
            margin: 10mm 12mm;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
            color: #000;
            margin: 0;
            line-height: 1.2;
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
            font-size: 15pt;
            font-weight: bold;
            margin-top: 2px;
            margin-bottom: 12px;
            text-transform: uppercase;
        }

        .section {
            margin-top: 8px;
            page-break-inside: avoid;
        }

        .section-title {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 2px 4px;
            vertical-align: top;
            font-size: 11pt;
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
            font-size: 11pt;
            text-align: justify;
        }

        .pernyataan {
            margin-top: 8px;
            text-align: justify;
            line-height: 1.25;
            font-size: 11pt;
        }

        .ttd {
            width: 100%;
            margin-top: 14px;
            page-break-inside: avoid;
            break-inside: avoid;
            border-collapse: collapse;
        }

        .ttd td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 11pt;
        }

        .space-sign {
            height: 50px;
        }

        .nama {
            font-weight: bold;
            text-decoration: underline;
        }

        .catatan {
            margin-top: 8px;
            font-size: 9pt;
            line-height: 1.2;
        }

        /* =======================================================
   KHUSUS UBAH PENANGGUNG JAWAB
======================================================= */

        @if ($emailSatker->jenis_layanan == 'ubah_penanggung')

            body {
                font-size: 10pt;
                line-height: 1.15;
            }

            .judul {
                font-size: 14pt;
                margin-bottom: 10px;
            }

            .section {
                margin-top: 6px;
            }

            .section-title {
                font-size: 11pt;
                margin-bottom: 4px;
            }

            td {
                padding: 1.5px 4px;
                font-size: 10pt;
            }

            .deskripsi,
            .pernyataan {
                font-size: 10pt;
                line-height: 1.2;
            }

            .ttd {
                margin-top: 14px;
            }

            .ttd td {
                font-size: 10pt;
            }

            .space-sign {
                height: 50px;
            }

            .catatan {
                font-size: 8.5pt;
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
        FORMULIR PERMOHONAN PEMBUATAN ALAMAT E-MAIL SATUAN KERJA
    </div>

    {{-- DATA EMAIL SATUAN KERJA --}}
    <div class="section">

        <div class="section-title">
            DATA EMAIL SATUAN KERJA
        </div>

        <table>

            <tr>
                <td class="label">Nomor Tiket</td>
                <td class="separator">:</td>
                <td>{{ $emailSatker->nomor_tiket }}</td>
            </tr>

            <tr>
                <td class="label">Jenis Layanan</td>
                <td class="separator">:</td>
                <td>{{ $jenisLayanan[$emailSatker->jenis_layanan] ?? '-' }}</td>
            </tr>

            <tr>
                <td class="label">Nama Instansi / Unit Kerja</td>
                <td class="separator">:</td>
                <td>{{ $emailSatker->nama_instansi }}</td>
            </tr>

            @if ($emailSatker->jenis_layanan == 'ubah_akun')
                <tr>
                    <td class="label">Nama Akun Email Lama</td>
                    <td class="separator">:</td>
                    <td>{{ $emailSatker->nama_akun_dinas }}</td>
                </tr>

                <tr>
                    <td class="label">Nama Akun Email Baru</td>
                    <td class="separator">:</td>
                    <td>{{ $emailSatker->nama_akun_dinas_baru }}</td>
                </tr>
            @else
                <tr>
                    <td class="label">Nama Akun Email</td>
                    <td class="separator">:</td>
                    <td>{{ $emailSatker->nama_akun_dinas }}</td>
                </tr>
            @endif

        </table>

    </div>

    {{-- ================= DATA PENANGGUNG JAWAB ================= --}}
    <div class="section">

        <div class="section">

            <div class="section-title">

                @if ($emailSatker->jenis_layanan == 'ubah_penanggung')
                    DATA PENANGGUNG JAWAB LAMA
                @else
                    DATA PENANGGUNG JAWAB
                @endif

            </div>

            <table>

                <tr>
                    <td class="label">Nama Lengkap</td>
                    <td class="separator">:</td>
                    <td>{{ $emailSatker->nama_penanggung_jawab }}</td>
                </tr>

                <tr>
                    <td class="label">NIP</td>
                    <td class="separator">:</td>
                    <td>{{ $emailSatker->nip }}</td>
                </tr>

                <tr>
                    <td class="label">Jabatan</td>
                    <td class="separator">:</td>
                    <td>{{ $emailSatker->jabatan }}</td>
                </tr>

                <tr>
                    <td class="label">Pangkat / Golongan</td>
                    <td class="separator">:</td>
                    <td>{{ $emailSatker->pangkat_gol }}</td>
                </tr>

                <tr>
                    <td class="label">No. HP / WA</td>
                    <td class="separator">:</td>
                    <td>{{ $emailSatker->no_hp }}</td>
                </tr>

                <tr>
                    <td class="label">Email</td>
                    <td class="separator">:</td>
                    <td>{{ $emailSatker->email }}</td>
                </tr>

            </table>

        </div>

        @if ($emailSatker->jenis_layanan == 'ubah_penanggung')
            <div class="section">

                <div class="section-title">

                    DATA PENANGGUNG JAWAB BARU

                </div>

                <table>

                    <tr>
                        <td class="label">Nama Lengkap</td>
                        <td class="separator">:</td>
                        <td>{{ $emailSatker->nama_penanggung_jawab_baru }}</td>
                    </tr>

                    <tr>
                        <td class="label">NIP</td>
                        <td class="separator">:</td>
                        <td>{{ $emailSatker->nip_baru }}</td>
                    </tr>

                    <tr>
                        <td class="label">Jabatan</td>
                        <td class="separator">:</td>
                        <td>{{ $emailSatker->jabatan_baru }}</td>
                    </tr>

                    <tr>
                        <td class="label">Pangkat / Golongan</td>
                        <td class="separator">:</td>
                        <td>{{ $emailSatker->pangkat_gol_baru }}</td>
                    </tr>

                    <tr>
                        <td class="label">No. HP / WA</td>
                        <td class="separator">:</td>
                        <td>{{ $emailSatker->no_hp_baru }}</td>
                    </tr>

                    <tr>
                        <td class="label">Email</td>
                        <td class="separator">:</td>
                        <td>{{ $emailSatker->email_baru }}</td>
                    </tr>

                </table>

            </div>
        @endif

    </div>

    <div class="section">

        <div class="section-title">

            PERSYARATAN PENGGUNAAN EMAIL PEMDA KAB. MURUNG RAYA

        </div>

        <table>

            <tr>
                <td width="3%" valign="top">1.</td>
                <td>
                    Pengguna berjanji menggunakan email untuk kepentingan kedinasan.
                </td>
            </tr>

            <tr>
                <td valign="top">2.</td>
                <td>

                    Pengguna berjanji tidak menggunakan email untuk :

                    <br>

                    a) Mengirim email yang berisi junk email, spam, email berantai atau pengiriman email secara terus
                    menerus dengan tidak bertanggung jawab.

                    <br>

                    b) Menggunakan email sebagai link atau alamat email di situs jejaring sosial seperti Facebook,
                    Twitter, dll.

                    <br>

                    c) Memalsukan header email atau metode lain yang digunakan dengan tujuan memalsukan identitas
                    pengguna.

                    <br>

                    d) Mengirim email yang bersifat intimidasi dan mengganggu privasi orang lain.

                    <br>

                    e) Mengirim dengan sengaja virus, spyware atau program-program jahat lain (malicious software).

                </td>

            </tr>

            <tr>

                <td valign="top">3.</td>

                <td>

                    Pengguna bertanggung jawab atas segala aktivitas yang menggunakan username dan password pengguna
                    termasuk seluruh isi email dan lampirannya (attachment).

                </td>

            </tr>

            <tr>

                <td valign="top">4.</td>

                <td>

                    Penghapusan / penonaktifan akun email dapat dilakukan apabila :

                    <br>

                    a) Ada permohonan dari pengguna.

                    <br>

                    b) Tidak terdaftar lagi sebagai PNS aktif di lingkungan Pemerintah Kabupaten Murung Raya.

                    <br>

                    c) Terjadi penyalahgunaan ataupun pelanggaran aturan penggunaan email.

                </td>

            </tr>

        </table>

    </div>

    <div class="section">

        <div class="section-title">

            PERSETUJUAN

        </div>

        <div style="text-align: justify; line-height: 1.8;">

            Dengan ini saya menyatakan bahwa data di atas adalah benar.
            Saya telah membaca dan setuju untuk mematuhi semua aturan yang ditentukan
            dan berlaku bagi seluruh pengguna fasilitas layanan sistem Email Pemerintah
            Daerah Kabupaten Murung Raya.

        </div>

    </div>

    <table class="ttd">

        <tr>

            <td></td>

            <td>
                Puruk Cahu,
                {{ $emailSatker->created_at->locale('id')->translatedFormat('d F Y') }}
            </td>

        </tr>

        <tr>

            <td>
                Mengetahui,<br>
                {{ $emailSatker->jabatan_kadis }}
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
                    {{ $emailSatker->nama_kadis }}
                </div>

                NIP. {{ $emailSatker->nip_kadis }}

            </td>

            <td>

                <div class="nama">

                    @if ($emailSatker->jenis_layanan == 'ubah_penanggung')
                        {{ $emailSatker->nama_penanggung_jawab_baru }}
                    @else
                        {{ $emailSatker->nama_penanggung_jawab }}
                    @endif

                </div>

                NIP.

                @if ($emailSatker->jenis_layanan == 'ubah_penanggung')
                    {{ $emailSatker->nip_baru }}
                @else
                    {{ $emailSatker->nip }}
                @endif

            </td>

        </tr>

    </table>
    
</body>

</html>
