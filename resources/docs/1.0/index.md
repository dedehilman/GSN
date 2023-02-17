- ## Getting Started
    - [Sekilas Menu di SIDIK](/{{route}}/{{version}}/menu-overview)
    - [Cara Login ke SIDIK](/{{route}}/{{version}}/how-to-login)
    - [Lupa Kata Sandi](/{{route}}/{{version}}/forgot-password)
- ## Dashboard
    - [Sekilas tentang Menu Dashboard](/{{route}}/{{version}}/dashboard-overview)
- ## Transaksi
    - [Sekilas tentang Menu Transaksi](/{{route}}/{{version}}/transaction-overview)
    - [Pendaftaran](/{{route}}/{{version}}/registration)
    - [Aksi / Tindak Lanjut](/{{route}}/{{version}}/action)
    - [Surat](/{{route}}/{{version}}/letter)
    - [Farmasi](/{{route}}/{{version}}/pharmacy)
    - [Inventory](/{{route}}/{{version}}/inventory)
        - [Periode](/{{route}}/{{version}}/inventory-periode)
        - [Stock Opname](/{{route}}/{{version}}/inventory-stock-opname)
        - [Transksi](/{{route}}/{{version}}/inventory-transaction)
- ## Laporan
    - [Sekilas tentang Menu Laporan](/{{route}}/{{version}}/report-overview)
- ## Master Data
    - [Sekilas tentang Menu Master Data](/{{route}}/{{version}}/master-data-overview)
- ## Pengaturan Sistem
    - [Sekilas tentang Menu Pengaturan Sistem](/{{route}}/{{version}}/system-setting-overview)
    - [Manajemen Pengguna](/{{route}}/{{version}}/user-management-overview)
        - [Pengguna](/{{route}}/{{version}}/user)
        - [Role](/{{route}}/{{version}}/role)
    - [Keamanan](/{{route}}/{{version}}/security-overview)
        - [Permission](/{{route}}/{{version}}/permission)
        - [Record Rule](/{{route}}/{{version}}/record-rule)
    - [Parameter](/{{route}}/{{version}}/parameter)

<script>
    document.querySelectorAll(".sidebar a").forEach(function(element,index){
        var baseUrl = window.location.href.substring(0, window.location.href.indexOf("/docs"));
        var currentUrl = element.href;
        baseUrl = baseUrl.substring(baseUrl.lastIndexOf("/"), baseUrl.length);
        currentUrl = currentUrl.substring(currentUrl.indexOf("/docs"), currentUrl.length);
        element.href = baseUrl + currentUrl;
    });
</script>
