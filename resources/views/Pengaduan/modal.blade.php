@extends('layouts-front.modal')

<!-- Modal ID -->
@section('modal-id') #modal @endsection

<!-- Title -->
@section('modal-title') Silahkan arahkan barcode pada webcam  @endsection

<!-- Body -->
@section('modal-body')
    <div class="row">
        <div class="col-sm-12">
            <div class="text-center">
                <video id="preview"></video>
            </div>
        </div>
    </div>
@endsection

<!-- Modal Footer -->
@section('modal-footer')
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
    </div>
@endsection

