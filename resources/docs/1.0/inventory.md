@php
    $baseUrl = url('/');
@endphp

# Inventory
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
- [Baca Juga](#baca-juga)

Inventory digunakan untuk mengelola setiap barang / obat yang masuk, keluar, transfer masuk, transfer keluar, dan penyeseuain yang nantinya akan berpengaruh pada ketersediaan obat.

Sub-Menu yang terdapat di Inventory, adalah:
<table>
    <tr style="background-color: lightgrey;">
        <th>No</th>
        <th>Nama</th>
        <th>Deskripsi</th>
    </tr>
    <tr>
        <td>1</td>
        <td>Periode</td>
        <td>Menu ini digunakan untuk mengelola periode perhitungan stok</td>
    </tr>
    <tr>
        <td>2</td>
        <td>Stok Opaname</td>
        <td>Pada Stok Opaname akan ditampilkan data-data obat/produk per klinik dan per period, yang nantinya akan dijadikan sebagai stok awal untuk periode berikutnya di masing-masing klinik</td>
    </tr>
    <tr>
        <td>3</td>
        <td>Transaksi</td>
        <td>Menu transaksi digunakan untuk mencatat semua transaksi stok masuk, keluar, transfer masuk, transfer keluar, dan penyesuaian (jika diperlukan)</td>
    </tr>
    <tr>
        <td>4</td>
        <td>Stok Opanem Upl</td>
        <td>Stok Opanem Upl digunakan untuk mengupload data stok</td>
    </tr>
</table>

<a name="baca-juga">

## [Baca Juga](#)
1. <a href="transaction-overview">Sekilas tentang Menu Transaksi</a>
2. <a href="registration">Pendaftaran</a>
3. <a href="action">Aksi / Tindak Lanjut</a>
4. <a href="letter">Surat</a>
5. <a href="pharmacy">Farmasi</a>