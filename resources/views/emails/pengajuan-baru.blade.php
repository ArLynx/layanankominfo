<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pengajuan Layanan Baru</title>
</head>

<body style="margin:0;padding:0;background:#f4f6f9;font-family:Arial,Helvetica,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f9;padding:40px 0;">

        <tr>
            <td align="center">

                <table width="650" cellpadding="0" cellspacing="0"
                    style="background:#ffffff;border-radius:10px;overflow:hidden;">

                    {{-- Header --}}
                    <tr>
                        <td style="background:#0F6CBD;padding:25px 30px;color:#ffffff;">

                            <h2 style="margin:0;font-size:24px;">
                                Sistem Layanan Diskominfo
                            </h2>

                            <p style="margin:8px 0 0;font-size:14px;">
                                Kabupaten Murung Raya
                            </p>

                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding:35px;">

                            <h3 style="margin-top:0;color:#0F172A;">

                                Pengajuan Layanan Baru

                            </h3>

                            <p style="line-height:1.8;color:#475569;">

                                Yth.
                                <strong>{{ $data['role'] ?? 'Administrator' }}</strong>,

                                <br><br>

                                Terdapat <strong>pengajuan layanan baru</strong> yang telah diterima oleh
                                Sistem Layanan Diskominfo Kabupaten Murung Raya dan memerlukan proses
                                pemeriksaan lebih lanjut.

                                <br><br>

                                @if (($data['role'] ?? '') == 'Pimpinan')
                                    Pengajuan tersebut telah selesai diperiksa oleh Administrator dan
                                    saat ini memerlukan persetujuan dari Bapak/Ibu Pimpinan sebelum
                                    proses layanan dapat dilanjutkan.
                                @else
                                    Silakan login ke aplikasi untuk melakukan pemeriksaan dokumen
                                    serta menindaklanjuti pengajuan sesuai prosedur pelayanan
                                    yang berlaku.
                                @endif

                            </p>

                            <table width="100%" cellpadding="8" style="margin-top:25px;border-collapse:collapse;">

                                <tr style="background:#F8FAFC;">
                                    <td width="220"><strong>Jenis Layanan</strong></td>
                                    <td>{{ $data['jenis_layanan'] }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Nomor Tiket</strong></td>
                                    <td>{{ $data['nomor_tiket'] }}</td>
                                </tr>

                                <tr style="background:#F8FAFC;">
                                    <td><strong>Instansi</strong></td>
                                    <td>{{ $data['instansi'] }}</td>
                                </tr>

                                <tr>
                                    <td>

                                        <strong>

                                            @if ($data['jenis_layanan'] == 'Email Pribadi')
                                                Nama Pegawai
                                            @else
                                                Penanggung Jawab
                                            @endif

                                        </strong>

                                    </td>

                                    <td>{{ $data['nama'] }}</td>

                                </tr>

                                <tr style="background:#F8FAFC;">
                                    <td><strong>Status</strong></td>
                                    <td>{{ $data['status'] }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Tanggal Pengajuan</strong></td>
                                    <td>

                                        {{ \Carbon\Carbon::parse($data['tanggal'])->translatedFormat('d F Y H:i') }}
                                        WIB

                                    </td>
                                </tr>

                            </table>

                            <div style="margin-top:35px;text-align:center;">

                                <a href="{{ $data['url'] }}"
                                    style="display:inline-block;background:#0F6CBD;color:#ffffff;
                                        text-decoration:none;padding:14px 28px;
                                        border-radius:8px;font-weight:bold;">

                                    @if (($data['role'] ?? '') == 'Pimpinan')
                                        Buka Halaman Persetujuan
                                    @else
                                        Buka Dashboard
                                    @endif

                                </a>

                            </div>

                            <p
                                style="margin-top:18px;
                                    font-size:13px;
                                    color:#64748B;
                                    text-align:center;
                                    line-height:1.7;">

                                Apabila tombol di atas tidak dapat digunakan,
                                silakan login ke
                                <strong>Sistem Layanan Diskominfo Kabupaten Murung Raya</strong>

                                @if (($data['role'] ?? '') == 'Pimpinan')
                                    untuk membuka halaman persetujuan pengajuan.
                                @else
                                    menggunakan akun Administrator untuk melihat detail pengajuan.
                                @endif

                            </p>

                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td
                            style="padding:25px 35px;background:#F8FAFC;border-top:1px solid #E5E7EB;font-size:13px;color:#64748B;line-height:1.8;">

                            Email ini dikirim secara otomatis oleh
                            <strong>Sistem Layanan Diskominfo Kabupaten Murung Raya</strong>.

                            <br><br>

                            Pesan ini bersifat informatif dan tidak menerima balasan.
                            Apabila memerlukan bantuan terkait aplikasi, silakan menghubungi
                            Administrator Sistem Diskominfo Kabupaten Murung Raya.

                            <br><br>

                            © {{ date('Y') }} Dinas Komunikasi, Informatika, Statistik dan Persandian
                            Kabupaten Murung Raya.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>

    </table>

</body>

</html>
