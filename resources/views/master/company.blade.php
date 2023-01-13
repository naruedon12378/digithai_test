@extends('adminlte::page')
@section('title', 'Company')
@section('css')
<style>
    .error {
        color: #DC3545 !important;
        font-size: 14px;
    }
</style>
@endsection
@section('content')
<div class="container-fluid mt-2">
    <div class="row">
        <div class="col-8 align-self-lg-center">
            <button type="button" class="btn btn-success border btn-modal" data-toggle="modal" data-bs-target="#dataModal"><i class="fa fa-plus-circle" aria-hidden="true"></i> ADD</button>
        </div>
        <div class="col-4 text-right">
            <h1>Company</h1>
        </div>
    </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline">
                    <div class="card-body py-2 px-1">
                        <div class="col-12 ">
                            <table id="data_list_tbl" class="table dt-responsive nowrap w-100" style="margin-top: 0!important; margin-bottom: 0!important;">
                                <caption style="display: none"></caption>
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">Logo</th>
                                        <th scope="col" class="">Company</th>
                                        <th scope="col" class="">Website</th>
                                        <th scope="col" class="">Email</th>
                                        <th scope="col" class="">Address</th>
                                        <th scope="col" class="col-1 text-center">Edit</th>
                                        <th scope="col" class="col-1 text-center">Delete</th>
                                    </tr>
                                </thead>
                                <tbody class="text-muted">
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
</div>

<div class="modal fade" id="dataModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container">
                    <form id="validForm">
                        @csrf
                        <div class="col-12">
                            <input type="hidden" name="id" id="id">
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <div class="div">
                                    <label for="f1" class="col-form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="div">
                                    <label for="f1" class="col-form-label">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" >
                                </div>
                                <div class="div">
                                    <label for="f1" class="col-form-label">Website</label>
                                    <input type="text" class="form-control" id="website" name="website" >
                                </div>
                                <div class="div">
                                    <label for="f1" class="col-form-label">Address</label>
                                    <textarea class="form-control" name="address" id="address" cols="30" rows="6" ></textarea>
                                </div>
                            </div>
                            <div class="form-group col-6 text-center">
                                <label for="f1" class="col-form-label">Logo <small>(*min 100x100px)</small></label>
                                <img id="show_img" class="form-control" style="max-height:350px;max-width:100%;height:auto;width:100%;"  src="{{asset('storage/default.png')}}" alt="your image" />
                                <input type="file" class="form-control" id="logo" name="logo" required>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning btn-reset" data-bs-dismiss="modal"><em class="fas fa-close"></em> ยกเลิก</button>
                <button type="button" class="btn btn-success btn-save" ><em class="fas fa-save "></em> บันทึก</button>
            </div>
        </div>
    </div>
</div>
@stop



@section('js')
    {{-- components --}}
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
    <link href="https://cdn.datatables.net/responsive/2.2.4/css/responsive.dataTables.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.datatables.net/responsive/2.2.4/js/dataTables.responsive.js"></script>
    <link href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.colVis.js"></script>

    <script>
        $(function() {
            var data_list_tbl = $('#data_list_tbl').DataTable({
                pageLength: 10,
                responsive: true,
                processing: true,
                serverSide: true,
                serverMethod: 'post',
                ajax: {
                    url: '{{route('api.v1.company.list')}}',
                },
                columns: [
                    {data: 'id', render : function(data,type,row,meta){
                        return  `
                                    <img src="{{asset('storage/company-logo/${row.logo}')}}" class="w-100">
                                `;
                    },className: 'text-center'},
                    {data: 'name'},
                    {data: 'website'},
                    {data: 'email'},
                    {data: 'address'},
                    {data: 'id', render : function(data,type,row,meta){
                        return  `
                                    <a data-id="${row.id}"  class="btn btn-xs btn-title-edit btn-modal rounded-pill btn-warning "><i class="fas fa-pencil-alt"></i></a>
                                `;
                    },className: 'text-center'},
                    {data: 'id', render : function(data,type,row,meta){
                            return  `
                                    <a data-id="${row.id}"  class="btn btn-xs btn-danger rounded-pill btn-delete"><i class="fas fa-trash-alt"></i></a>
                                `;
                        },className: 'text-center'},
                ],
                columnDefs: [
                    { responsivePriority: 1, targets: [0,1,5,6] },
                ],
                "dom": '<"top my-1 mr-1"f>rt<"bottom d-flex position-absolute w-100 justify-content-between px-1 mt-3"ip><"clear">'
            });

            $(document).on('click', '.btn-modal', function() {
                let id = $(this).data('id');
                let path = "{{asset('storage/company-logo/')}}"
                $('#id').val(id);
                $('#dataModal').modal('show');
                if (!id) {
                    resetModal();
                } else {
                    $.ajax({
                        type: "post",
                        url: "{{route(('api.v1.company.view.edit'))}}",
                        data: {'id': id},
                        dataType: "json",
                        success: function(response) {
                            $('#id').val(response.id);
                            $('#name').val(response.name);
                            $('#email').val(response.email);
                            $('#website').val(response.website);
                            $('#address').val(response.address);
                            $("#show_img").attr("src",path+'/'+response.logo);
                        }
                    });
                }
            });

            function resetModal() {
                let path = "{{asset('storage/')}}"
                $('#id').val('');
                $('#name').val('');
                $('#email').val('');
                $('#website').val('');
                $('#address').val('');
                $("#show_img").attr("src",path+'/default.png');
                $('#logo').val(null);
            }

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#show_img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#logo").change(function(){
                readURL(this);
            });

            $(document).on('click', '.btn-reset', function() {
                resetModal();
            });

            $('.btn-save').on('click', function() {
                var id = $('#id').val();
                if($('#validForm').valid()){
                    var formData = new FormData();
                    formData.append('_token', $('#_token').val());
                    formData.append('id', $('#id').val());
                    formData.append('name', $('#name').val());
                    formData.append('email', $('#email').val());
                    formData.append('website', $('#website').val());
                    formData.append('address', $('#address').val());
                    formData.append('logo', logo.files[0]);

                    if (!id) {
                        Swal.fire({
                            title: 'Create data ?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes',
                            cancelButtonText: 'No'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: "post",
                                    url: "{{route('api.v1.company.create')}}",
                                    data: formData,
                                    contentType: false,
                                    processData: false,
                                    cache: false,
                                    success: function(response) {
                                        if (response.status == 'success') {
                                            Swal.fire({
                                                position: 'center-center',
                                                icon: 'success',
                                                title: 'Success',
                                                showConfirmButton: false,
                                                timer: 1500
                                            })
                                            $('.btn-reset').click();
                                            data_list_tbl.ajax.reload();
                                        } else {
                                            Swal.fire({
                                                position: 'center-center',
                                                icon: 'error',
                                                title: 'Error',
                                                showConfirmButton: false,
                                                timer: 1500
                                            })
                                        }
                                    }
                                });
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Edit data ?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes',
                            cancelButtonText: 'No'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: "post",
                                    url: "{{route('api.v1.company.edit')}}",
                                    data: formData,
                                    contentType: false,
                                    processData: false,
                                    cache: false,
                                    success: function(response) {
                                        if (response.status == 'success') {
                                            Swal.fire({
                                                position: 'center-center',
                                                icon: 'success',
                                                title: 'Success',
                                                showConfirmButton: false,
                                                timer: 1500
                                            })
                                            $('.btn-reset').click();
                                            data_list_tbl.ajax.reload();
                                        } else {
                                            Swal.fire({
                                                position: 'center-center',
                                                icon: 'error',
                                                title: 'Error',
                                                showConfirmButton: false,
                                                timer: 1500
                                            })
                                        }
                                    }
                                });
                            }
                        });
                    }
                }else{
                    Swal.fire({
                        title: 'Please complete the data.',
                        icon: 'warning',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })

            $(document).on('click', '.btn-delete', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Delete data ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "post",
                            url: "{{route('api.v1.company.delete')}}",
                            data: {
                                'id':id,
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.status == 'success') {
                                    Swal.fire({
                                        position: 'center-center',
                                        icon: 'success',
                                        title: 'Success',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    $('.btn-reset').click();
                                    data_list_tbl.ajax.reload();
                                } else {
                                    Swal.fire({
                                        position: 'center-center',
                                        icon: 'error',
                                        title: 'Error',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                }
                            }
                        });
                    }
                });
            })
        });
    </script>
@stop
