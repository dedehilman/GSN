@php
    $baseUrl = url('/');
@endphp

# Sekilas tentang Menu Record Rule
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
- [Cara Membuat Record Rule Baru](#create-record-rule)
- [Cara Merubah Data Record Rule](#edit-record-rule)
- [Cara Menghapus Data Record Rule](#delete-record-rule)
- [Aturan Record Rule](#aturan-record-rule)
- [Operator Record Rule](#operator-record-rule)
- [Baca Juga](#baca-juga)

Digunakan untuk mendaftarkan / mengatur record rule yang digunakan pada sistem. Record rule adalah data filter / aturan atas data yang akan ditampilkan, yang nantinya record rule ini akan di mapping pada role.
> {danger.fa-warning} Untuk membuat data record rule harus paham structure database, table, dan query SQL.

<a name="create-record-rule">

## [Cara Membuat Record Rule Baru](#)
1. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/create.png) untuk membuat record-rule baru.

    > {danger.fa-warning} Jika tidak terdapat tombol ![image]({{$baseUrl}}/public/img/docs/create.png) pastikan Anda mempunyai permisi untuk membuat data record rule.

2. Masukan nama record rule
    
    ![image]({{$baseUrl}}/public/img/docs/record-rule-1.png)

    > {danger.fa-warning} nama record rule unik, tidak boleh ada record rule dengan nama yang sama.

3. Masukan nama table yang akan difilter datanya.
    
    ![image]({{$baseUrl}}/public/img/docs/record-rule-2.png)

3. Masukan link (route name dalam PHP) dimana record rule ini akan diterapkan, jika diterapkan disemua link / halaman isi dengan `*`. Gunakan pemisah koma `,` jika link yang dimasukan lebih daru 1.
    
    ![image]({{$baseUrl}}/public/img/docs/record-rule-3.png)

3. Masukan aturan yang akan diterapkan `Nilai pada aturan equivalent dengan WHERE Clause pada SQL`.
    
    ![image]({{$baseUrl}}/public/img/docs/record-rule-4.png)

3. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/save.png) untuk menyimpan data, atau tekan tombol ![image]({{$baseUrl}}/public/img/docs/back.png) untuk membatalkan & kembali ke halaman sebelumnya.

<a name="edit-record-rule">

## [Cara Merubah Data Record Rule](#)
Untuk merubah data record rule yang sudah ada, berikut langkah-langkahnya:
1. Cari terlebih dahulu data yang akan diubah. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/filter.png) untuk filter data lebih detail.
2. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/edit.png) pada baris data yang akan diubah.
3. Anda akan diarahkan ke halaman baru, kemudian ubah data yang ingin diubah.
4. Tekan tombol ![image]({{$baseUrl}}/public/img/docs/save.png) untuk menyimpan perubahan, atau tekan tombol ![image]({{$baseUrl}}/public/img/docs/back.png) untuk membatalkan & kembali ke halaman sebelumnya.

    > {danger.fa-warning} Jika tidak terdapat ikon ![image]({{$baseUrl}}/public/img/docs/edit.png), pastikan Anda mempunyai permisi untuk merubah data record rule.

<a name="delete-record-rule">

## [Cara Menghapus Data Record Rule](#)
Untuk menghapus data record rule yang sudah ada, berikut langkah-langkahnya:
1. Cari terlebih dahulu data yang akan dihapus. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/filter.png) untuk filter data lebih detail.
2. Tekan ikon ![image]({{$baseUrl}}/public/img/docs/delete.png) pada baris data yang akan dihapus.
3. Akan tampil popup konfirmasi.

    ![image]({{$baseUrl}}/public/img/docs/delete-confirm.png)

4. Tekan `Ya` untuk menghapus data, atau tekan `Batal` untuk membatalkan proses.

    > {danger.fa-warning} Jika tidak terdapat ikon ![image]({{$baseUrl}}/public/img/docs/delete.png) pastikan Anda mempunyai permisi untuk menghapus data record rule.

<a name="aturan-record-rule">

## [Aturan Record Rule](#)
Aturan untuk record rule ada pola yang harus diikuti
```php
@and(namaTable.namaKolom;operator;nilai)
@or(namaTable.namaKolom;operator;nilai)
@andgroup(@and(namaTable.namaKolom;operator;nilai)@or(namaTable.namaKolom;operator;nilai))
@orgroup(@and(namaTable.namaKolom;operator;nilai)@or(namaTable.namaKolom;operator;nilai))

Untuk nilai yang lebih dari 1 gunakan koma(,) untuk pemisah

Contoh:
@and(table1.kolom1;=;JB 1) equivalent AND table1.kolom1 = 'JB 1'

Contoh:
@or(table1.kolom1;=;JB 1) equivalent OR table1.kolom1 = 'JB 1'

Contoh:
@andgroup(@and(table1.kolom1;=;JB 1)@or(table1.kolom2;=;2)) equivalent AND (table1.kolom1 = 'JB 1' OR table1.kolom2 = '2')

Contoh:
@orgroup(@and(table1.kolom1;=;JB 1)@or(table1.kolom2;=;2)) equivalent OR (table1.kolom1 = 'JB 1' OR table1.kolom2 = '2')
```

<a name="operator-record-rule">

## [Operator Record Rule](#)
<table>
    <tr style="background-color: lightgrey;">
        <th>No</th>
        <th>Nama</th>
        <th>Deskripsi</th>
    </tr>
    <tr>
        <td>1</td>
        <td>=</td>
        <td>Sama dengan</td>
    </tr>
    <tr>
        <td>2</td>
        <td>></td>
        <td>Lebih besar</td>
    </tr>
    <tr>
        <td>3</td>
        <td>&lt;</td>
        <td>Lebih kecil</td>
    </tr>
    <tr>
        <td>4</td>
        <td>>=</td>
        <td>Lebih besar sama dengan</td>
    </tr>
    <tr>
        <td>5</td>
        <td>&lt;=</td>
        <td>Lebih kecil sama dengan</td>
    </tr>
    <tr>
        <td>6</td>
        <td>&lt;></td>
        <td>Tidak sama dengan</td>
    </tr>
    <tr>
        <td>7</td>
        <td>in</td>
        <td>Untuk menentukan beberapa kemungkinan nilai untuk kolom</td>
    </tr>
    <tr>
        <td>8</td>
        <td>notin</td>
        <td>Untuk menentukan beberapa non-kemungkinan nilai untuk kolom</td>
    </tr>
</table>
<a name="baca-juga">

## [Baca Juga](#)
1. <a href="permission">Permission</a>