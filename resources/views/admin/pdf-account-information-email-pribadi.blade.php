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

        @switch($emailPribadi->jenis_layanan)
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

                {{ $emailPribadi->nomor_tiket }}

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

            @if ($emailPribadi->jenis_layanan == 'baru')
                <tr>
                    <td class="label">Jenis Layanan</td>
                    <td>:</td>
                    <td>Pembuatan Email Baru</td>
                </tr>

                <tr>
                    <td class="label">Nama Pemohon</td>
                    <td>:</td>
                    <td>{{ $emailPribadi->nama }}</td>
                </tr>

                <tr>
                    <td class="label">Email Pribadi</td>
                    <td>:</td>
                    <td>{{ $emailPribadi->email }}</td>
                </tr>

                <tr>
                    <td class="label">Username</td>
                    <td>:</td>
                    <td>{{ $username }}</td>
                </tr>

                <tr>
                    <td class="label">Password Awal</td>
                    <td>:</td>
                    <td>{{ $password }}</td>
                </tr>

                <tr>
                    <td class="label">URL Login</td>
                    <td>:</td>
                    <td>https://surel.mail.go.id/multidomain/</td>
                </tr>
            @endif

            @if ($emailPribadi->jenis_layanan == 'reset')
                <tr>
                    <td class="label">Jenis Layanan</td>
                    <td>:</td>
                    <td>Reset Password</td>
                </tr>

                <tr>
                    <td class="label">Nama Pemohon</td>
                    <td>:</td>
                    <td>{{ $emailPribadi->nama }}</td>
                </tr>

                <tr>
                    <td class="label">Email Pribadi</td>
                    <td>:</td>
                    <td>{{ $emailPribadi->email }}</td>
                </tr>

                <tr>
                    <td class="label">Username</td>
                    <td>:</td>
                    <td>{{ $username }}</td>
                </tr>

                <tr>
                    <td class="label">Password Baru</td>
                    <td>:</td>
                    <td>{{ $password }}</td>
                </tr>

                <tr>
                    <td class="label">URL Login</td>
                    <td>:</td>
                    <td>https://surel.mail.go.id/multidomain/</td>
                </tr>
            @endif

            @if ($emailPribadi->jenis_layanan == 'reaktivasi')
                <tr>
                    <td class="label">Jenis Layanan</td>
                    <td>:</td>
                    <td>Reaktivasi Email</td>
                </tr>

                <tr>
                    <td class="label">Nama Pemohon</td>
                    <td>:</td>
                    <td>{{ $emailPribadi->nama }}</td>
                </tr>

                <tr>
                    <td class="label">Email Pribadi</td>
                    <td>:</td>
                    <td>{{ $emailPribadi->email }}</td>
                </tr>

                <tr>
                    <td class="label">Username</td>
                    <td>:</td>
                    <td>{{ $username }}</td>
                </tr>

                <tr>
                    <td class="label">Password Baru</td>
                    <td>:</td>
                    <td>{{ $password }}</td>
                </tr>

                <tr>
                    <td class="label">URL Login</td>
                    <td>:</td>
                    <td>https://surel.mail.go.id/multidomain/</td>
                </tr>
            @endif

            @if ($emailPribadi->jenis_layanan == 'ubah_akun')
                <tr>
                    <td class="label">Jenis Layanan</td>
                    <td>:</td>
                    <td>Perubahan Nama Akun Email</td>
                </tr>

                <tr>
                    <td class="label">Nama Pemohon</td>
                    <td>:</td>
                    <td>{{ $emailPribadi->nama }}</td>
                </tr>

                <tr>
                    <td class="label">Email Pribadi</td>
                    <td>:</td>
                    <td>{{ $emailPribadi->email }}</td>
                </tr>

                <tr>
                    <td class="label">Username Lama</td>
                    <td>:</td>
                    <td>{{ $emailPribadi->nama_akun }}</td>
                </tr>

                <tr>
                    <td class="label">Username Baru</td>
                    <td>:</td>
                    <td>{{ $emailPribadi->nama_akun_baru }}</td>
                </tr>

                <tr>
                    <td class="label">Password Baru</td>
                    <td>:</td>
                    <td>{{ $password }}</td>
                </tr>

                <tr>
                    <td class="label">URL Login</td>
                    <td>:</td>
                    <td>https://surel.mail.go.id/multidomain/</td>
                </tr>
            @endif

        </table>

    </div>

    <div class="note">

        <strong>Catatan :</strong>

        <ol>

            <li>
                Simpan dokumen ini dengan baik dan jangan diberikan kepada pihak yang tidak berkepentingan.
            </li>

            @if ($emailPribadi->jenis_layanan == 'baru')
                <li>
                    Password yang tercantum merupakan <strong>Password Awal</strong>. Demi keamanan, segera lakukan
                    perubahan password setelah berhasil login pertama kali.
                </li>
            @else
                <li>
                    Password yang tercantum merupakan <strong>Password Baru</strong> dan mulai berlaku setelah layanan
                    ini selesai diproses.
                </li>
            @endif

            <li>
                Gunakan akun email hanya untuk kepentingan kedinasan sesuai ketentuan yang berlaku.
            </li>

            <li>
                Apabila mengalami kendala saat login, silakan menghubungi Administrator Dinas Komunikasi, Informatika,
                Statistik dan Persandian Kabupaten Murung Raya.
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
