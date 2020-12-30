<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Silahkan arahkan barcode pada webcam</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card card-box">
                            <div class="card-header">
                                <h3><span id="Nama_Aset"></span></h3>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title" id="Jenis_Aset">Jenis Aset</h5>
                                <p class="card-text" id="">
                                    <ul>
                                        <li id="Merk_Aset"></li>
                                        <li id="Jumlah_Aset"></li>
                                        <li id="Harga_Aset"></li>
                                        <li id="Total_Harga"></li>
                                    </ul>
                                </p>
                                <strong>Keterangan</strong>
                                <p class="card-text" id="Keterangan"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-center">
                            <h3>QRcode</h3>
                            <img class="product" id="QrCode_Aset" width="200px">
                            <button id="generate" class="btn btn-success btn-sm" style="width: 200px;"><strong>Generate QRcode</strong></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
