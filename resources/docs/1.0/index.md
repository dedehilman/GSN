- ## Getting Started
    - [Sekilas Menu di SIDIK](/{{route}}/{{version}}/menu-overview)
    - [Cara Login ke SIDIK](/{{route}}/{{version}}/how-to-login)
    - [Lupa Kata Sandi](/{{route}}/{{version}}/forgot-password)
- ## Dashboard
    - [Sekilas tentang Menu Dashboard](/{{route}}/{{version}}/dashboard-overview)
    - [Cara Mengelola Fitur dari Dashboard](/{{route}}/{{version}}/dashboard-fitur)
- ## Transaksi
    - [Sekilas tentang Menu Transaksi](/{{route}}/{{version}}/dashboard-overview)
    - [Pendaftaran](/{{route}}/{{version}}/dashboard-overview)
    - [Aksi / Tindak Lanjut](/{{route}}/{{version}}/dashboard-overview)
    - [Surat](/{{route}}/{{version}}/dashboard-overview)
    - [Farmasi](/{{route}}/{{version}}/dashboard-overview)
    - [Inventory](/{{route}}/{{version}}/dashboard-overview)
- ## Laporan
    - [Sekilas tentang Menu Laporan](/{{route}}/{{version}}/dashboard-overview)
- ## Master Data
    - [Sekilas tentang Menu Master Data](/{{route}}/{{version}}/dashboard-overview)
- ## Pengaturan Sistem
    - [Sekilas tentang Menu Pengaturan Sistem](/{{route}}/{{version}}/dashboard-overview)
    - [Manajemen Pengguna](/{{route}}/{{version}}/dashboard-overview)
        - [Pengguna](/{{route}}/{{version}}/dashboard-overview)
        - [Role](/{{route}}/{{version}}/dashboard-overview)
    - [Keamanan](/{{route}}/{{version}}/dashboard-overview)
        - [Permission](/{{route}}/{{version}}/dashboard-overview)
        - [Record Rule](/{{route}}/{{version}}/dashboard-overview)
    - [Parameter](/{{route}}/{{version}}/dashboard-overview)

<script>
    document.querySelectorAll(".sidebar a").forEach(function(element,index){
        element.href = window.location.href.substring(0, window.location.href.indexOf("/docs")) + element.href.substring(element.href.indexOf("/docs"), element.href.length);
    });
</script>
