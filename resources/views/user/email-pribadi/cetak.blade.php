@php

    $kop = public_path('images/kop-diskominfo.png');

    $kopData = file_exists($kop) ? base64_encode(file_get_contents($kop)) : null;

    $jenisLayanan = [
        'baru' => 'Pengajuan Baru',
        'reset' => 'Reset Password',
        'reaktivasi' => 'Reaktivasi Akun',
        'ubah_akun' => 'Perubahan Nama Akun',
    ];

@endphp

<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <title>

        FORMULIR PERMOHONAN EMAIL PRIBADI

    </title>

    <style>
        @page {
            size: 210mm 330mm;
            margin: 10mm 12mm;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 10.5pt;
            color: #000;
            margin: 0;
            line-height: 1.18;
        }

        .kop {
            width: 100%;
            margin-bottom: 8px;
        }

        .kop img {
            width: 100%;
            display: block;
        }

        .judul {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin-top: 2px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .section {
            margin-top: 6px;
            page-break-inside: avoid;
        }

        .section-title {
            text-align: center;
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 1.8px 4px;
            vertical-align: top;
            font-size: 10.5pt;
        }

        .label {
            width: 215px;
        }

        .separator {
            width: 10px;
            text-align: center;
        }

        .ttd {
            width: 100%;
            margin-top: 8px;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .ttd td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 10.5pt;
        }

        .space-sign {
            height: 40px;
        }

        .nama {
            font-weight: bold;
            text-decoration: underline;
        }

        p {
            margin: 0;
        }

        ul,
        ol {
            margin-top: 2px;
            margin-bottom: 2px;
            padding-left: 18px;
        }

        li {
            margin-bottom: 1px;
        }

        small {
            font-size: 9pt;
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

        FORMULIR PERMOHONAN PEMBUATAN ALAMAT E-MAIL PRIBADI

    </div>

    {{-- ========================================================= --}}
    {{-- DATA PEMOHON --}}
    {{-- ========================================================= --}}

    <div class="section">

        <div class="section-title">
            DATA PEMOHON
        </div>

        <table>

            <tr>
                <td class="label">Nomor Tiket</td>
                <td class="separator">:</td>
                <td>{{ $emailPribadi->nomor_tiket }}</td>
            </tr>

            <tr>
                <td class="label">Nama Lengkap</td>
                <td class="separator">:</td>
                <td>{{ $emailPribadi->nama }}</td>
            </tr>

            <tr>
                <td class="label">NIP</td>
                <td class="separator">:</td>
                <td>{{ $emailPribadi->nip }}</td>
            </tr>

            <tr>
                <td class="label">Jabatan</td>
                <td class="separator">:</td>
                <td>{{ $emailPribadi->jabatan }}</td>
            </tr>

            <tr>
                <td class="label">Instansi</td>
                <td class="separator">:</td>
                <td>{{ $emailPribadi->nama_instansi }}</td>
            </tr>

            <tr>
                <td class="label">Email</td>
                <td class="separator">:</td>
                <td>{{ $emailPribadi->email }}</td>
            </tr>

            <tr>
                <td class="label">No. HP (Whatsapp aktif)</td>
                <td class="separator">:</td>
                <td>{{ $emailPribadi->no_hp }}</td>
            </tr>

            @if ($emailPribadi->jenis_layanan == 'ubah_akun')
                <tr>
                    <td class="label">Nama akun saat ini</td>
                    <td class="separator">:</td>
                    <td>{{ $emailPribadi->nama_akun }}</td>
                </tr>

                <tr>
                    <td class="label">Usulan nama akun baru</td>
                    <td class="separator">:</td>
                    <td>{{ $emailPribadi->nama_akun_baru }}@murungrayakab.go.id</td>
                </tr>
            @else
                <tr>
                    <td class="label">Usulan nama akun yang diminta</td>
                    <td class="separator">:</td>
                    <td>{{ $emailPribadi->nama_akun }}@murungrayakab.go.id</td>
                </tr>
            @endif

            <tr>

                <td class="label">
                    Jenis layanan<br>
                </td>

                <td class="separator">:</td>

                <td>

                    @php
                        $layanan = [
                            'baru' => 'Permohonan Baru',
                            'reset' => 'Reset Password',
                            'reaktivasi' => 'Reaktivasi Akun',
                            'ubah_akun' => 'Ganti Nama Akun',
                        ];
                    @endphp

                    {{ $layanan[$emailPribadi->jenis_layanan] ?? '-' }}

                </td>

            </tr>

        </table>

    </div>

    {{-- ========================================================= --}}
    {{-- KETERANGAN --}}
    {{-- ========================================================= --}}

    <div class="section">

        <div class="section-title">
            KETERANGAN
        </div>

        <table>

            <tr>
                <td width="3%" valign="top">1.</td>
                <td>
                    Isilah semua data di atas menggunakan huruf balok.
                </td>
            </tr>

            <tr>
                <td valign="top">2.</td>
                <td>
                    Setelah diisi, formulir diserahkan ke Bidang E-Government
                    Dinas Komunikasi, Informatika, Statistik dan Persandian
                    Kabupaten Murung Raya,
                    Jl. Letjend Soeprapto No. 1 Puruk Cahu
                    Kode Pos 73911
                    atau dikirim melalui email:
                    diskominfo@murungrayakab.go.id.
                </td>
            </tr>

            <tr>
                <td valign="top">3.</td>
                <td>
                    Penamaan akun email harus sesuai dengan nama asli pemilik akun.
                    Nama yang lebih dari satu kata dipisahkan menggunakan simbol
                    titik (.).

                    Administrator berhak mengganti usulan nama akun apabila dianggap
                    melanggar ketentuan penamaan akun email pribadi.
                </td>
            </tr>

            <tr>
                <td valign="top">4.</td>
                <td>
                    Kapasitas email sebesar 1 GB.
                    Pemilik akun disarankan menggunakan mail client.
                </td>
            </tr>

            <tr>
                <td valign="top">5.</td>
                <td>
                    Apabila email sudah siap digunakan,
                    admin akan menghubungi pemohon melalui
                    Email atau WhatsApp.
                </td>
            </tr>

            <tr>
                <td valign="top">6.</td>
                <td>
                    Email dapat digunakan selama pengguna menjadi
                    PNS Pemerintah Kabupaten Murung Raya.

                    Untuk perubahan data dapat menghubungi
                    Administrator Email Diskominfo Kabupaten Murung Raya.
                </td>
            </tr>

        </table>

    </div>

    {{-- ========================================================= --}}
    {{-- PERSYARATAN PENGGUNAAN EMAIL PEMDA MURUNG RAYA --}}
    {{-- ========================================================= --}}

    <div class="section">

        <div class="section-title">
            PERSYARATAN PENGGUNAAN EMAIL PEMDA MURUNG RAYA
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

                    a) Mengirim email yang berisi junk email, spam, email berantai atau
                    pengiriman email secara terus menerus dengan tidak bertanggung jawab.

                    <br>

                    b) Menggunakan email sebagai link atau alamat email di situs jejaring
                    sosial seperti Facebook, Twitter, Instagram, dan sejenisnya.

                    <br>

                    c) Memalsukan header email atau metode lain yang digunakan dengan
                    tujuan memalsukan identitas pengguna.

                    <br>

                    d) Mengirim email yang bersifat intimidasi dan mengganggu privasi
                    orang lain.

                    <br>

                    e) Mengirim dengan sengaja virus, spyware atau program-program
                    jahat lainnya (malicious software).

                </td>

            </tr>

            <tr>

                <td valign="top">3.</td>

                <td>

                    Pengguna bertanggung jawab atas seluruh aktivitas yang menggunakan
                    username dan password pengguna, termasuk seluruh isi email beserta
                    lampirannya (attachment).

                </td>

            </tr>

            <tr>

                <td valign="top">4.</td>

                <td>

                    Penghapusan atau penonaktifan akun email dapat dilakukan apabila :

                    <br>

                    a) Ada permohonan dari pengguna.

                    <br>

                    b) Tidak terdaftar lagi sebagai PNS aktif di lingkungan Pemerintah
                    Kabupaten Murung Raya.

                    <br>

                    c) Terjadi penyalahgunaan ataupun pelanggaran terhadap aturan
                    penggunaan email.

                </td>

            </tr>

        </table>

    </div>

    {{-- ========================================================= --}}
    {{-- PERSETUJUAN --}}
    {{-- ========================================================= --}}

    <div class="section">

        <div class="section-title">
            PERSETUJUAN
        </div>

        <div style="text-align: justify; line-height:1.18; font-size:10.5pt;">

            Dengan ini saya menyatakan bahwa seluruh data yang saya isi pada formulir
            ini adalah benar dan dapat dipertanggungjawabkan.

            Saya telah membaca, memahami, dan menyetujui seluruh ketentuan yang berlaku
            bagi pengguna layanan Email Pemerintah Kabupaten Murung Raya serta bersedia
            mematuhi seluruh peraturan yang telah ditetapkan.

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- TANDA TANGAN --}}
    {{-- ========================================================= --}}

    <table class="ttd">

        <tr>

            <td></td>

            <td>

                Puruk Cahu,

                {{ $emailPribadi->created_at->locale('id')->translatedFormat('d F Y') }}

            </td>

        </tr>

        <tr>

            <td>

                Mengetahui,<br>

                {{ $emailPribadi->jabatan_kadis }}

            </td>

            <td>

                @if ($emailPribadi->pengajuan == 'diri_sendiri')
                    Pemilik Email
                @else
                    Pemohon
                @endif

            </td>

        </tr>

        <tr>

            <td class="space-sign"></td>

            <td class="space-sign"></td>

        </tr>

        <tr>

            <td>

                <div class="nama">

                    {{ $emailPribadi->nama_kadis }}

                </div>

                NIP. {{ $emailPribadi->nip_kadis }}

            </td>

            <td>

                <div class="nama">

                    {{ $emailPribadi->nama }}

                </div>

                NIP. {{ $emailPribadi->nip }}

            </td>

        </tr>

    </table>

</body>

</html>
