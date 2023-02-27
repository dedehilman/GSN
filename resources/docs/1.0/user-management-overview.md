@php
    $baseUrl = url('/');
@endphp

# Sekilas tentang Menu User Management
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

Mengatur pengguna yang dapat masuk ke dalam sistem, mapping pengguna dengan role untuk menentukan hak askes dari pengguna.
<table>
    <tr style="background-color: lightgrey;">
        <th>No</th>
        <th>Nama</th>
        <th>Deskripsi</th>
    </tr>
    <tr>
        <td>1</td>
        <td>Pengguna</td>
        <td>Digunakan untuk mengelola user / pengguna yang dapat masuk kedalam sistem, mapping user dengan role.</td>
    </tr>
    <tr>
        <td>2</td>
        <td>Role</td>
        <td>Digunakan untuk mengelola role yang tedapat pada sistem, mapping role dengan hak akses menu, permission, & record rule.</td>
    </tr>
</table>

<a name="baca-juga">

## [Baca Juga](#)
1. <a href="system-setting-overview">Sekilas tentang Menu Pengaturan Sistem</a>
2. <a href="security-overview">Kemanan</a>
3. <a href="parameter">Parameter</a>
