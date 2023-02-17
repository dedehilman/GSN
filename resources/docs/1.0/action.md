@php
    $baseUrl = url('/');
@endphp

# Aksi / Tindak Lanjut
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
- [Cara Menindak Lanjuti Pendaftaran](#action)
- [Input Data Diagnosa](#diagnosa-action)
- [Input Data Resep](#resep-action)
- [Input Data Aksi](#aksi-action)
- [Input Data Lampiran](#lampiran-action)
- [Generate Surat Sakit & Surat Rujukan](#lainnya-action)
- [Cara Merubah Data Tindak Lanjut](#edit-action)
- [Cara Menghapus Data Tindak Lanjut](#delete-action)
- [Cara Meng-Unlock Data Tindak Lanjut](#unlock-action)
- [Baca Juga](#baca-juga)

Menu ini digunakan oleh dokter / tenaga medis untuk menindak lanjuti pasien yang telah mendaftar.

<a name="action">

## [Cara Menindak Lanjuti Pendaftaran](#)
1. Pilih menu Aksi.
2. Kemudian pilih sub-menu yang sesuai dengan poli klinik yang dituju.

    ![image]({{$baseUrl}}/public/img/docs/action-1.png)

3. Secara default, data yang ditampilkan adalah data pada hari ini dan belum diproses tindak lanjut.
2. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/edit.png) pada baris data yang akan ditindak lanjuti.
3. Anda akan diarahakan ke halaman aksi / tindak lanjut.

    ![image]({{$baseUrl}}/public/img/docs/action-2.png)

    <table>
        <tr style="background-color: lightgrey;">
            <th>No</th>
            <th>Nama</th>
            <th>Deskripsi</th>
        </tr>
        <tr>
            <td>1</td>
            <td>Diagnosa</td>
            <td>Digunakan untuk input data gejala & diagnosa.</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Resep</td>
            <td>Digunakan untuk input resep obat (jika diperlukan). </td>
        </tr>
        <tr>
            <td>3</td>
            <td>Aksi</td>
            <td>Digunakan untuk input aksi / tindak lanjut (Selesai, Berobat Ulang, Rujuk)</td>
        </tr>
        <tr>
            <td>4</td>
            <td>Riwayat</td>
            <td>Daftar riwayat berobat pasien</td>
        </tr>
        <tr>
            <td>5</td>
            <td>Lampiran</td>
            <td>Input file lampiran atau pendukung (jika diperlukan)</td>
        </tr>
        <tr>
            <td>6</td>
            <td>Lainnya</td>
            <td>Digunakan untuk mengenerate surat sakit & surat rujukan (jika tindak lanjut nya di rujuk)</td>
        </tr>
    </table>
9. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/save.png) untuk menyimpan data, atau tekan tombol ![image]({{$baseUrl}}/public/img/docs/back.png) untuk membatalkan & kembali ke halaman sebelumnya.

<a name="diagnosa-action">

## [Input Data Diagnosa](#)
1. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/add-diagnosa.png) untuk menambahkan data diagosa baru.
    
    ![image]({{$baseUrl}}/public/img/docs/diagnosa-1.png)

2. Input gejala terlebih dahulu, dengan menekan tombol ![image]({{$baseUrl}}/public/img/docs/add.png)
3. Pilih gejala yang dialami pasien / dari hasil pemeriksaan.
4. Pilih diagnosa yang sesuai dengan gejala-gejala yang diinput
    
    ![image]({{$baseUrl}}/public/img/docs/diagnosa-2.png)
    > {success} Sistem akan mengkalkulasi persentase diagnosa atas gejala yang diinput.
5. Ulangi langkah 1 untuk menambahkan diagnosa lainnya.
<a name="resep-action">

## [Input Data Resep](#)
1. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/generate.png) untuk mengenerate resep sesuai dengan diagnosa yang diinput.
    > {danger.fa-warning} Pastikan data resep telah diinputkan ke sistem untuk masing-masing penyakit / diagnosa. Jika belum maka Anda harus membuat resep secara manual.
2. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/add.png) untuk menambahkan resep secara manual.
3. Kemudian isi Produk / Obat, Aturan, dan Qty resep.

    ![image]({{$baseUrl}}/public/img/docs/resep.png)
4. Ulangi langkah 1 untuk menambahkan resep lainnya.
<a name="aksi-action">

## [Input Data Aksi](#)
1. Pilih aksi atas tindak lanjut dari hasil berobat.

    ![image]({{$baseUrl}}/public/img/docs/action-3.png)

    > {danger.fa-warning} `Selesai` berobat selesai.<br>`Berobat Ulang` pasien diminta untuk berobat ulang pada tanggal xxx.<br>`Rujuk` pasien dirujuk ke internal / external.
2. Jika aksi yang dipilih adalah `Berobat Ulang`, maka Anda diminta untuk memasukan kapan pasien harus berobat kembali.

    ![image]({{$baseUrl}}/public/img/docs/action-4.png)

3. Jika aksi yang dipilih adalah `Rujuk`, maka Anda diminta untuk memasukan jenis referensi & tujuan referensi.

    ![image]({{$baseUrl}}/public/img/docs/action-5.png)

    > {danger.fa-warning} `Internal` rujuk ke klinik lain.<br>`External` rujuk ke external selain klinik (contohnya: bidan, rumah sakit), lihat referensi external <a href="{{$baseUrl}}/master/reference">disini</a>.
<a name="lampiran-action">

## [Input Data Lampiran](#)
1. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/upload-file.png).
2. Cari dan pilih file yang akan di upload.
4. Ulangi langkah 1 untuk upload file lainnya.
<a name="lainnya-action">

## [Generate Surat Sakit & Surat Rujukan](#)
1. Klik `Generate SKS` untuk mengenerate surat sakit.
2. Akan tampil popup seperti dibawah. Data akan terisi sesuai data yang diinput sebelumnya.

    ![image]({{$baseUrl}}/public/img/docs/generate-sks.png).

3. Kemudian tekan tombol ![image]({{$baseUrl}}/public/img/docs/generate-primary.png) untuk generate surat sakit
4. Jika berhasil, maka tulisan `Generate SKS` akan berubah menjadi nomor surat sakit `SKS-YYYYMMDD-SEQ`,

<br>

1. Klik `Generate SR` untuk mengenerate surat rujukan.
2. Akan tampil popup seperti dibawah. Data akan terisi sesuai data yang diinput sebelumnya.

    ![image]({{$baseUrl}}/public/img/docs/generate-sr.png).

3. Kemudian tekan tombol ![image]({{$baseUrl}}/public/img/docs/generate-primary.png) untuk generate surat rujukan
4. Jika berhasil, maka tulisan `Generate SR` akan berubah menjadi nomor surat sakit `SR-YYYYMMDD-SEQ`,
<a name="edit-action">

## [Cara Merubah Data Tindak Lanjut](#)
Untuk merubah data aksi / tindak lanjut yang sudah ada, berikut langkah-langkahnya:
1. Cari terlebih dahulu data yang akan diubah. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/filter.png) untuk filter data lebih detail.
2. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/edit.png) pada baris data yang akan diubah.
3. Anda akan diarahkan ke halaman baru, kemudian ubah data yang ingin diubah.
4. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/save.png) untuk menyimpan perubahan, atau tekan tombol ![image]({{$baseUrl}}/public/img/docs/back.png) untuk membatalkan & kembali ke halaman sebelumnya.

    > {danger.fa-warning} Jika tidak terdapat ikon ![image]({{$baseUrl}}/public/img/docs/edit.png) atau anda tidak bisa merubah data aksi / tindak lanjut, pastikan Anda mempunyai permisi untuk merubah data aksi / tindak lanjut dan data aksi / tindak lanjut tidak sedang terkunci.

<a name="delete-action">

## [Cara Menghapus Data Tindak Lanjut](#)
Untuk menghapus data aksi / tindak lanjut yang sudah ada, berikut langkah-langkahnya:
1. Cari terlebih dahulu data yang akan dihapus. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/filter.png) untuk filter data lebih detail.
2. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/delete.png) pada baris data yang akan dihapus.
3. Akan tampil popup konfirmasi.

    ![image]({{$baseUrl}}/public/img/docs/delete-confirm.png)

4. Tekan `Ya` untuk menghapus data, atau tekan `Batal` untuk membatalkan proses.

    > {danger.fa-warning} Jika tidak terdapat ikon ![image]({{$baseUrl}}/public/img/docs/delete.png) pastikan Anda mempunyai permisi untuk menghapus data aksi / tindak lanjut. Data yang dihapus adalah data aksi saja (untuk pendaftaran akan tetap ada) dan akan masuk kembali ke dalam data yang belum diproses.

<a name="unlock-action">

## [Cara Meng-Unlock Data Tindak Lanjut](#)
Untuk meng-unlock data aksi / tindak lanjut, berikut langkah-langkahnya:
1. Cari terlebih dahulu data yang akan di unlock. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/filter.png) untuk filter data lebih detail.
2. Tekan pada baris yang akan di unlock.
3. Anda akan diarahkan ke halaman baru.
4. Kemudian, tekan tombol ![image]({{$baseUrl}}/public/img/docs/draft.png).
5. Setelah di unlock, Anda dapat merubah data aksi / tindak lanjut.

    > {danger.fa-warning} Jika tidak terdapat tombol ![image]({{$baseUrl}}/public/img/docs/draft.png) pastikan Anda mempunyai permisi untuk meng-unlock data aksi / tindak lanjut. Jika terdapat data referensi ke farmasi, maka yang harus di unlock adalah data farmasinya terlebih dahulu.

<a name="baca-juga">

## [Baca Juga](#)
1. <a href="transaction-overview">Sekilas tentang Menu Transaksi</a>
2. <a href="registration">Pendaftaran</a>
3. <a href="letter">Surat</a>
4. <a href="pharmacy">Farmasi</a>
5. <a href="inventory">Inventory</a>