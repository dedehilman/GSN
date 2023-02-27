@php
    $baseUrl = url('/');
@endphp

# Sekilas tentang Menu Parameter
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
- [Cara Membuat Parameter Baru](#create-parameter)
- [Cara Merubah Data Parameter](#edit-parameter)
- [Cara Menghapus Data Parameter](#delete-parameter)
- [Daftar Parameter](#list-parameter)
- [Baca Juga](#baca-juga)

Digunakan untuk mendaftarkan / mengatur parameter-parameter teknis yang digunakan pada sistem
<a name="create-parameter">

## [Cara Membuat Parameter Baru](#)
1. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/create.png) untuk membuat parameter baru.

    > {danger.fa-warning} Jika tidak terdapat tombol ![image]({{$baseUrl}}/public/img/docs/create.png) pastikan Anda mempunyai permisi untuk membuat data parameter.

2. Masukan kata kunci parameter

    ![image]({{$baseUrl}}/public/img/docs/parameter-1.png)

    > {danger.fa-warning} Kata kunci unik, tidak boleh ada parameter dengan kata kunci yang sama.

3. Check encryted, jika nilai yang dimasukan akan di encrypt ketika disimpan.

    ![image]({{$baseUrl}}/public/img/docs/parameter-2.png)

    > {danger.fa-warning} `Checked` nilai yang disimpan ke dalam sistem akan diencrypt.<br>`Unchecked` nilai yang disimpan ke dalam sistem tidak akan diencrypt (sesuai nilai yang Anda lihat pada layar).

4. Masukan nilai untuk parameter

    ![image]({{$baseUrl}}/public/img/docs/parameter-3.png)
5. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/save.png) untuk menyimpan data, atau tekan tombol ![image]({{$baseUrl}}/public/img/docs/back.png) untuk membatalkan & kembali ke halaman sebelumnya.

<a name="edit-parameter">

## [Cara Merubah Data Parameter](#)
Untuk merubah data parameter yang sudah ada, berikut langkah-langkahnya:
1. Cari terlebih dahulu data yang akan diubah. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/filter.png) untuk filter data lebih detail.
2. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/edit.png) pada baris data yang akan diubah.
3. Anda akan diarahkan ke halaman baru, kemudian ubah data yang ingin diubah.

    > {danger.fa-warning} Untuk data yang di encrypt tidak dapat diganti, misal jadi tidak diencrypt. Disarankan hapus data parameter terlebih dahulu kemudian buat parameter baru.

4. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/save.png) untuk menyimpan perubahan, atau tekan tombol ![image]({{$baseUrl}}/public/img/docs/back.png) untuk membatalkan & kembali ke halaman sebelumnya.

    > {danger.fa-warning} Jika tidak terdapat ikon ![image]({{$baseUrl}}/public/img/docs/edit.png), pastikan Anda mempunyai permisi untuk merubah data parameter.

<a name="delete-parameter">

## [Cara Menghapus Data Parameter](#)
Untuk menghapus data parameter yang sudah ada, berikut langkah-langkahnya:
1. Cari terlebih dahulu data yang akan dihapus. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/filter.png) untuk filter data lebih detail.
2. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/delete.png) pada baris data yang akan dihapus.
3. Akan tampil popup konfirmasi.

    ![image]({{$baseUrl}}/public/img/docs/delete-confirm.png)

4. Tekan `Ya` untuk menghapus data, atau tekan `Batal` untuk membatalkan proses.

    > {danger.fa-warning} Jika tidak terdapat ikon ![image]({{$baseUrl}}/public/img/docs/delete.png) pastikan Anda mempunyai permisi untuk menghapus data parameter.

<a name="list-parameter">

## [Daftar Parameter](#)
<table>
    <tr style="background-color: lightgrey;">
        <th>No</th>
        <th>Nama</th>
        <th>Deskripsi</th>
    </tr>
    <tr>
        <td>1</td>
        <td>APP_FAVICON</td>
        <td>Untuk mengatur favicon aplikasi.</td>
    </tr>
    <tr>
        <td>2</td>
        <td>APP_LOGO</td>
        <td>Untuk mengatur logo aplikasi yang tampil pada halaman login dan pada halaman setelah login di pojok kiri atas.</td>
    </tr>
    <tr>
        <td>3</td>
        <td>APP_NAME</td>
        <td>Untuk mengatur nama aplikasi yang tampil pada halaman login dan pada halaman setelah login di pojok kiri atas.</td>
    </tr>
    <tr>
        <td>4</td>
        <td>APP_VERSION</td>
        <td>Untuk mengatur versi yang ditampilkan pada aplikasi di pojok kanan bawah.</td>
    </tr>
    <tr>
        <td>5</td>
        <td>LDAP_AUTH</td>
        <td>Untuk mengatur aktif / non aktif fitur login dengan LDAP. Isi dengan nilai <code>true</code> untuk mengaktfikan dan <code>false</code> untuk menon-aktifkan fitur ini.</td>
    </tr>
    <tr>
        <td>6</td>
        <td>LDAP_AUTO_CREATE</td>
        <td>Sistem akan membuatkan otomatis data user jika user tersebut ada pada LDAP namun belum ada pada sistem. Isi dengan nilai <code>true</code> untuk mengaktfikan dan <code>false</code> untuk menon-aktifkan fitur ini. Jika fitur ini non-aktif dan user LDAP tersebut belum ada pada sistem maka akan ditolak.</td>
    </tr>
    <tr>
        <td>7</td>
        <td>LDAP_BASE_DN</td>
        <td>Isi dengan base domain settingan LDAP.</td>
    </tr>
    <tr>
        <td>8</td>
        <td>LDAP_HOST</td>
        <td>Isi dengan host server LDAP.</td>
    </tr>
    <tr>
        <td>9</td>
        <td>LDAP_PORT</td>
        <td>Isi dengan (angka) port server LDAP.</td>
    </tr>
    <tr>
        <td>10</td>
        <td>LDAP_SSL</td>
        <td>Untuk mengatur aktif / non aktif koneksi SSL. Isi dengan nilai <code>true</code> untuk mengaktfikan dan <code>false</code> untuk menon-aktifkan fitur ini.</td>
    </tr>
    <tr>
        <td>11</td>
        <td>LDAP_TIMEOUT</td>
        <td>Isi dengan (angka) waktu tunggu koneksi ke server LDAP.</td>
    </tr>
    <tr>
        <td>12</td>
        <td>LDAP_TLS</td>
        <td>Untuk mengatur aktif / non aktif koneksi TLS. Isi dengan nilai <code>true</code> untuk mengaktfikan dan <code>false</code> untuk menon-aktifkan fitur ini.</td>
    </tr>
    <tr>
        <td>12</td>
        <td>LDAP_USERNAME</td>
        <td>Isi dengan user ldap. By default isi dengan <code>null</code></td>
    </tr>
    <tr>
        <td>12</td>
        <td>LDAP_PASSWORD</td>
        <td>Isi dengan passsword user ldap. By default isi dengan <code>null</code></td>
    </tr>
    <tr>
        <td>13</td>
        <td>LDAP_CHANGEPWD_USERNAME</td>
        <td>Isi dengan user ldap yang mempunyai akses modifikasi attribute pada server LDAP untuk kebutuhan ubah kata sandi</td>
    </tr>
    <tr>
        <td>14</td>
        <td>LDAP_CHANGEPWD_PASSWORD</td>
        <td>Isi dengan password user ldap yang mempunyai akses modifikasi attribute pada server LDAP untuk kebutuhan ubah kata sandi</td>
    </tr>
    <tr>
        <td>15</td>
        <td>MAIL_DRIVER</td>
        <td>Isi driver mail server yang digunakan, seperti <code>smtp</code></td>
    </tr>
    <tr>
        <td>16</td>
        <td>MAIL_HOST</td>
        <td>Isi dengan host mail server yang digunakan.</td>
    </tr>
    <tr>
        <td>17</td>
        <td>MAIL_PORT</td>
        <td>Isi dengan (angka) port mail server yang digunakan.</td>
    </tr>
    <tr>
        <td>18</td>
        <td>MAIL_USERNAME</td>
        <td>Isi dengan username mail server yang digunakan.</td>
    </tr>
    <tr>
        <td>19</td>
        <td>MAIL_PASSWORD</td>
        <td>Isi dengan password atas user yang digunakan.</td>
    </tr>
    <tr>
        <td>20</td>
        <td>MAIL_ENCRYPTION</td>
        <td>Isi dengan jenis mail encryption atas user yang digunakan, seperti <code>ssl</code> atau <code>tls</code></td>
    </tr>
    <tr>
        <td>21</td>
        <td>MAIL_FROM_ADDRESS</td>
        <td>Isi dengan alamat pengirim email yang akan tampil di penerima.</td>
    </tr>
    <tr>
        <td>22</td>
        <td>MAIL_FROM_NAME</td>
        <td>Isi dengan nama pengirim email yang akan tampil di penerima.</td>
    </tr>
    <tr>
        <td>23</td>
        <td>SICK_LETTER_CONTENT</td>
        <td>Isi dengan content yang akan digunakan sebagai body email ketika mengirimkan surat sakit kepada penerima.</td>
    </tr>
    <tr>
        <td>24</td>
        <td>REFERENCE_LETTER_CONTENT</td>
        <td>Isi dengan content yang akan digunakan sebagai body email ketika mengirimkan surat rujukan kepada penerima.</td>
    </tr>
    <tr>
        <td>25</td>
        <td>PPT_LETTER_CONTENT</td>
        <td>Isi dengan content yang akan digunakan sebagai body email ketika mengirimkan surat hasil plano tes kepada penerima.</td>
    </tr>
    <tr>
        <td>26</td>
        <td>SLIDER</td>
        <td>Isi dengan link gambar yang akan tampil pada slide di mobile. Gunakan pemisah semi colon<code>;</code>jika lebih dari 1 link.</td>
    </tr>
</table>

<a name="baca-juga">

## [Baca Juga](#)
1. <a href="system-setting-overview">Sekilas tentang Menu Pengaturan Sistem</a>
2. <a href="user-management-overview">Manajemen Pengguna</a>
3. <a href="security-overview">Keamanan</a>
