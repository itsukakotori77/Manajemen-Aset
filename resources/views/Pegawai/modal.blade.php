@extends('layouts.modal')

@section('modal-id') #modal @endsection

@section('modal-title') <h5>Data Personal Pegawai</h5> @endsection

@section('modal-body')
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="pd-20 card-box height-100-p">
                    <div class="profile-photo">
                        <img id="foto-user" src="" alt="" class="avatar-photo" style="width: 200px;">
                    </div>
                    <h5 class="text-center h5 mb-0" id="Name"></h5>
                    <p class="text-center text-muted font-14" id="Role_User"></p>
                    <div class="profile-info">
                        <ul>
                            <li>
                                <span>Username:</span>
                                <p id="Username_User"></p>
                            </li>
                            <li>
                                <span>Email Address:</span>
                                <p id="Email_User"></p>
                            </li>
                            <li>
                                <span>Address:</span>
                                <p id="Alamat_User">
                                    
                                </p> 
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal-footer')
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tutup</button>
    </div>
@endsection 
