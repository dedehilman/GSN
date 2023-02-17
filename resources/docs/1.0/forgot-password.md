@php
    $baseUrl = url('/');
@endphp

# Lupa Kata Sandi
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
- [Lupa Kata Sandi](#)
- [Baca Juga](#baca-juga)

Pada bagian ini Anda akan mempelajari bagaimana cara login ke aplikasi SIDIK jika Anda lupa kata sandi/ password.  

Berikut langkah-langkahnya.

1. Pada halaman log in, klik `Saya lupa kata sandi saya`.

2. Masukkan nama pengguna yang terdaftar pada aplikasi.

    ![image]({{$baseUrl}}/public/img/docs/forgot-password-1.png)

3. Lalu, klik `KMinta kata sandi baru`.

4. Anda akan menerima instruksi perubahan password melalui email Anda.

5. Klik `Click Here` yang terdapat pada email Anda.

    ![image]({{$baseUrl}}/public/img/docs/forgot-password-2.png)

6. Anda akan dialihkan ke halaman ubah password. Masukan Password Baru, lalu masukan kembali password tersebut pada kolom Konfirmasi password.

    ![image]({{$baseUrl}}/public/img/docs/forgot-password-3.png)

7. Lalu klik `Reset Password`.

8. Maka password Anda berhasil diperbaharui.

    ![image]({{$baseUrl}}/public/img/docs/forgot-password-4.png)

9. Silahkan login kembali ke akun Anda menggunakan Password baru tersebut.

<a name="baca-juga">

## [Baca Juga](#)
1. <a href="menu-overview">Sekilas Menu di SIDIK</a>
2. <a href="how-to-login">Cara Login ke SIDIK</a>