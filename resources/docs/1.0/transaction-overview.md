@php
    $baseUrl = url('/');
@endphp

# Sekilas tentang Menu Transaksi
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
- [Alur Proses](#baca-juga)
- [Baca Juga](#baca-juga)

Tranksaksi merupakan menu yang digunakan sehari-hari untuk menginput data yang terjadi pada klinik. Pada menu ini terdapat beberapa sub-menu, diantaranya:
<table>
    <tr style="background-color: lightgrey;">
        <th>No</th>
        <th>Nama</th>
        <th>Deskripsi</th>
    </tr>
    <tr>
        <td>1</td>
        <td>Pendaftaran</td>
        <td>Menu ini digunakan untuk melakukan pendaftaran semua transaksi (Rawat Jalan, KK, KB, PP) yang nantinya akan ditindak lanjuti oleh tenaga medis terkait.</td>
    </tr>
    <tr>
        <td>2</td>
        <td>Aksi / Tindak Lanjut</td>
        <td>Menu ini digunakan oleh dokter / tenaga medis untuk menindak lanjuti pasien yang telah mendaftar.</td>
    </tr>
    <tr>
        <td>3</td>
        <td>Surat</td>
        <td>Pada menu surat pengguna dapat mengenerate surat sakit & surat rujukan.</td>
    </tr>
    <tr>
        <td>4</td>
        <td>Farmasi</td>
        <td>Menu farmasi digunakan spesifik untuk farmasi / obat, setiap pengobatan yang disertai dengan resep dokter akan dikelola lagi pada menu ini untuk mengontrol obat yang keluar yang nantinya akan berpengaruh pada ketersediaan obat</td>
    </tr>
    <tr>
        <td>5</td>
        <td>Inventory</td>
        <td>Inventory digunakan untuk mengelola setiap barang / obat yang masuk, keluar, transfer masuk, transfer keluar, dan penyeseuain yang nantinya akan berpengaruh pada ketersediaan obat</td>
    </tr>
</table>

<a name="alur-porses">

## [Alur Proses](#)
Berikut adalah alur proses berobat

![image]({{$baseUrl}}/public/img/docs/flow-process.png)

<a name="baca-juga">

## [Baca Juga](#)
1. <a href="registration">Pendaftaran</a>
2. <a href="action">Aksi / Tindak Lanjut</a>
3. <a href="letter">Surat</a>
4. <a href="pharmacy">Farmasi</a>
5. <a href="inventory">Inventory</a>