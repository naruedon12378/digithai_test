@extends('adminlte::page')
@section('title', 'Employee')
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
            <h1>Employee</h1>
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
                                        <th scope="col" class="">Name</th>
                                        <th scope="col" class="">Email</th>
                                        <th scope="col" class="">Phone</th>
                                        <th scope="col" class="">Company</th>
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
                                    <label for="f1" class="col-form-label">Firstname</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                                </div>
                                <div class="div">
                                    <label for="f1" class="col-form-label">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" >
                                </div>
                                <div class="div">
                                    <label for="f1" class="col-form-label">Company</label>
                                    <select name="company" id="company" class="form-select" required>
                                        @foreach ($companies as $company)
                                            <option value="{{$company->id}}">{{$company->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <div class="div">
                                    <label for="f1" class="col-form-label">Lastname</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                                </div>
                                <div class="div">
                                    <label for="f1" class="col-form-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" >
                                </div>
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
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <script>
        $(function() {
            var data_list_tbl = $('#data_list_tbl').DataTable({
                pageLength: 10,
                responsive: true,
                processing: true,
                serverSide: true,
                serverMethod: 'post',
                ajax: {
                    url: '{{route('api.v1.employee.list')}}',
                },
                columns: [
                    {data: 'first_name', render : function(data,type,row,meta){
                        let full_name = row.first_name + ' ' + row.last_name;
                        return  full_name;
                    }},
                    {data: 'email'},
                    {data: 'phone', render : function(data,type,row,meta){
                        var symbol = "-";
                        var position = 3;
                        var output = [data.slice(0, position), symbol, data.slice(position)].join('');
                        return  output;
                    }},
                    {data: 'company', render : function(data,type,row,meta){
                        let company_name = row.company.name;
                        return  company_name;
                    }},
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
                    { responsivePriority: 1, targets: [0,1,5] },
                ],
                "dom": '<"top my-1 mr-1"f>rt<"bottom d-flex position-absolute w-100 justify-content-between px-1 mt-3"ip><"clear">'
            });

            $(document).on('click', '.btn-modal', function() {
                let id = $(this).data('id');
                $('#id').val(id);
                $('#dataModal').modal('show');
                if (!id) {
                    resetModal();
                } else {
                    $.ajax({
                        type: "post",
                        url: "{{route(('api.v1.employee.view.edit'))}}",
                        data: {'id': id},
                        dataType: "json",
                        success: function(response) {
                            $('#id').val(response.id);
                            $('#first_name').val(response.first_name);
                            $('#last_name').val(response.last_name);
                            $('#email').val(response.email);
                            $('#phone').val(response.phone);
                            $('#company').val(response.company).change();

                        }
                    });
                }
            });

            function resetModal() {
                $('#id').val('');
                $('#first_name').val('');
                $('#last_name').val('');
                $('#email').val('');
                $('#phone').val('');
                $('#company').val(1).change();
            }

            $(document).on('click', '.btn-reset', function() {
                resetModal();
            });

            $('.btn-save').on('click', function() {
                var id = $('#id').val();
                if($('#validForm').valid()){
                    var formData = new FormData();
                    formData.append('_token', $('#_token').val());
                    formData.append('id', $('#id').val());
                    formData.append('first_name', $('#first_name').val());
                    formData.append('last_name', $('#last_name').val());
                    formData.append('email', $('#email').val());
                    formData.append('phone', $('#phone').val());
                    formData.append('company', $('#company').val());

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
                                    url: "{{route('api.v1.employee.create')}}",
                                    data: formData,
                                    contentType: false,
                                    processData: false,
                                    cache: false,
                                    success: function(response) {
                                        if (response) {
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
                                    url: "{{route('api.v1.employee.edit')}}",
                                    data: formData,
                                    contentType: false,
                                    processData: false,
                                    cache: false,
                                    success: function(response) {
                                        if (response) {
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
                            url: "{{route('api.v1.employee.delete')}}",
                            data: {
                                'id':id,
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response) {
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
