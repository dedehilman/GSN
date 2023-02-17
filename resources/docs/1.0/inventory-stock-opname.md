@php
    $baseUrl = url('/');
@endphp

# Stok Opname
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
- [Cara Membuat Stok Opname Baru](#create-stock-opname)
- [Cara Merubah Data Stok Opname](#edit-stock-opname)
- [Cara Menghapus Data Stok Opname](#delete-stock-opname)
- [Cara Melakukan Upload Data Stok Opname](#upload-stock-opname)
- [Baca Juga](#baca-juga)

Menu stok opname ini digunakan untuk mengelola stok akhir pada suatu periode di suatu klinik, dan nantinya akan digunakan sebagai stok awal untuk periode berikutnya.

<a name="create-stock-opname">

## [Cara Membuat Stok Opname Baru](#)
1. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/create.png) untuk membuat stok opname baru.

    > {danger.fa-warning} Jika tidak terdapat tombol ![image]({{$baseUrl}}/public/img/docs/create.png) pastikan Anda mempunyai permisi untuk membuat data stock opname.

2. Pilih data Periode dengan menekan ikon kaca pembesar

    ![image]({{$baseUrl}}/public/img/docs/stock-opname-1.png)

3. Pilih data Produk dengan menekan ikon kaca pembesar

    ![image]({{$baseUrl}}/public/img/docs/stock-opname-2.png)

4. Pilih data klinik dengan menekan ikon kaca pembesar

    ![image]({{$baseUrl}}/public/img/docs/periode-4.png)
5. Isikan qty
6. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/save.png) untuk menyimpan data, atau tekan tombol ![image]({{$baseUrl}}/public/img/docs/back.png) untuk membatalkan & kembali ke halaman sebelumnya.

<a name="edit-stock-opname">

## [Cara Merubah Data Stok Opname](#)
Untuk merubah data stock opname yang sudah ada, berikut langkah-langkahnya:
1. Cari terlebih dahulu data yang akan diubah. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/filter.png) untuk filter data lebih detail.
2. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/edit.png) pada baris data yang akan diubah.
3. Anda akan diarahkan ke halaman baru, kemudian ubah data yang ingin diubah.
4. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/save.png) untuk menyimpan perubahan, atau tekan tombol ![image]({{$baseUrl}}/public/img/docs/back.png) untuk membatalkan & kembali ke halaman sebelumnya.

    > {danger.fa-warning} Jika tidak terdapat ikon ![image]({{$baseUrl}}/public/img/docs/edit.png), pastikan Anda mempunyai permisi untuk merubah data stock-opname.

<a name="delete-stock-opname">

## [Cara Menghapus Data Stok Opname](#)
Untuk menghapus data stock opname yang sudah ada, berikut langkah-langkahnya:
1. Cari terlebih dahulu data yang akan dihapus. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/filter.png) untuk filter data lebih detail.
2. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/delete.png) pada baris data yang akan dihapus.
3. Akan tampil popup konfirmasi.

    ![image]({{$baseUrl}}/public/img/docs/delete-confirm.png)

4. Tekan `Ya` untuk menghapus data, atau tekan `Batal` untuk membatalkan proses.

    > {danger.fa-warning} Jika tidak terdapat ikon ![image]({{$baseUrl}}/public/img/docs/delete.png) pastikan Anda mempunyai permisi untuk menghapus data stock opname.

<a name="upload-stok-opname">

## [Cara Melakukan Upload Data Stok Opname](#)
Untuk melakukan upload stok opname, berikut langkah-langkahnya:
1. Pilih menu `Inventory` -> `Stok Opname Upl`.
2. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/download-template.png) untuk mendownload template excel.
3. Jika data yang akan diuplaod sudah siap, takan inputan `Pilih File`.

    ![image]({{$baseUrl}}/public/img/docs/browse-file.png)

4. Cari dan pilih file yang akan diupload, kemudian tekan ![image]({{$baseUrl}}/public/img/docs/upload.png)
5. Anda akan dialihkan ke halaman baru.
6. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/validate.png) untuk memvalidasi data yang diupload.
7. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/commit.png) untuk menyimpan data yang diupload.

    > {danger.fa-warning} Tombol ![image]({{$baseUrl}}/public/img/docs/commit.png) bisa diklik jika semua data valid.

8. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/back.png) untu kembali ke halaman sebelumnya.

<a name="baca-juga">

## [Baca Juga](#)
1. <a href="inventory-periode">Periode</a>
2. <a href="inventory-stock-transaction">Transaksi</a>