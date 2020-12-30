<?php

namespace App\Http\Controllers;

use Auth;
use PDF;
use Carbon\Carbon;
use App\Aset;
use App\Pegawai;
use App\Pengajuan;
use App\PengaduanAset;
use App\Perencanaan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function laporanAset($method)
    {
        $jurusan = Pegawai::select('Jurusan_ID')->where('User_ID', '=', Auth::user()->id)->first();

        switch($method)
        {
            case 'pengaduan':

                for($i=1; $i<=30; $i++)
                {
                    $tanggal = date('Y-m-'. $i);
                    
                    // Pengaduan Rusak Ringan
                    $query1 = PengaduanAset::select('pengaduan_aset.*')
                            ->leftJoin('kondisi_aset', 'kondisi_aset.Pengaduan_ID', '=', 'pengaduan_aset.Kode_Pengaduan')
                            ->where([
                                ['Tanggal_Pengaduan', $tanggal],
                                ['kondisi_aset.Kondisi', '=', 1]
                            ])->get();

                    $pengaduan_ringan[] = count($query1);
                    
                    // Pengaduan Rusak Berat
                    $query2 = PengaduanAset::select('pengaduan_aset.*')
                            ->leftJoin('kondisi_aset', 'kondisi_aset.Pengaduan_ID', '=', 'pengaduan_aset.Kode_Pengaduan')
                            ->where([
                                ['Tanggal_Pengaduan', $tanggal],
                                ['kondisi_aset.Kondisi', '=', 2]
                            ])->get();

                    $pengaduan_berat[] = count($query2);

                }

                $data = array(
                    'title' => 'Laporan Pengaduan',
                    'pengaduan_ringan' => $pengaduan_ringan,
                    'pengaduan_berat' => $pengaduan_berat,
                );

                return view('Laporan.laporan_pengaduan', compact('data'));

            break;

            case 'pengajuan':

                for($i=1; $i<=30; $i++)
                {
                    $tanggal = date('Y-m-'. $i);
                    
                    // Pengaduan Rusak Disetujui
                    $query1 = Pengajuan::where([
                        ['Tanggal_Pengajuan', $tanggal],
                        ['Status', 3],
                    ])
                    ->orderBy('Kode_Pengajuan', 'ASC')->get();

                    $pengajuan_disetujui[] = count($query1);

                    // pengajuan Rusak Ditolak
                    $query2 = Pengajuan::where([
                        ['Tanggal_Pengajuan', $tanggal],
                        ['Status', 4],
                    ])
                    ->orderBy('Kode_Pengajuan', 'ASC')->get();

                    $pengajuan_ditolak[] = count($query2);

                }

                $data = array(
                    'title' => 'Laporan Pengajuan',
                    'pengajuan_disetujui' => $pengajuan_disetujui,
                    'pengajuan_ditolak' => $pengajuan_ditolak,

                );

                return view('Laporan.laporan_pengajuan', compact('data'));

            break;

            case 'aset':

                for($i=1; $i<=30; $i++)
                {
                    $tanggal = date('Y-m-'. $i);
                    $query = Aset::where('Tanggal_Masuk', $tanggal)->get();
                    $aset[] = count($query);
                }

                $data = array(
                    'title' => 'Laporan Aset Masuk',
                    'aset' => $aset
                );

                return view('Laporan.laporan_aset', compact('data'));

            break;

            case 'perencanaan':

                for($i=1; $i<=30; $i++)
                {
                    $tanggal = date('Y-m-'. $i);
                    $query = Perencanaan::leftJoin('pegawai', 'pegawai.ID_Pegawai', '=', 'perencanaan.Pegawai_ID')->where([
                        ['Tanggal_Perencanaan', $tanggal],
                        ['pegawai.Jurusan_ID', '=', $jurusan->Jurusan_ID]
                    ])->get();
                    $perencanaan[] = count($query);
                }

                $data = array(
                    'title' => 'Laporan Perencanaan',
                    'perencanaan' => $perencanaan
                );

                return view('Laporan.laporan_perencanaan', compact('data'));

            break;

        }
    }

    public function downloadLaporan(Request $request, $method)
    {
        $jurusan = Pegawai::select('Jurusan_ID')->where('User_ID', '=', Auth::user()->id)->first();
        
        switch($method)
        {
            case 'pengaduan':

                $tanggal = date('Y-m-d', strtotime($request->Tanggal));
                $data = array(
                    'title' => 'Laporan Pengaduan Aset',
                    'pengaduan' => PengaduanAset::select('aset.Nama_Aset', 'kondisi_aset.Kondisi', 'pengaduan_aset.Tanggal_Pengaduan')
                                ->leftJoin('aset', 'aset.Kode_Aset', '=', 'pengaduan_aset.Aset_ID')
                                ->leftJoin('kondisi_aset', 'kondisi_aset.Pengaduan_ID', '=', 'pengaduan_aset.Kode_Pengaduan')
                                ->whereBetween('Tanggal_Pengaduan', [
                                    date('Y-m-01', strtotime($tanggal)), 
                                    date('Y-m-t', strtotime($tanggal))
                                ])
                                ->get(),
                    'tanggal' => date('d F Y', strtotime($tanggal))             
                );

                $pdf = PDF::loadView('Laporan.print_pengaduan', compact('data'))
                            ->setPaper('A4');
                return $pdf->download('laporan-pengaduan-aset-' . date('Y-m-d_H-i-s'). '.pdf');

            break;

            case 'pengajuan':

                $tanggal = date('Y-m-d', strtotime($request->Tanggal));
                $data = array(
                    'title' => 'Laporan Pengajuan Aset',
                    'pengajuan' => Pengajuan::select('pengajuan.*', 'jurusan.Nama_Jurusan')->whereBetween('Tanggal_Pengajuan', [
                                    date('Y-m-01', strtotime($tanggal)), 
                                    date('Y-m-t', strtotime($tanggal))
                                ])->leftJoin('jurusan', 'jurusan.Kode_Jurusan', '=', 'pengajuan.Jurusan_ID')->get(),
                    'tanggal' => date('d F Y', strtotime($tanggal))
                );
                
                $pdf = PDF::loadView('Laporan.print_pengajuan', compact('data'))
                            ->setPaper('A4');
                return $pdf->download('laporan-pengajuan-aset-' . date('Y-m-d_H-i-s'). '.pdf');

            break;

            case 'aset':

                $tanggal = date('Y-m-d', strtotime($request->Tanggal));
                $data = array(
                    'title' => 'Laporan Aset Masuk',
                    'aset_masuk' => Aset::whereBetween('Tanggal_Masuk', [
                        date('Y-m-01', strtotime($tanggal)), 
                        date('Y-m-t', strtotime($tanggal))
                    ])->get(),
                    'tanggal' => date('d F Y', strtotime($tanggal))
                );

                $pdf = PDF::loadView('Laporan.print_aset', compact('data'))
                            ->setPaper('A4');
                return $pdf->download('laporan-aset-masuk-aset-' . date('Y-m-d_H-i-s'). '.pdf');

            break;

            case 'perencanaan':

                $tanggal = date('Y-m-d', strtotime($request->Tanggal));
                $data = array(
                    'title' => 'Laporan Perencanaan',
                    'perencanaan' => Perencanaan::leftJoin('pegawai', 'pegawai.ID_Pegawai', '=', 'perencanaan.Pegawai_ID')
                    ->where('pegawai.Jurusan_ID', '=', $jurusan->Jurusan_ID)
                    ->whereBetween('Tanggal_Perencanaan', [
                        date('Y-m-01', strtotime($tanggal)), 
                        date('Y-m-t', strtotime($tanggal))
                    ])->get(),
                    'tanggal' => date('d F Y', strtotime($tanggal))
                );

                $pdf = PDF::loadView('Laporan.print_perencanaan', compact('data'))
                            ->setPaper('A4');
                return $pdf->download('laporan-perencanaan-' . date('Y-m-d_H-i-s'). '.pdf');

            break;

        }
    }

}
