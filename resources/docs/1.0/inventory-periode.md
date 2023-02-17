@php
    $baseUrl = url('/');
@endphp

# Periode
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
- [Cara Membuat Periode Baru](#create-periode)
- [Cara Merubah Data Periode](#edit-periode)
- [Cara Menghapus Data Periode](#delete-periode)
- [Cara Melakukan Stok Taking](#stok-taking)
- [Baca Juga](#baca-juga)

Menu periode ini digunakan untuk mengelola periode perhitungan stok.
<a name="create-periode">

## [Cara Membuat Periode Baru](#)
1. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/create.png) untuk membuat periode baru.

    > {danger.fa-warning} Jika tidak terdapat tombol ![image]({{$baseUrl}}/public/img/docs/create.png) pastikan Anda mempunyai permisi untuk membuat data periode.

2. Isi kode, nilai ini unik tidak boleh ada data yang sama

    ![image]({{$baseUrl}}/public/img/docs/periode-1.png)

3. Isi nama

    ![image]({{$baseUrl}}/public/img/docs/periode-2.png)

4. Isi Tanggal Mulai & Tanggal Selesai

    ![image]({{$baseUrl}}/public/img/docs/periode-3.png)

    > {danger.fa-warning} `Tanggal Mulai` & `Tanggal Selesai` digunakan sebagai parameter rentang tanggal data stok yang akan dihitung (Masuk, Keluar, Transfer Masuk, Transfer Keluar, Penyesuaian, Farmasi) ketika dilakukan stok opname. Stok awal akan diambil dari data `Stok Opaname` yang klinik nya sama dan periode sebelumnya yang `Tanggal Selesai` nya lebih kecil dari `Tanggal Mulai` periode sekarang

5. Pilih data klinik dengan menekan ikon kaca pembesar

    ![image]({{$baseUrl}}/public/img/docs/periode-4.png)

6. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/save.png) untuk menyimpan data, atau tekan tombol ![image]({{$baseUrl}}/public/img/docs/back.png) untuk membatalkan & kembali ke halaman sebelumnya.

<a name="edit-periode">

## [Cara Merubah Data Periode](#)
Untuk merubah data periode yang sudah ada, berikut langkah-langkahnya:
1. Cari terlebih dahulu data yang akan diubah. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/filter.png) untuk filter data lebih detail.
2. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/edit.png) pada baris data yang akan diubah.
3. Anda akan diarahkan ke halaman baru, kemudian ubah data yang ingin diubah.
4. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/save.png) untuk menyimpan perubahan, atau tekan tombol ![image]({{$baseUrl}}/public/img/docs/back.png) untuk membatalkan & kembali ke halaman sebelumnya.

    > {danger.fa-warning} Jika tidak terdapat ikon ![image]({{$baseUrl}}/public/img/docs/edit.png), pastikan Anda mempunyai permisi untuk merubah data periode.

<a name="delete-periode">

## [Cara Menghapus Data Periode](#)
Untuk menghapus data periode yang sudah ada, berikut langkah-langkahnya:
1. Cari terlebih dahulu data yang akan dihapus. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/filter.png) untuk filter data lebih detail.
2. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/delete.png) pada baris data yang akan dihapus.
3. Akan tampil popup konfirmasi.

    ![image]({{$baseUrl}}/public/img/docs/delete-confirm.png)

4. Tekan `Ya` untuk menghapus data, atau tekan `Batal` untuk membatalkan proses.

    > {danger.fa-warning} Jika tidak terdapat ikon ![image]({{$baseUrl}}/public/img/docs/delete.png) pastikan Anda mempunyai permisi untuk menghapus data periode.

<a name="stok-taking">

## [Cara Melakukan Stok Taking](#)
Untuk melakukan stok taking, berikut langkah-langkahnya:
1. Cari terlebih dahulu periode yang akan dilakukan stok taking. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/filter.png) untuk filter data lebih detail.
2. Tekan pada baris data yang akan dilakukan stok taking.
3. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/stock-taking.png) untuk mulai menghitung stok taking.
4. Anda akan dirahkan ke halaman baru

    ![image]({{$baseUrl}}/public/img/docs/stock-taking-1.png)

5. Sebelum di simpan, Anda juga dapat mendowload terlebih dahulu hasil dari perhitungan stok taking.
6. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/save.png) untuk menyimpan data hasil stok taking, atau tekan tombol ![image]({{$baseUrl}}/public/img/docs/back.png) untuk membatalkan & kembali ke halaman sebelumnya.

<a name="baca-juga">

## [Baca Juga](#)
1. <a href="inventory-stock-opname">Stok Opname</a>
2. <a href="inventory-stock-transaction">Transaksi</a>