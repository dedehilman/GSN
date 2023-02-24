@php
    $baseUrl = url('/');
@endphp

# Sekilas tentang Menu Master Data
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

Master data digunakan untuk men-setting semua data-data master klinik yang dibutuhkan untuk menjalankan bisnis proses klinik pada aplikasi, yang nantinya digunakan sebagai referensi pada setiap transaksi.
<table>
    <tr style="background-color: lightgrey;">
        <th>No</th>
        <th>Nama</th>
        <th>Deskripsi</th>
    </tr>
    <tr>
        <td>1</td>
        <td>Perusahaan</td>
        <td>Digunakan untuk mengatur master data berupa data 
        <br><br>- Grup Perusahaan
        <br><br>- Perusahaan
        <br><br>- Bisnis Area
        <br><br>- Afdelink
        <br><br>- Unit Kerja
        <br><br>- Golongan</td>
    </tr>
    <tr>
        <td>2</td>
        <td>Karyawan</td>
        <td>Digunakan untuk mengatur master data berupa data 
        <br><br>- Karyawan / Pasien
        <br><br>- Relasi Karyawan / Pasien
        <br><br>- Jenis Relasi
        </td>
    </tr>
    <tr>
        <td>3</td>
        <td>Tenaga Medis</td>
        <td>Digunakan untuk mengatur master data tenaga medis yang terdaftar di suatu klinik</td>
    </tr>
    <tr>
        <td>4</td>
        <td>Klinik</td>
        <td>Digunakan untuk mengatur master data klinik</td>
    </tr>
    <tr>
        <td>5</td>
        <td>Produk</td>
        <td>Digunakan untuk mengatur master data berupa data 
        <br><br>- Satuan Produk
        <br><br>- Jenis Produk
        <br><br>- Aturan Pakai Produk
        <br><br>- Produk
        <br><br>- Mapping Harga Produk
        </td>
    </tr>
    <tr>
        <td>6</td>
        <td>Penyakit</td>
        <td>Digunakan untuk mengatur master data berupa data 
        <br><br>- Grup Penyakit
        <br><br>- Penyakit
        <br><br>- Mapping penyakit dengan obat dan aturan pakai (Resep)
        </td>
    </tr>
    <tr>
        <td>7</td>
        <td>Diagnosa</td>
        <td>Digunakan untuk mengatur master data berupa data 
        <br><br>- Gejala
        <br><br>- Diagnosa
        <br><br>- Mapping gejala dengan diagnosa
        </td>
    </tr>
    <tr>
        <td>8</td>
        <td>Referensi</td>
        <td>Digunakan untuk mengatur master data referensi yang digunakan ketika pasien rujukan dari external</td>
    </tr>
    <tr>
        <td>9</td>
        <td>Kategori KK</td>
        <td>Digunakan untuk mengatur master data kategori KK</td>
    </tr>
    <tr>
        <td>10</td>
        <td>Kategori KB</td>
        <td>Digunakan untuk mengatur master data kategori KB</td>
    </tr>
    <tr>
        <td>11</td>
        <td>Paparan</td>
        <td>Digunakan untuk mengatur master data paparan yang digunakan pada KK</td>
    </tr>
</table>