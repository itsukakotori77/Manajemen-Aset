<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pengajuan Aset</title>
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
            <td>Yth.</td>
        </tr>
        <tr>
            <td>Ketua Sarpras</td>
        </tr>
        <tr>
            <td>SMKN 5 Bandung</td>
        </tr>
        <tr>
            <td>Jalan bojongkoneng No. 37A</td>
        </tr>
    </table>

    <p class="p">
        Dengan ini mengajukan permohonan pengajuan aset dengan nama pengajuan <strong>{{ $data['pengajuan']->Nama_Pengajuan }}</strong> 
        serta beberapa perencanaan yang dibuat dengan ketentuan berserta alasan sebagai berikut:
    </p> 
        
    
    <!-- Table -->
    <table class="table">
        <tr class="tr">
            <th class="td">Nomor</th>
            <th class="td">Nama Perencanaan</th>
            <th class="td">Pengaju</th>
            <th class="td">Nama Aset</th>
            <th class="td">Merek Aset</th>
            <th class="td">Jumlah</th>
            <th class="td">Harga Satuan</th>
        </tr>

        <!-- Loop -->
        @foreach($data['pengajuan']->perencanaan as $perencanaan)
            <tr class="tr">
                <td class="td">
                    <p class="text-center">{{ $loop->iteration }}</p>
                </td>
                <td class="td">{{ $perencanaan->Nama_Perencanaan }}</td>
                <td class="td">{{ $perencanaan->Nama_Pengaju }}</td>
                <td class="td">{{ $perencanaan->Nama_Aset }}</td>
                <td class="td">{{ $perencanaan->Merek_Aset }}</td>
                <td class="td">
                    <p class="text-center">{{ $perencanaan->Jumlah_Aset }}</p>
                </td>
                <td class="td">
                    <p class="text-center">Rp. {{ rupiah($perencanaan->Satuan_Harga) }}</p>
                </td>
            </tr>

            <!-- Variable -->
            <?php $total = $perencanaan->Total_Harga + $perencanaan->Total_Harga; ?>

        @endforeach
        <tr>
            <td colspan="5">&nbsp;</td>
            <td class="td">
                <p class="text-center">Total</p> 
            </td> 
            <td class="td">
                <p class="text-center">{{ rupiah($total) }}</p>
            </td>
        </tr>
    </table>


    <table width="100%" style="margin-top: 150px;">
        <thead>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <!-- TTD -->
            <tr>
                <td colspan="10">
                    <p class="pull-left">Hormat</p> 
                </td>
                <td colspan="10">
                    <div class="pull-left">
                        <img src="{{ public_path('assets/images/blank.png') }}" alt="" class="pull-right" style="width: 100px;">
                    </div>
                </td>
                <td colspan="3">
                    <p class="pull-right" style="margin-right: 10px;">Persetujuan</p>
                </td>
            </tr>
            
            <!-- TTD 2 -->
            <tr>
                <td colspan="10">
                    <p class="pull-left">Ketua Kompetensi</p> 
                </td>
                <td colspan="10">
                    <img src="{{ public_path('assets/images/blank.png') }}" alt="" class="pull-right" style="width: 100px;">
                </td>
                <td colspan="3">
                    @if($data['pengajuan']->Status === 1 || $data['pengajuan']->Status === 2)
                        <img src="{{ public_path('assets/images/blank.png') }}" alt="" class="pull-right" style="width: 100px; margin-left: 140px;">
                    @elseif($data['pengajuan']->Status === 3)
                        <img src="{{ public_path('assets/images/acc.png') }}" alt="" class="pull-right" style="width: 100px; margin-left: 140px;">
                    @else 
                        <img src="{{ public_path('assets/images/rejected.png') }}" alt="" class="pull-right" style="width: 100px; margin-left: 140px;">
                    @endif
                    <p class="pull-right">TU Sarpras</p>
                </td>
            </tr>
        </tbody>
    </table>

</body>
</html>