@php
    $baseUrl = url('/');
@endphp

# Sekilas tentang Menu Dashboard
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
- [Filter Data pada Dashboard](#filter-data-dashboard)
- [Baca Juga](#baca-juga)

Dashboard merupakan halaman awal dari SIDIK. Halaman ini menampilkan berbagai informasi penting yang umumnya perlu dipantau secara rutin, beserta dengan tombol-tombol untuk mengakses fitur yang dapat membantu dalam mengelola aktivitas rutin.

<br>

Berikut adalah tampilan Dashboard SIDIK:

![image]({{$baseUrl}}/public/img/docs/how-to-login-2.png)

<a name="filter-data-dashboard">

## [Filter Data pada Dashboard](#)
Data yang ditampilkan pada dashboard adalah data pada bulan berjalan (dari awal bulan - hari ini). Anda dapat mengubah periode data yang ditampilkan pada dashboard, dengan cara:
1. Klik ikon `+` pada bagian filter.
2. Kemudian akan tampil filter tanggal.

    ![image]({{$baseUrl}}/public/img/docs/dashboard-overview-1.png)

3. Isi dari & sampai tanggal, kemudian tekan `Apply`.

<a name="baca-juga">

## [Baca Juga](#)