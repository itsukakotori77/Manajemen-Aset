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
                <th class="td">Nama Pengajuan</th>
                <th class="td">Tanggal Pengajuan</th>
                <th class="td">Asal Pengajuan</th>
                <th class="td">Nama Aset</th>
                <th class="td">Status Pengajuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['pengajuan'] as $pengajuan)
                <tr>
                    <td class="td"><p class="text-center">{{ $loop->iteration }}</p></td>
                    <td class="td">{{ $pengajuan->Nama_Pengajuan }}</td>
                    <td class="td"><p class="text-center">{{ date('d/m/Y', strtotime($pengajuan->Tanggal_Pengajuan)) }}</p></td>
                    <td class="td"><p class="text-center">{{ $pengajuan->Nama_Jurusan }}</p></td>
                    <td class="td">
                        @foreach($pengajuan->perencanaan as $perencanaan)
                            <ul>
                                <li>{{ $perencanaan->Nama_Aset }}</li>
                            </ul>
                        @endforeach
                    </td>
                    <td class="td">
                        @if($pengajuan->Status === 3)
                            <p class="text-center">Pengajuan Diterima</span>
                        @else 
                            <p class="text-center">Pengajuan Ditolak</p>
                        @endif 
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>

</body>
</html>