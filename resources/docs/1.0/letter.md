@php
    $baseUrl = url('/');
@endphp

# Surat
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
- [Cara Membuat Surat Baru](#create-letter)
- [Cara Merubah Data Surat](#edit-letter)
- [Cara Menghapus Data Surat](#delete-letter)
- [Video](#video)
- [Baca Juga](#baca-juga)

Pada menu surat pengguna dapat mengenerate surat sakit & surat rujukan.

<a name="create-letter">

## [Cara Membuat Surat Baru](#)
1. Pilih menu Surat.
2. Kemudian pilih sub-menu yang sesuai dengan surat yang akan dibuat.

    ![image]({{$baseUrl}}/public/img/docs/letter-1.png)

3. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/create.png) untuk membuat surat baru.

    > {danger.fa-warning} Jika tidak terdapat tombol ![image]({{$baseUrl}}/public/img/docs/create.png) pastikan Anda mempunyai permisi untuk membuat data surat.

4. Pilih data pasien dengan menekan ikon kaca pembesar

    ![image]({{$baseUrl}}/public/img/docs/registration-3.png)

    > {danger.fa-warning} Pastikan pasien telah terdaftar pada sistem, jika belum maka harus didaftarkan terlebih dahulu <a href="{{$baseUrl}}/master/employee">disini</a>.<br><br>Centang `Untuk Relasi` jika yang berobat adalah relasi / keluarga, kemudian pilih relasi dari pasien. Pastikan relasi pasien telah terdaftar pada sistem, jika belum maka harus didaftarkan terlebih dahulu <a href="{{$baseUrl}}/master/employee">disini</a>.
5. Masukan tanggal berobat, secara default akan terisi dengan tanggal hari ini.
6. Pilih klinik dengan menekan ikon kaca pembesar.

    ![image]({{$baseUrl}}/public/img/docs/registration-5.png)

7. Pilih tenaga medis yang bertanggung jawab atas diterbitkannya surat.

    ![image]({{$baseUrl}}/public/img/docs/registration-6.png)
8. Isi informasi lainnya
9. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/save.png) untuk menyimpan data, atau tekan tombol ![image]({{$baseUrl}}/public/img/docs/back.png) untuk membatalkan & kembali ke halaman sebelumnya.

<a name="edit-letter">

## [Cara Merubah Data Surat](#)
Untuk merubah data surat yang sudah ada, berikut langkah-langkahnya:
1. Cari terlebih dahulu data yang akan diubah. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/filter.png) untuk filter data lebih detail.
2. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/edit.png) pada baris data yang akan diubah.
3. Anda akan diarahkan ke halaman baru, kemudian ubah data yang ingin diubah.
4. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/save.png) untuk menyimpan perubahan, atau tekan tombol ![image]({{$baseUrl}}/public/img/docs/back.png) untuk membatalkan & kembali ke halaman sebelumnya.

    > {danger.fa-warning} Jika tidak terdapat ikon ![image]({{$baseUrl}}/public/img/docs/edit.png), pastikan Anda mempunyai permisi untuk merubah data surat.

<a name="delete-letter">

## [Cara Menghapus Data Surat](#)
Untuk menghapus data surat yang sudah ada, berikut langkah-langkahnya:
1. Cari terlebih dahulu data yang akan dihapus. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/filter.png) untuk filter data lebih detail.
2. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/delete.png) pada baris data yang akan dihapus.
3. Akan tampil popup konfirmasi.

    ![image]({{$baseUrl}}/public/img/docs/delete-confirm.png)

4. Tekan `Ya` untuk menghapus data, atau tekan `Batal` untuk membatalkan proses.

    > {danger.fa-warning} Jika tidak terdapat ikon ![image]({{$baseUrl}}/public/img/docs/delete.png) pastikan Anda mempunyai permisi untuk menghapus data surat.

<a name="video">

## [Video](#)
<iframe src="https://drive.google.com/file/d/1CLDq_0-mFSSWw_usRiVQMx4wxOUKxWPJ/preview" width="200" height="150" allow="autoplay"></iframe>
<iframe src="https://drive.google.com/file/d/1audQmKq2P7ZqX4zFLw6mXNgAc7XJR2az/preview" width="200" height="150" allow="autoplay"></iframe>

<a name="baca-juga">

## [Baca Juga](#)
1. <a href="transaction-overview">Sekilas tentang Menu Transaksi</a>
2. <a href="registration">Pendaftaran</a>
3. <a href="action">Aksi / Tindak Lanjut</a>
4. <a href="pharmacy">Farmasi</a>
5. <a href="inventory">Inventory</a>