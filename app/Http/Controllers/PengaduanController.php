<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Aset;
use App\PengaduanAset;
use App\StockAset;
use App\PenempatanAset;
use App\Ruangan;
use App\KondisiAset;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function index()
    {
        $data = array(
            'habis_pakai' => count(Aset::all()),
            'tersedia' => count(Aset::select('*')->leftJoin('stock_aset', 'stock_aset.Aset_ID', '=', 'aset.Kode_Aset')->where('stock_aset.Jumlah', '>', 0)->get()),
        );

        return view('Pengaduan.index');
    }

    public function pengaduan(Request $request)
    {
        switch($request->method())
        {

            case 'GET':
                $data = array(
                    'ruangan' => PenempatanAset::select('penempatan_aset.*', 'ruangan.Nama_Ruangan', 'ruangan.Kode_Ruangan')
                                ->leftJoin('ruangan', 'ruangan.ID_Ruangan', '=', 'penempatan_aset.Ruangan_ID')
                                ->get(),
                    'aset' => Aset::select('aset.*')
                                ->leftJoin('penempatan_aset', 'penempatan_aset.Aset_ID', '=', 'aset.Kode_Aset')
                                ->leftJoin('stock_aset', 'stock_aset.Aset_ID', '=', 'penempatan_aset.Aset_ID')
                                ->distinct('aset.Nama_Aset')
                                ->where('stock_aset.Jumlah', '>', 0)
                                ->get(),
                );
        
                return view('Pengaduan.pengaduan', compact('data'));

            break;

            case 'POST':

                $penempatan = PenempatanAset::where('Aset_ID', '=', $request->Aset_ID)->first();
                // Create Pengaduan
                $request->request->add(['Tanggal_Pengaduan' => Carbon::now()->format('Y-m-d')]);
                $request->request->add(['Penempatan_ID' => $penempatan->id]);
                $request->request->add(['Status' => 1]);
                $pengaduan = PengaduanAset::create($request->all());

                // Create Kondisi
                $kondisi = KondisiAset::create([
                    'Pengaduan_ID' => $pengaduan->Kode_Pengaduan,
                    'Aset_ID' => $request->Aset_ID,
                    'Jumlah' => $request->Total_Rusak,
                    'Kondisi' => $request->Kerusakan,

                    // Kondisi = 1 > Rusak Ringan
                    // Kondisi = 2 > Rusak Berat
                ]);

                // Update Stok
                $stok = StockAset::where('Aset_ID', $request->Aset_ID)->first();
                $stok->Jumlah = $stok->Jumlah - $request->Total_Rusak;
                $stok->save();
                
                return back()->with('message', 'Pengaduan telah diselesaikan. Terima kasih atas pengaduan anda :)');

            break;
        }
    }

    public function dataAset($jenis_data)
    {
        switch($jenis_data)
        {
            case 'habis':
                $data = Aset::where('Status', '=', 3)->get();
                return view('Pengaduan.aset_habis', compact('data'));

            break;

            case 'tersedia':
                $data = Aset::select('aset.Nama_Aset', 'aset.Tanggal_Masuk', 'stock_aset.Jumlah')
                        ->leftJoin('stock_aset', 'stock_aset.Aset_ID', '=', 'aset.Kode_Aset')
                        ->where('stock_aset.Jumlah', '>', 0)
                        ->get();

                return view('Pengaduan.aset_tersedia', compact('data'));

            break;
        }
    }

    public function stockAset()
    {
        return view('Pengaduan.stock');
    }
}
