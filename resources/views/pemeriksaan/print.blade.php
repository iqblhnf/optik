<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Form Pemeriksaan Mata</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 14px;
        }

        .wrapper {
            border: 1px solid #000;
            padding: 10px;
            margin: 0 auto;
            background: #fff;
            position: relative; /* untuk posisi absolute footer kiri bawah */
        }

        .container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .left,
        .right {
            width: 48%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            /* margin-bottom: 10px; */
        }

        td,
        th {
            border: 1px solid #000;
            padding: 5px 6px;
            vertical-align: top;
        }

        .rekam-medis-box {
            border: 1px solid #000;
            width: 20px;
            height: 20px;
            display: inline-block;
            text-align: center;
            line-height: 20px;
            margin-right: 2px;
        }

        /* Tambahan untuk pojok kiri bawah */
        .footer-left {
            position: absolute;
            bottom: 10px;
            left: 10px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="wrapper">
        <!-- Bagian Atas: Rekam Medis dan Anamnesa -->
        <div class="container">
            <div class="left">
                <table>
                    <tr>
                        <td>No. Rekam Medis</td>
                        <td>
                            @foreach(str_split($pemeriksaan->id) as $digit)
                            <div class="rekam-medis-box">{{ $digit }}</div>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>{{ $pemeriksaan->anamnesa->pasien->nama }}</td>
                    </tr>
                    <tr>
                        <td>Usia</td>
                        <td>{{ $pemeriksaan->anamnesa->pasien->usia }}</td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>{{ $pemeriksaan->anamnesa->pasien->jenis_kelamin }}</td>
                    </tr>
                    <tr>
                        <td>Pekerjaan</td>
                        <td>{{ $pemeriksaan->anamnesa->pasien->pekerjaan }}</td>
                    </tr>
                    <tr>
                        <td>Alamat & No. Telp</td>
                        <td>{{ $pemeriksaan->anamnesa->pasien->alamat }} / {{ $pemeriksaan->anamnesa->pasien->no_telp }}</td>
                    </tr>
                </table>
            </div>

            <div class="right">
                <table>
                    <tr>
                        <td colspan="2"><strong>ANAMNESA</strong></td>
                    </tr>
                    <tr>
                        <td>Jauh</td>
                        <td>: {{ $pemeriksaan->anamnesa->jauh }}</td>
                    </tr>
                    <tr>
                        <td>Dekat</td>
                        <td>: {{ $pemeriksaan->anamnesa->dekat }}</td>
                    </tr>
                    <tr>
                        <td>Gen</td>
                        <td>: {{ $pemeriksaan->anamnesa->gen }}</td>
                    </tr>
                    <tr>
                        <td>Riwayat</td>
                        <td>: {{ $pemeriksaan->anamnesa->riwayat }}</td>
                    </tr>
                    <tr>
                        <td>Lainnya</td>
                        <td>: {{ $pemeriksaan->anamnesa->lainnya }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Bagian Bawah: Pemeriksaan Kacamata Lama dan Visus -->
        <div class="container">
            <div class="left">
                <table>
                    <tr>
                        <td colspan="7" style="text-align: center;"><strong>PEMERIKSAAN KACAMATA LAMA</strong></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td></td>
                        <td><strong>SPH</strong></td>
                        <td><strong>CYL</strong></td>
                        <td><strong>AXIS</strong></td>
                        <td><strong>PRISMA</strong></td>
                        <td><strong>BASE</strong></td>
                        <td><strong>ADD</strong></td>
                    </tr>
                    <tr>
                        <td><strong>OD</strong></td>
                        <td>{{ $previous->od_sph ?? '' }}</td>
                        <td>{{ $previous->od_cyl ?? '' }}</td>
                        <td>{{ $previous->od_axis ?? '' }}</td>
                        <td>{{ $previous->od_prisma ?? '' }}</td>
                        <td>{{ $previous->od_base ?? '' }}</td>
                        <td>{{ $previous->od_add ?? '' }}</td>
                    </tr>
                    <tr>
                        <td><strong>OS</strong></td>
                        <td>{{ $previous->os_sph ?? '' }}</td>
                        <td>{{ $previous->os_cyl ?? '' }}</td>
                        <td>{{ $previous->os_axis ?? '' }}</td>
                        <td>{{ $previous->os_prisma ?? '' }}</td>
                        <td>{{ $previous->os_base ?? '' }}</td>
                        <td>{{ $previous->os_add ?? '' }}</td>
                    </tr>
                </table>
                <p><strong>Keterangan untuk kacamata lama : </strong>{{ $previous->keterangan_kacamata_lama ?? '' }}</p>
            </div>

            <div class="right">
                <p style="margin-top: 0;">Status Kacamata Lama :
                    <em>{{ $previous->status_kacamata_lama ?? '' }}</em>
                </p>
                <p><strong>Penentuan visus ODS dengan KM Lama :</strong></p>
                <p>OD : </p>
                <p>OS : </p>
            </div>
        </div>

        <!-- Bagian Tambahan: Hasil Pemeriksaan -->
        <div style="display: flex; justify-content: center;">
            <div style="width: 80%;">
                <table>
                    <tr>
                        <td colspan="10" style="text-align:center;"><strong>HASIL PEMERIKSAAN</strong></td>
                    </tr>
                    <tr style="text-align:center;">
                        <td rowspan="2"></td>
                        <td colspan="3"><strong>OD</strong></td>
                        <td colspan="3"><strong>OS</strong></td>
                        <td><strong>BINOCULER</strong></td>
                    </tr>
                    <tr style="text-align:center;">
                        <td><strong>SPH</strong></td>
                        <td><strong>CYL</strong></td>
                        <td><strong>AXIS</strong></td>
                        <td><strong>SPH</strong></td>
                        <td><strong>CYL</strong></td>
                        <td><strong>AXIS</strong></td>
                        <td><strong>PD</strong></td>
                    </tr>
                    <tr>
                        <td><strong>DISTANCE</strong></td>
                        <td>{{ $pemeriksaan->od_sph }}</td>
                        <td>{{ $pemeriksaan->od_cyl }}</td>
                        <td>{{ $pemeriksaan->od_axis }}</td>
                        <td>{{ $pemeriksaan->os_sph }}</td>
                        <td>{{ $pemeriksaan->os_cyl }}</td>
                        <td>{{ $pemeriksaan->os_axis }}</td>
                        <td>{{ $pemeriksaan->binoculer_pd }}</td>
                    </tr>
                    <tr>
                        <td><strong>NEAR</strong></td>
                        <td colspan="1" style="text-align:center;"><strong>ADD</strong></td>
                        <td colspan="2">{{ $pemeriksaan->od_add }}</td>
                        <td colspan="1" style="text-align:center;"><strong>ADD</strong></td>
                        <td colspan="2">{{ $pemeriksaan->os_add }}</td>
                        <td></td>
                    </tr>
                </table>

                <!-- Pilihan Tambahan -->
                <div style="display: flex; justify-content: space-between;">
                    <div>
                        <div>❖ DISTANCE ONLY</div>
                        <div>❖ READERS ONLY</div>
                    </div>
                    <div>
                        <div>❖ BIFOCAL</div>
                        <div>❖ PROGRESSIVE</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bagian Tambahan: Diagnosa Kasus -->
        <div style="margin-top: 20px;">
            <div class="left" style="width: 100%;">
                <table style="border: none;">
                    <tr>
                        <td colspan="3" style="border: none;"><strong>DIAGNOSA KASUS</strong></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="border: none; padding-left: 50px;">Ternyata penderita mengalami</td>
                    </tr>
                    <tr>
                        <td style="border: none; width: 0; padding-left: 80px;">❖</td>
                        <td style="border: none; width: 40px; vertical-align: bottom;">OD</td>
                        <td style="border: none; vertical-align: middle;">:</td>
                    </tr>
                    <tr>
                        <td style="border: none; padding-left: 80px;">❖</td>
                        <td style="border: none; width: 40px; vertical-align: bottom;">OS</td>
                        <td style="border: none; vertical-align: middle;">:</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Bagian Tambahan: Saran dan Tanda Tangan -->
        <div class="container">
            <div class="left" style="width: 100%;">
                <table style="border: none; font-size: 14px; width: 100%; margin-bottom: 0;">
                    <tr>
                        <td style="border: none;">❖ <strong>Saran untuk pasien :</strong></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td style="border: none; padding-left: 40px;">○</td>
                        <td style="border: none;">
                            Pasien disarankan untuk memeriksakan mata setiap enam bulan sekali atau satu tahun sekali
                            untuk memeriksakan ukuran yang dipakai apakah masih tetap atau telah berubah.
                        </td>
                    </tr>
                </table>

                <div style="margin-top: 40px; text-align: center;">
                    <div style="border-top: 1px solid #000; margin-bottom: 10px;"></div>
                    <p style="margin: 0;">BANDAR JAYA, {{ now()->translatedFormat('d F Y') }}</p>
                </div>

                <div style="margin-top: 80px; text-align: center;">
                    <p style="margin: 0;">Tanda Tangan RO</p>
                </div>
            </div>
        </div>

        <!-- Tambahan Footer Nama Petugas di pojok kiri bawah -->
        <div class="footer-left">
            <p style="margin: 0;">Nama Petugas</p>
            <p style="margin: 0;">{{ $pemeriksaan->petugas->kode_user ?? '-' }}</p>
        </div>
    </div>

</body>

</html>