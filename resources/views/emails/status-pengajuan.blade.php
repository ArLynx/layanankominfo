<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Status Pengajuan Layanan</title>
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

                                Status Pengajuan Diperbarui

                            </h3>

                            <p style="line-height:1.8;color:#475569;">

                                Halo <strong>{{ $data['nama'] }}</strong>,

                                <br><br>

                                Status pengajuan layanan Anda telah diperbarui oleh Administrator
                                Sistem Layanan Diskominfo Kabupaten Murung Raya.

                                <br><br>

                                Berikut informasi terbaru mengenai pengajuan Anda.

                            </p>

                            <table width="100%" cellpadding="8"
                                style="margin-top:25px;border-collapse:collapse;">

                                <tr style="background:#F8FAFC">

                                    <td width="220">

                                        <strong>Jenis Layanan</strong>

                                    </td>

                                    <td>

                                        {{ $data['jenis_layanan'] }}

                                    </td>

                                </tr>

                                <tr>

                                    <td>

                                        <strong>Nomor Tiket</strong>

                                    </td>

                                    <td>

                                        {{ $data['nomor_tiket'] }}

                                    </td>

                                </tr>

                                <tr style="background:#F8FAFC">

                                    <td>

                                        <strong>Instansi</strong>

                                    </td>

                                    <td>

                                        {{ $data['instansi'] }}

                                    </td>

                                </tr>

                                <tr>

                                    <td>

                                        <strong>

                                            @if($data['jenis_layanan']=='Email Pribadi')

                                                Nama Pegawai

                                            @else

                                                Penanggung Jawab

                                            @endif

                                        </strong>

                                    </td>

                                    <td>

                                        {{ $data['nama'] }}

                                    </td>

                                </tr>

                                <tr style="background:#F8FAFC">

                                    <td>

                                        <strong>Status Saat Ini</strong>

                                    </td>

                                    <td>

                                        <strong style="color:#0F6CBD;">

                                            {{ $data['status'] }}

                                        </strong>

                                    </td>

                                </tr>

                                <tr>

                                    <td>

                                        <strong>Tanggal Update</strong>

                                    </td>

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

                                    Lihat Detail Pengajuan

                                </a>

                            </div>

                            <p style="margin-top:20px;
                                font-size:13px;
                                color:#64748B;
                                line-height:1.8;
                                text-align:center;">

                                Silakan login ke
                                <strong>Sistem Layanan Diskominfo Kabupaten Murung Raya</strong>
                                untuk melihat perkembangan pengajuan serta informasi lainnya.

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

                            Mohon tidak membalas email ini.
                            Apabila memerlukan bantuan terkait layanan, silakan menghubungi
                            Administrator Diskominfo Kabupaten Murung Raya.

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