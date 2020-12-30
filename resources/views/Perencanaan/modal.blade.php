@extends('layouts.modal')

@section('modal-id') #modal @endsection

@section('modal-title') <h5>Data Perencanaan</h5> @endsection

@section('modal-body')
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-12">
                <form action="#">
                    <div class="row">
                        <!-- Nama Perencanaan -->
                        <div class="col-sm-2">
                            <span><strong>Nama Perencanaan</strong></span>
                        </div>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" readonly class="form-control" id="Nama_Perencanaan">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <!-- Nama Pengaju -->
                        <div class="col-sm-2">
                            <span><strong>Nama Pengaju</strong></span>
                        </div>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" readonly class="form-control" id="Nama_Pengaju">
                            </div>
                        </div>

                    </div>

                    <!-- Merek Aset -->
                    <div class="row">
                        <div class="col-sm-2">
                            <span><strong>Merek Aset</strong></span>
                        </div>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" readonly class="form-control" id="Merek_Aset">
                            </div>
                        </div>
                    </div>

                    <!-- Harga Satuan -->
                    <div class="row">
                        <div class="col-sm-2">
                            <span><strong>Harga Satuan</strong></span>
                        </div>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" readonly class="form-control" id="Harga_Satuan">
                            </div>
                        </div>
                    </div>

                    <!-- Jumlah Aset -->
                    <div class="row">
                        <div class="col-sm-2">
                            <span><strong>Jumlah Aset</strong></span>
                        </div>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" readonly class="form-control" id="Jumlah_Aset">
                            </div>
                        </div>
                    </div>

                    <!-- Total Harga -->
                    <div class="row">
                        <div class="col-sm-2">
                            <span><strong>Total Harga</strong></span>
                        </div>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" readonly class="form-control" id="Total_Harga">
                            </div>
                        </div>
                    </div>

                    <!-- Alasan -->
                    <div class="row">
                        <div class="col-sm-2">
                            <span><strong>Alasan</strong></span>
                        </div>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <textarea class="form-control" name="Alasan" id="Alasan" cols="30" rows="5" readonly></textarea>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('modal-footer')
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tutup</button>
    </div>
@endsection 
