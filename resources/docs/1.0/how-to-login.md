@php
    $baseUrl = url('/');
@endphp

# Cara Login ke SIDIK
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
- [Cara Login ke SIDIK](#)
- [Baca Juga](#baca-juga)

Pada Bagian ini Anda akan mempelajari cara melakukan login ke dalam aplikasi SIDIK versi website.

> {danger.fa-warning} Pastikan Anda sudah terdaftar pada akun SIDIK.

Berikut langkah-langkahnya.

1. Buka halaman <a href="{{$baseUrl}}/login">{{$baseUrl}}/login</a>.

2. Lalu masukan nama pengguna dan password yang biasa Anda gunakan.

    ![image]({{$baseUrl}}/public/img/docs/how-to-login-1.png)

3. Klik `Masuk`.

4. Maka Anda sudah berhasil masuk.

    ![image]({{$baseUrl}}/public/img/docs/how-to-login-2.png)

<a name="baca-juga">

## [Baca Juga](#)
1. <a href="menu-overview">Sekilas Menu di SIDIK</a>
2. <a href="forgot-password">Lupa Kata Sandi</a>