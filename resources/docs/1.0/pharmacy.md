@php
    $baseUrl = url('/');
@endphp

# Farmasi
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
- [Cara Membuat / Memproses Data Farmasi](#create-pharmacy)
- [Cara Merubah Data Farmasi](#edit-pharmacy)
- [Cara Menghapus Data Farmasi](#delete-pharmacy)
- [Cara Meng-Unlock Data Farmasi](#unlock-pharmacy)
- [Video](#video)
- [Baca Juga](#baca-juga)

Pada menu farmasi pengguna dapat mengenerate farmasi sakit & farmasi rujukan.

<a name="create-pharmacy">

## [Cara Membuat / Memproses Data Farmasi](#)
1. Pilih menu Farmasi.
2. Pilih tab `Belum Diproses`, secara default sistem akan menampilkan data hari ini

    ![image]({{$baseUrl}}/public/img/docs/pharmacy-2.png)

3. Cari data yang akan diposes. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/filter.png) untuk filter data lebih detail.
4. Klik pada baris data yang akan diproses.
5. Anda akan diarahkan ke halaman baru. Secara default data yang ditampilkan sesuai dengan resep.

    ![image]({{$baseUrl}}/public/img/docs/pharmacy-3.png)

<br>

1. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/create.png) untuk membuat farmasi baru secara manual.

    > {danger.fa-warning} Jika tidak terdapat tombol ![image]({{$baseUrl}}/public/img/docs/create.png) pastikan Anda mempunyai permisi untuk membuat data farmasi.

2. Anda akan diarahkan ke halaman baru. Secara default data yang ditampilkan kosong.

    ![image]({{$baseUrl}}/public/img/docs/pharmacy-4.png)

3. Masukan tanggal transaksi, secara default akan terisi dengan tanggal hari ini.
4. Pilih klinik dengan menekan ikon kaca pembesar.

    ![image]({{$baseUrl}}/public/img/docs/registration-5.png)

5. Pilih No Transaksi Referensi (jika ada)
6. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/add.png) untuk menambahkan data obat.
7. Kemudian isi Produk / Obat, Aturan, dan Aktual Qty resep.

    ![image]({{$baseUrl}}/public/img/docs/pharmacy-5.png)
8. Ulangi langkah 6 untuk menambahkan data lainnya.
9. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/save.png) untuk menyimpan data, atau tekan tombol ![image]({{$baseUrl}}/public/img/docs/back.png) untuk membatalkan & kembali ke halaman sebelumnya.

<a name="edit-pharmacy">

## [Cara Merubah Data Farmasi](#)
Untuk merubah data farmasi yang sudah ada, berikut langkah-langkahnya:
1. Pilih tab `Proses`

    ![image]({{$baseUrl}}/public/img/docs/pharmacy-1.png)

2. Cari terlebih dahulu data yang akan diubah. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/filter.png) untuk filter data lebih detail.
3. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/edit.png) pada baris data yang akan diubah.
4. Anda akan diarahkan ke halaman baru, kemudian ubah data yang ingin diubah.
5. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/save.png) untuk menyimpan perubahan, atau tekan tombol ![image]({{$baseUrl}}/public/img/docs/back.png) untuk membatalkan & kembali ke halaman sebelumnya.

    > {danger.fa-warning} Jika tidak terdapat ikon ![image]({{$baseUrl}}/public/img/docs/edit.png), pastikan Anda mempunyai permisi untuk merubah data farmasi dan data farmasi tidak sedang terkunci.

<a name="delete-pharmacy">

## [Cara Menghapus Data Farmasi](#)
Untuk menghapus data farmasi yang sudah ada, berikut langkah-langkahnya:
1. Pilih tab `Proses`

    ![image]({{$baseUrl}}/public/img/docs/pharmacy-1.png)

2. Cari terlebih dahulu data yang akan dihapus. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/filter.png) untuk filter data lebih detail.
3. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/delete.png) pada baris data yang akan dihapus.
4. Akan tampil popup konfirmasi.

    ![image]({{$baseUrl}}/public/img/docs/delete-confirm.png)

5. Tekan `Ya` untuk menghapus data, atau tekan `Batal` untuk membatalkan proses.

    > {danger.fa-warning} Jika tidak terdapat ikon ![image]({{$baseUrl}}/public/img/docs/delete.png) pastikan Anda mempunyai permisi untuk menghapus data farmasi.

<a name="unlock-pharmacy">

## [Cara Meng-Unlock Data Farmasi](#)
Untuk meng-unlock data farmasi, berikut langkah-langkahnya:
1. Pilih tab `Proses`

    ![image]({{$baseUrl}}/public/img/docs/pharmacy-1.png)

2. Cari terlebih dahulu data yang akan di unlock. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/filter.png) untuk filter data lebih detail.
3. Tekan pada baris yang akan di unlock.
4. Anda akan diarahkan ke halaman baru.
5. Kemudian, tekan tombol ![image]({{$baseUrl}}/public/img/docs/draft.png).
6. Setelah di unlock, Anda dapat merubah data farmasi.

    > {danger.fa-warning} Jika tidak terdapat tombol ![image]({{$baseUrl}}/public/img/docs/draft.png) pastikan Anda mempunyai permisi untuk meng-unlock data farmasi.

<a name="video">

## [Video](#)
<iframe src="https://drive.google.com/file/d/10KWYGwCkoIU8mV5FeW_AZu-I886XiVB2/preview" width="200" height="150" allow="autoplay"></iframe>

<a name="baca-juga">

## [Baca Juga](#)
1. <a href="transaction-overview">Sekilas tentang Menu Transaksi</a>
2. <a href="registration">Farmasi</a>
3. <a href="action">Aksi / Tindak Lanjut</a>
4. <a href="letter">Surat</a>
5. <a href="inventory">Inventory</a>