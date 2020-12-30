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
                <th class="td">Nama Aset</th>
                <th class="td">Kondisi</th>
                <th class="td">Tanggal Pengaduan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['pengaduan'] as $pengaduan)
                <tr>
                    <td class="td">{{ $loop->iteration }}</td>
                    <td class="td">{{ $pengaduan->Nama_Aset }}</td>
                    @if($pengaduan->Kondisi === 1)
                        <td class="td">Aset Rusak Ringan</td>
                    @else 
                        <td class="td">Aset Rusak Berat</td>
                    @endif 
                    <td class="td">{{ date('d/m/Y', strtotime($pengaduan->Tanggal_Pengaduan)) }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>

</body>
</html>