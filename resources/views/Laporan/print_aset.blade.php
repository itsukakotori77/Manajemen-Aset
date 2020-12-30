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
                <th class="td">Kode Aset</th>
                <th class="td">Nama Aset</th>
                <th class="td">Jenis Aset</th>
                <th class="td">Merek Aset</th>
                <th class="td">Kondisi Aset</th>
                <th class="td">Tanggal Masuk</th>
                <th class="td">Harga Satuan</th>
            </tr>
        </thead>
        <?php $total=0; ?>
        <tbody>
            @foreach($data['aset_masuk'] as $aset)
                <tr>
                    <td class="td"><p class="text-center">{{ $loop->iteration }}</p></td>
                    <td class="td"><p class="text-center">{{ $aset->Kode }}</p></td>
                    <td class="td"><p class="text-center">{{ $aset->Nama_Aset }}</p></td>
                    <td class="td">
                        @if($aset->Jenis_Aset === 1)
                            <p class="text-center">Aset Berwujud</p>
                        @else 
                            <p class="text-center">Aset Habis Pakai</p>
                        @endif
                    </td>
                    <td class="td"><p class="text-center">{{ $aset->Merek_Aset }}</p></td>
                    <td class="td">
                        @if($aset->Kondisi_Aset === 1)
                            <p class="text-center">Baru</p>
                        @else 
                            <p class="text-center">Bekas</p>
                        @endif
                    </td>
                    <td class="td"><p class="text-center">{{ date('d/m/Y', strtotime($aset->Tanggal_Masuk))  }}</p></td>
                    <td class="td"><p class="text-center">{{ rupiah($aset->Harga_Aset) }}</p></td>

                    <?php $total += $aset->Harga_Aset; ?>
                </tr>
            @endforeach
            <tr>
                <td class="td" colspan="7">
                    <p class="text-center"><strong>Total</strong></p>
                </td>
                <td class="td">
                    <p class="text-center"><strong>{{ rupiah($total) }}</strong></p>
                </td>
            </tr>
        </tbody>

    </table>

</body>
</html>