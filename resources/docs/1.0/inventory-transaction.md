@php
    $baseUrl = url('/');
@endphp

# Stok Transaksi
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
- [Cara Membuat Stok Transaksi Baru](#create-stock-transaction)
- [Cara Merubah Data Stok Transaksi](#edit-stock-transaction)
- [Cara Menghapus Data Stok Transaksi](#delete-stock-transaction)
- [Baca Juga](#baca-juga)

Menu transaksi digunakan untuk mencatat semua transaksi stok masuk, keluar, transfer masuk, transfer keluar, dan penyesuaian (jika diperlukan).

<a name="create-stock-transaction">

## [Cara Membuat Stok Transaksi Baru](#)
1. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/create.png) untuk membuat stok transaksi baru.

    > {danger.fa-warning} Jika tidak terdapat tombol ![image]({{$baseUrl}}/public/img/docs/create.png) pastikan Anda mempunyai permisi untuk membuat data stok transaksi.

2. Pilih jenis transaksi

    ![image]({{$baseUrl}}/public/img/docs/stock-transaction-1.png)

    > {danger.fa-warning} `Masuk` barang masuk dari vendor ke klinik.<br>`Transfer Masuk` barang masuk dari klinik A ke kelinik B.<br>`Transfer Keluar` barang keluar dari klinik A ke klinik B.<br>`Penyesuian` untuk menyesuaikan qty barang agar sesuai dengan data di lapangan.

3. Pilih data klinik dengan menekan ikon kaca pembesar

    ![image]({{$baseUrl}}/public/img/docs/registration-5.png)

4. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/add.png) untuk menambahkan detail transaksi.
3. Kemudian isi Produk / Obat, dan Qty.

    ![image]({{$baseUrl}}/public/img/docs/stock-transaction-2.png)
4. Ulangi langkah 4 untuk menambahkan detail lainnya.
6. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/save.png) untuk menyimpan data, atau tekan tombol ![image]({{$baseUrl}}/public/img/docs/back.png) untuk membatalkan & kembali ke halaman sebelumnya.

<a name="edit-stock-transaction">

## [Cara Merubah Data Stok Transaksi](#)
Untuk merubah data stok transaksi yang sudah ada, berikut langkah-langkahnya:
1. Cari terlebih dahulu data yang akan diubah. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/filter.png) untuk filter data lebih detail.
2. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/edit.png) pada baris data yang akan diubah.
3. Anda akan diarahkan ke halaman baru, kemudian ubah data yang ingin diubah.
4. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/save.png) untuk menyimpan perubahan, atau tekan tombol ![image]({{$baseUrl}}/public/img/docs/back.png) untuk membatalkan & kembali ke halaman sebelumnya.

    > {danger.fa-warning} Jika tidak terdapat ikon ![image]({{$baseUrl}}/public/img/docs/edit.png), pastikan Anda mempunyai permisi untuk merubah data stock-transaction.

<a name="delete-stock-transaction">

## [Cara Menghapus Data Stok Transaksi](#)
Untuk menghapus data stok transaksi yang sudah ada, berikut langkah-langkahnya:
1. Cari terlebih dahulu data yang akan dihapus. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/filter.png) untuk filter data lebih detail.
2. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/delete.png) pada baris data yang akan dihapus.
3. Akan tampil popup konfirmasi.

    ![image]({{$baseUrl}}/public/img/docs/delete-confirm.png)

4. Tekan `Ya` untuk menghapus data, atau tekan `Batal` untuk membatalkan proses.

    > {danger.fa-warning} Jika tidak terdapat ikon ![image]({{$baseUrl}}/public/img/docs/delete.png) pastikan Anda mempunyai permisi untuk menghapus data stok transaksi.

<a name="baca-juga">

## [Baca Juga](#)
1. <a href="inventory-periode">Periode</a>
2. <a href="inventory-stock-opname">Stok Opname</a>