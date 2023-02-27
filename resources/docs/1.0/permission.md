@php
    $baseUrl = url('/');
@endphp

# Sekilas tentang Menu Permission
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
- [Cara Membuat Permission Baru](#create-permission)
- [Cara Merubah Data Permission](#edit-permission)
- [Cara Menghapus Data Permission](#delete-permission)
- [Baca Juga](#baca-juga)

Digunakan untuk mendaftarkan / mengatur permission yang digunakan pada sistem. Secara default akan terdapat permisi dengan pola sebagai berikut:
<table>
    <tr style="background-color: lightgrey;">
        <th>No</th>
        <th>Nama</th>
        <th>Deskripsi</th>
    </tr>
    <tr>
        <td>1</td>
        <td>namaModule-list</td>
        <td>Hak akses untuk melihat data dari modul tersebut</td>
    </tr>
    <tr>
        <td>2</td>
        <td>namaModule-create</td>
        <td>Hak akses untuk membuat / menambahkan data baru dari modul tersebut</td>
    </tr>
    <tr>
        <td>3</td>
        <td>namaModule-edit</td>
        <td>Hak akses untuk merubah data yang ada dari modul tersebut</td>
    </tr>
    <tr>
        <td>4</td>
        <td>namaModule-delete</td>
        <td>Hak akses untuk menghapus data yang ada dari modul tersebut</td>
    </tr>
</table>
Bisa juga terdapat pola permisi yang lain yang digunakan pada sistem.

> {danger.fa-warning} Dimohon untuk tidak mengahapus / merubah data permission yang sudah ada. Ketika membuat data permission baru tidak akan berpengaruh pada sistem karena harus ada proses coding terlebih dahulu.

<a name="create-permission">

## [Cara Membuat Permission Baru](#)
1. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/create.png) untuk membuat permission baru.

    > {danger.fa-warning} Jika tidak terdapat tombol ![image]({{$baseUrl}}/public/img/docs/create.png) pastikan Anda mempunyai permisi untuk membuat data permission.

2. Masukan nama permission
3. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/save.png) untuk menyimpan data, atau tekan tombol ![image]({{$baseUrl}}/public/img/docs/back.png) untuk membatalkan & kembali ke halaman sebelumnya.

<a name="edit-permission">

## [Cara Merubah Data Permission](#)
Untuk merubah data permission yang sudah ada, berikut langkah-langkahnya:
1. Cari terlebih dahulu data yang akan diubah. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/filter.png) untuk filter data lebih detail.
2. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/edit.png) pada baris data yang akan diubah.
3. Anda akan diarahkan ke halaman baru, kemudian ubah data yang ingin diubah.

    > {danger.fa-warning} Untuk data yang di encrypt tidak dapat diganti, misal jadi tidak diencrypt. Disarankan hapus data permission terlebih dahulu kemudian buat permission baru.

4. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/save.png) untuk menyimpan perubahan, atau tekan tombol ![image]({{$baseUrl}}/public/img/docs/back.png) untuk membatalkan & kembali ke halaman sebelumnya.

    > {danger.fa-warning} Jika tidak terdapat ikon ![image]({{$baseUrl}}/public/img/docs/edit.png), pastikan Anda mempunyai permisi untuk merubah data permission.

<a name="delete-permission">

## [Cara Menghapus Data Permission](#)
Untuk menghapus data permission yang sudah ada, berikut langkah-langkahnya:
1. Cari terlebih dahulu data yang akan dihapus. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/filter.png) untuk filter data lebih detail.
2. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/delete.png) pada baris data yang akan dihapus.
3. Akan tampil popup konfirmasi.

    ![image]({{$baseUrl}}/public/img/docs/delete-confirm.png)

4. Tekan `Ya` untuk menghapus data, atau tekan `Batal` untuk membatalkan proses.

    > {danger.fa-warning} Jika tidak terdapat ikon ![image]({{$baseUrl}}/public/img/docs/delete.png) pastikan Anda mempunyai permisi untuk menghapus data permission.

<a name="baca-juga">

## [Baca Juga](#)
1. <a href="record-rule">Record Rule</a>