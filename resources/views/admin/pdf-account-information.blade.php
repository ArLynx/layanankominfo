<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
            line-height: 1.6;
        }

        .box {
            border: 1px solid #000;
            padding: 18px;
            margin-top: 20px;
        }

        table {
            width: 100%;
        }

        td {
            padding: 6px;
            vertical-align: top;
        }

        .label {
            width: 170px;
            font-weight: bold;
        }

        .footer {
            margin-top: 35px;
            font-size: 11px;
        }

        .note {
            margin-top: 25px;
            border: 1px solid #000;
            background: #f5f5f5;
            padding: 12px;
        }

        .watermark {

            position: fixed;

            top: 40%;

            left: 10%;

            width: 80%;

            text-align: center;

            font-size: 60px;

            color: rgba(180, 180, 180, .18);

            transform: rotate(-30deg);

        }
    </style>

</head>

<body>

    <div class="watermark">

        DISKOMINFO KAB. MURUNG RAYA

    </div>

    @php
        $kop = public_path('images/kop-diskominfo.png');

        $kopData = file_exists($kop) ? base64_encode(file_get_contents($kop)) : null;
    @endphp

    @if ($kopData)
        <img src="data:image/png;base64,{{ $kopData }}" style="width:100%; margin-bottom:20px;">
    @endif

    <h2 style="text-align:center; margin-bottom:10px;">

        @switch($emailSatker->jenis_layanan)
            @case('baru')
                DOKUMEN INFORMASI AKUN EMAIL BARU
            @break

            @case('reset')
                DOKUMEN INFORMASI RESET PASSWORD EMAIL
            @break

            @case('reaktivasi')
                DOKUMEN INFORMASI REAKTIVASI EMAIL
            @break

            @case('ubah_akun')
                DOKUMEN INFORMASI PERUBAHAN NAMA AKUN EMAIL
            @break

            @case('ubah_penanggung')
                DOKUMEN INFORMASI PERUBAHAN PENANGGUNG JAWAB EMAIL
            @break

            @default
                DOKUMEN INFORMASI AKUN EMAIL
        @endswitch

    </h2>

    <table style="width:100%; margin-bottom:20px;">

        <tr>

            <td style="width:180px;">
                Nomor Tiket
            </td>

            <td style="width:10px;">
                :
            </td>

            <td>

                {{ $emailSatker->nomor_tiket }}

            </td>

        </tr>

        <tr>

            <td>
                Tanggal Cetak
            </td>

            <td>
                :
            </td>

            <td>

                {{ now()->translatedFormat('d F Y H:i') }}

            </td>

        </tr>

    </table>

    <div class="box">

        <table>

            @if ($emailSatker->jenis_layanan == 'baru')
                <tr>

                    <td class="label">
                        Jenis Layanan
                    </td>

                    <td>:</td>

                    <td>
                        Pembuatan Email Baru
                    </td>

                </tr>

                <tr>

                    <td class="label">
                        Username Email
                    </td>

                    <td>:</td>

                    <td>
                        {{ $username }}
                    </td>

                </tr>

                <tr>

                    <td class="label">
                        Password Awal
                    </td>

                    <td>:</td>

                    <td>
                        {{ $password }}
                    </td>

                </tr>

                <tr>

                    <td class="label">
                        URL Login
                    </td>

                    <td>:</td>

                    <td>

                        https://surel.mail.go.id/multidomain/

                    </td>

                </tr>
            @endif

            @if ($emailSatker->jenis_layanan == 'reset')
                <tr>

                    <td class="label">

                        Jenis Layanan

                    </td>

                    <td>:</td>

                    <td>

                        Reset Password

                    </td>

                </tr>

                <tr>

                    <td class="label">

                        Username Email

                    </td>

                    <td>:</td>

                    <td>

                        {{ $username }}

                    </td>

                </tr>

                <tr>

                    <td class="label">

                        Password Baru

                    </td>

                    <td>:</td>

                    <td>

                        {{ $password }}

                    </td>

                </tr>

                <tr>

                    <td class="label">

                        URL Login

                    </td>

                    <td>:</td>

                    <td>

                        https://surel.mail.go.id/multidomain/

                    </td>

                </tr>
            @endif

            @if ($emailSatker->jenis_layanan == 'reaktivasi')
                <tr>

                    <td class="label">

                        Jenis Layanan

                    </td>

                    <td>:</td>

                    <td>

                        Reaktivasi Email

                    </td>

                </tr>

                <tr>

                    <td class="label">

                        Username Email

                    </td>

                    <td>:</td>

                    <td>

                        {{ $username }}

                    </td>

                </tr>

                <tr>

                    <td class="label">

                        Password Baru

                    </td>

                    <td>:</td>

                    <td>

                        {{ $password }}

                    </td>

                </tr>

                <tr>

                    <td class="label">

                        URL Login

                    </td>

                    <td>:</td>

                    <td>

                        https://surel.mail.go.id/multidomain/

                    </td>

                </tr>
            @endif

            @if ($emailSatker->jenis_layanan == 'ubah_akun')
                <tr>

                    <td class="label">
                        Jenis Layanan
                    </td>

                    <td>:</td>

                    <td>
                        Perubahan Nama Akun Email
                    </td>

                </tr>

                <tr>

                    <td class="label">
                        Username Lama
                    </td>

                    <td>:</td>

                    <td>
                        {{ $emailSatker->nama_akun_dinas }}
                    </td>

                </tr>

                <tr>

                    <td class="label">
                        Username Baru
                    </td>

                    <td>:</td>

                    <td>
                        {{ $emailSatker->nama_akun_dinas_baru }}
                    </td>

                </tr>

                <tr>

                    <td class="label">
                        Password Awal
                    </td>

                    <td>:</td>

                    <td>
                        {{ $password }}
                    </td>

                </tr>

                <tr>

                    <td class="label">
                        URL Login
                    </td>

                    <td>:</td>

                    <td>
                        https://surel.mail.go.id/multidomain/
                    </td>

                </tr>
            @endif

            @if ($emailSatker->jenis_layanan == 'ubah_penanggung')
                <tr>

                    <td class="label">
                        Jenis Layanan
                    </td>

                    <td>:</td>

                    <td>
                        Perubahan Penanggung Jawab
                    </td>

                </tr>

                <tr>

                    <td class="label">
                        Username Email
                    </td>

                    <td>:</td>

                    <td>
                        {{ $emailSatker->nama_akun_dinas }}
                    </td>

                </tr>

                <tr>

                    <td class="label">
                        Penanggung Jawab Baru
                    </td>

                    <td>:</td>

                    <td>
                        {{ $emailSatker->nama_penanggung_jawab_baru }}
                    </td>

                </tr>

                <tr>

                    <td class="label">
                        Email Penanggung Jawab Baru
                    </td>

                    <td>:</td>

                    <td>
                        {{ $emailSatker->email_baru }}
                    </td>

                </tr>

                <tr>

                    <td class="label">
                        Password Awal
                    </td>

                    <td>:</td>

                    <td>
                        {{ $password }}
                    </td>

                </tr>

                <tr>

                    <td class="label">
                        URL Login
                    </td>

                    <td>:</td>

                    <td>
                        https://surel.mail.go.id/multidomain/
                    </td>

                </tr>
            @endif

        </table>

    </div>

    <div class="note">

        <strong>Catatan :</strong>

        <ol>

            <li>
                Simpan informasi akun ini dengan baik.
            </li>

            <li>
                Segera lakukan perubahan password setelah login pertama.
            </li>

            <li>
                Jangan memberikan username maupun password kepada pihak lain.
            </li>

            <li>
                Apabila mengalami kendala, silakan menghubungi Administrator
                Dinas Komunikasi, Informatika, Statistik dan Persandian
                Kabupaten Murung Raya.
            </li>

        </ol>

    </div>

    <div class="footer">

        <hr>

        <p>

            Dokumen ini diterbitkan secara otomatis oleh
            <strong>Sistem Layanan Diskominfo Kabupaten Murung Raya</strong>.

        </p>

        <p>

            Informasi username dan password pada dokumen ini bersifat rahasia.
            Harap tidak membagikan dokumen kepada pihak yang tidak berkepentingan.

        </p>

    </div>

</body>

</html>
