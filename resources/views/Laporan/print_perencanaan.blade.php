<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['title'] }}</title>
    <style>
        .text-center{
            text-align: center;
        }

        .pull-left{
            text-align: left;
        }
        .pull-right{
            text-align: right;
        }

        .table{
            border-collapse: collapse;
            width: 100%;
            border: 1px solid black;
            margin-top: 40px;
        }

        .table2{
            width: 100%;
        }

        .tr{
            border-collapse: collapse;
            border: 1px solid black;
        }

        .th{
            border-collapse: collapse;
            border: 1px solid black;
        }

        .td{
            border-collapse: collapse;
            border: 1px solid black;
        }
        .p{
            margin-top: 50px;
            text-align: justify;
        }

    </style>
</head>
<body>
    <!-- Kop Surat -->
    <header>
        <img src="{{ public_path('assets/images/kop-surat.png') }}" style="width: 100%;">
    </header>  
    
    <!-- Yth -->
    <table>
        <tr>
            <td>SMKN 5 Bandung</td>
        </tr>
        <tr>
            <td>Jalan bojongkoneng No. 37A</td>
        </tr>
    </table>

    <center><h2>{{ $data['title'] . ' : ' .  date('F', strtotime($data['tanggal'])) }}</h2></center>
    
    <!-- Table -->
    <table class="table">
        <thead>
            <tr class="tr">
                <th class="td">Nomor</th>
                <th class="td">Nama Pengaju</th>
                <th class="td">Nama Aset</th>
                <th class="td">Jenis Aset</th>
                <th class="td">Jumlah Aset</th>
                <th class="td">Merek Aset</th>
                <th class="td">Satuan Harga</th>
                <th class="td">Status Perencanaan</th>
            </tr>
        </thead>
        <tbody>
            <?php $total=0; ?>
            @foreach($data['perencanaan'] as $perencanaan)
                <tr>
                    <td class="td"><p class="text-center">{{ $loop->iteration }}</p></td>
                    <td class="td"><p class="text-center">{{ $perencanaan->Nama_Pengaju }}</p></td>
                    <td class="td"><p class="text-center">{{ $perencanaan->Nama_Aset }}</p></td>
                    <!-- Jenis Aset -->
                    @if($perencanaan->Jenis_Aset === 1)
                        <td class="td"><p class="text-center">Aset Tetap</p></td>
                    @else 
                        <td class="td"><p class="text-center">Aset Habis Pakai</p></td>
                    @endif 
                    <td class="td"><p class="text-center">{{ $perencanaan->Jumlah_Aset }}</p></td>
                    <td class="td"><p class="text-center">{{ $perencanaan->Merek_Aset }}</p></td>
                    <td class="td"><p class="text-center">{{ rupiah($perencanaan->Satuan_Harga) }}</p></td>
                    <!-- Status -->
                    @if($perencanaan->Status === 1)
                        <td class="td"><p class="text-center">Belum Diajukan</p></td>
                    @elseif($perencanaan->Status === 2)
                        <td class="td"><p class="text-center">Menunggu Persetujuan</p></td>
                    @else 
                        <td class="td"><p class="text-center">Telah Diajukan</p></td>
                    @endif

                    <?php $total += $perencanaan->Satuan_Harga; ?>
                </tr>
            @endforeach
            <tr>
                <td colspan="7"><p class="text-center"><strong>Total</strong></p></td>
                <td class="td"><p class="text-center">{{ rupiah($total) }}</p></td>
            </tr>
        </tbody>

    </table>

</body>
</html>