@php
    $baseUrl = url('/');
@endphp

# Sekilas tentang Menu Laporan
<small><i class="far fa-calendar mr-2"></i>17 Feb 2023 <i class="far fa-user mr-2 ml-2"></i>Admin <i class="fas fa-print mr-2 ml-2"></i><a href="" onclick="print()">Print</a></small>
<script>
    function print() {
        var divContents = document.getElementsByClassName("documentation")[0].innerHTML;
        var a = window.open('', '', 'height=500, width=500');
        a.document.write(divContents);
        a.document.close();
        a.print();
    }
</script>

---
- [Cara Mendowload Laporan](#cara-download)

Pada menu laporan pengguna dapat mencetak laporan yang dibutuhkan secara realtime. Anda dapat mencetak laporan dibawah:
<table>
    <tr style="background-color: lightgrey;">
        <th>No</th>
        <th>Nama</th>
        <th>Deskripsi</th>
    </tr>
    <tr>
        <td>1</td>
        <td>Stok</td>
        <td>Berupa laporan summary masuk, keluar, dan farmasi produk per produk per klinik pada periode tertentu, disajikan juga stok akhir untuk masing-masing produk</td>
    </tr>
    <tr>
        <td>2</td>
        <td>Inventory</td>
        <td>Laporan detail transaksi mutasi inventory (Masuk, Transfer In, Transfer Out, Penyesuaian)</td>
    </tr>
    <tr>
        <td>3</td>
        <td>Farmasi</td>
        <td>Laporan detail transaksi keluar dari farmasi</td>
    </tr>
    <tr>
        <td>4</td>
        <td>KB, KK, PP, Rawat jalan</td>
        <td>Laporan transaksi berobat pasien (KB, KK, PP, Rawat jalan), aksi, resep, diagnosa</td>
    </tr>
    <tr>
        <td>5</td>
        <td>Riwayat Pengobatan</td>
        <td>Laporan detail rekam medis pasien</td>
    </tr>
    <tr>
        <td>6</td>
        <td>Surat Sakit & Rujukan</td>
        <td>Laporan penerbitan surat sakit & rujukan</td>
    </tr>
</table>

<a name="cara-download">

## [Cara Mendowload Laporan](#)
Untuk mendownload / mencetak laporan diatas, Anda pilih sub-menu laporan yang diinginkan, kemudian:
1. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/create.png) untuk membuat pendaftaran baru.

    > {danger.fa-warning} Jika tidak terdapat tombol ![image]({{$baseUrl}}/public/img/docs/create.png) pastikan Anda mempunyai permisi untuk mengenerate laporan.

2. Isi paramater yang tersedia.
3. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/save.png) untuk menyimpan data, atau tekan tombol ![image]({{$baseUrl}}/public/img/docs/back.png) untuk membatalkan & kembali ke halaman sebelumnya.
4. Tunggu proses generate laporan hingga status berubah menjadi `Selesai`.
5. Klik pada baris report, Anda akan diarahkan ke halaman baru.
6. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/download.png) untuk mendownload laporan.