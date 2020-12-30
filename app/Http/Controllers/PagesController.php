<?php

namespace App\Http\Controllers;

// use Endroid\QrCode\QrCode;
use App\Aset;
use App\Pengajuan;
use App\PenempatanAset;
use App\Ruangan;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function dashboard()
    {
        for($i=0; $i<=12; $i++)
        {
            // Jumlah Diterima
            $tanggal = date('Y-'. $i .'-d');
            $query1 = Pengajuan::where('Status', 3)
            ->whereBetween('Tanggal_Pengajuan', [
                date('Y-m-01', strtotime($tanggal)), 
                date('Y-m-t', strtotime($tanggal))
            ])->get();
            
            // Jumlah Ditolak
            $tanggal = date('Y-'. $i .'-d');
            $query2 = Pengajuan::where('Status', 4)
            ->whereBetween('Tanggal_Pengajuan', [
                date('Y-m-01', strtotime($tanggal)), 
                date('Y-m-t', strtotime($tanggal))
            ])->get();

            $jumlah_diterima[] = count($query1);
            $jumlah_ditolak[] = count($query2);
        }
        
        $data = array(
            'penempatan' => PenempatanAset::select(
                            'penempatan_aset.Jumlah',
                            'ruangan.Kode_Ruangan', 
                            'ruangan.Nama_Ruangan', 
                            'aset.Nama_Aset',
                            'aset.Jenis_Aset'
                        )
                        ->leftJoin('aset', 'aset.Kode_Aset', '=', 'penempatan_aset.Aset_ID')
                        ->leftJoin('ruangan', 'ruangan.ID_Ruangan', '=', 'penempatan_aset.Ruangan_ID')
                        ->orderBy('penempatan_aset.Jumlah', 'DESC')
                        ->take(5)
                        ->get(),
            'jumlah_diterima' => $jumlah_diterima,
            'jumlah_ditolak' => $jumlah_ditolak,
            'aset_berwujud' => count(Aset::where('Jenis_Aset', 1)->get()),
            'aset_habis_pakai' => count(Aset::where('Jenis_Aset', 2)->get()),
            'pengajuan' => count(Pengajuan::all()),
            'aset' => count(Aset::all())
        );

        return view('home.dashboard', compact('data'));
        // return $jumlah_ditolak;
    }

}
