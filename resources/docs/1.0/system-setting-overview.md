@php
    $baseUrl = url('/');
@endphp

# Sekilas tentang Menu Pengaturan Sistem
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

Pada sub menu ini, lebih spesifik untuk pengaturan sistem, seperti manajemen pengguna, role, hak akses, sistem parameter, dll
<table>
    <tr style="background-color: lightgrey;">
        <th>No</th>
        <th>Nama</th>
        <th>Deskripsi</th>
    </tr>
    <tr>
        <td>1</td>
        <td>Manajemen Pengguna</td>
        <td>Mengatur pengguna yang dapat masuk ke dalam sistem, mapping pengguna dengan role untuk menentukan hak askes dari pengguna.</td>
    </tr>
    <tr>
        <td>2</td>
        <td>Keamanan</td>
        <td>Daftar list permisi yang tersedia pada sistem & filter untuk menampilkan data</td>
    </tr>
    <tr>
        <td>3</td>
        <td>Parameter</td>
        <td>Digunakan untuk mendaftarkan / mengatur parameter-parameter teknis yang digunakan pada sistem</td>
    </tr>
</table>

<a name="baca-juga">

## [Baca Juga](#)
1. <a href="user-management-overview">Manajemen Pengguna</a>
2. <a href="security-overview">Kemanan</a>
3. <a href="parameter">Parameter</a>
