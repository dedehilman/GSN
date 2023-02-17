@php
    $baseUrl = url('/');
@endphp

# Pendaftaran
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
- [Cara Mendaftar Berobat](#create-registration)
- [Cara Merubah Data Pendaftaran](#edit-registration)
- [Cara Menghapus Data Pendaftaran](#delete-registration)
- [Cara Meng-Unlock Data Pendaftaran](#unlock-registration)
- [Baca Juga](#baca-juga)

Menu ini digunakan untuk melakukan pendaftaran semua transaksi (Rawat Jalan, KK, KB, PP) yang nantinya akan ditindak lanjuti oleh tenaga medis terkait.

<a name="create-registration">

## [Cara Mendaftar Berobat](#)
1. Pilih menu pendaftaran.
2. Kemudian pilih sub-menu yang sesuai dengan poli yang dituju.

    ![image]({{$baseUrl}}/public/img/docs/registration-1.png)

3. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/create.png) untuk membuat pendaftaran baru.

    > {danger.fa-warning} Jika tidak terdapat tombol ![image]({{$baseUrl}}/public/img/docs/create.png) pastikan Anda mempunyai permisi untuk membuat data pendaftaran.

4. Pilih data pasien dengan menekan ikon kaca pembesar

    ![image]({{$baseUrl}}/public/img/docs/registration-3.png)

    > {danger.fa-warning} Pastikan pasien telah terdaftar pada sistem, jika belum maka harus didaftarkan terlebih dahulu <a href="{{$baseUrl}}/master/employee">disini</a>.<br><br>Centang `Untuk Relasi` jika yang berobat adalah relasi / keluarga, kemudian pilih relasi dari pasien. Pastikan relasi pasien telah terdaftar pada sistem, jika belum maka harus didaftarkan terlebih dahulu <a href="{{$baseUrl}}/master/employee">disini</a>.
5. Masukan tanggal berobat, secara default akan terisi dengan tanggal hari ini.
6. Pilih jenis referensi.

    ![image]({{$baseUrl}}/public/img/docs/registration-4.png)

    > {danger.fa-warning} `Non Rujukan` pasien yang berobat non rujukan.<br>`Internal` pasien yang dirujuk dari klinik.<br>`External` pasien yang dirujuk dari luar selain klinik (contohnya: bidan, rumah sakit), lihat referensi external <a href="{{$baseUrl}}/master/reference">disini</a>.
7. Pilih klinik dengan menekan ikon kaca pembesar.

    ![image]({{$baseUrl}}/public/img/docs/registration-5.png)

8. Pilih tenaga medis yang akan menindak lanjuti pasien dengan menekan ikon kaca pembesar.

    ![image]({{$baseUrl}}/public/img/docs/registration-6.png)

9. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/save.png) untuk menyimpan data, atau tekan tombol ![image]({{$baseUrl}}/public/img/docs/back.png) untuk membatalkan & kembali ke halaman sebelumnya.
10. Selamat, Anda telah berhasil membuat pendaftaran baru.

<a name="edit-registration">

## [Cara Merubah Data Pendaftaran](#)
Untuk merubah data pendaftaran yang sudah ada, berikut langkah-langkahnya:
1. Cari terlebih dahulu data yang akan diubah. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/filter.png) untuk filter data lebih detail.
2. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/edit.png) pada baris data yang akan diubah.
3. Anda akan diarahkan ke halaman baru, kemudian ubah data yang ingin diubah.
4. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/save.png) untuk menyimpan perubahan, atau tekan tombol ![image]({{$baseUrl}}/public/img/docs/back.png) untuk membatalkan & kembali ke halaman sebelumnya.

    > {danger.fa-warning} Jika tidak terdapat ikon ![image]({{$baseUrl}}/public/img/docs/edit.png) atau anda tidak bisa merubah data pendaftaran, pastikan Anda mempunyai permisi untuk merubah data pendaftaran dan data pendaftaran tidak sedang terkunci.

<a name="delete-registration">

## [Cara Menghapus Data Pendaftaran](#)
Untuk menghapus data pendaftaran yang sudah ada, berikut langkah-langkahnya:
1. Cari terlebih dahulu data yang akan dihapus. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/filter.png) untuk filter data lebih detail.
2. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/delete.png) pada baris data yang akan dihapus.
3. Akan tampil popup konfirmasi.

    ![image]({{$baseUrl}}/public/img/docs/delete-confirm.png)

4. Tekan `Ya` untuk menghapus data, atau tekan `Batal` untuk membatalkan proses.

    > {danger.fa-warning} Jika tidak terdapat ikon ![image]({{$baseUrl}}/public/img/docs/delete.png) pastikan Anda mempunyai permisi untuk menghapus data pendaftaran.

<a name="unlock-registration">

## [Cara Meng-Unlock Data Pendaftaran](#)
Untuk meng-unlock data pendaftaran, berikut langkah-langkahnya:
1. Cari terlebih dahulu data yang akan di unlock. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/filter.png) untuk filter data lebih detail.
2. Tekan pada baris yang akan di unlock.
3. Anda akan diarahkan ke halaman baru.
4. Kemudian, tekan tombol ![image]({{$baseUrl}}/public/img/docs/draft.png).
5. Setelah di unlock, Anda dapat merubah data pendaftaran.

    > {danger.fa-warning} Jika tidak terdapat tombol ![image]({{$baseUrl}}/public/img/docs/draft.png) pastikan Anda mempunyai permisi untuk meng-unlock data pendaftaran. Unlock data aksi / tindak lanjut terlebih dahulu.

<a name="baca-juga">

## [Baca Juga](#)
1. <a href="transaction-overview">Sekilas tentang Menu Transaksi</a>
2. <a href="action">Aksi / Tindak Lanjut</a>
3. <a href="letter">Surat</a>
4. <a href="pharmacy">Farmasi</a>
5. <a href="inventory">Inventory</a>