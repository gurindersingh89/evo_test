@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Posts') }}
                    <button type="button" class="btn btn-primary" style="float:right;" id="add_button">ADD POST</button>
                </div>
                <table class="table table-bordered mb-5">
                    <thead>
                        <tr class="table-success">
                            <th scope="col">Id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $data)
                        <tr row_id="{{$data->id}}">
                            <th scope="row">{{ $data->id }}</th>
                            <td>{{ $data->name }}</td>
                            <td><button type="button" class="btn btn-primary edit"  row_id="{{$data->id}}">Edit</button>
                                <button type="button" class="btn btn-danger delete" row_id="{{$data->id}}">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                    {!! $posts->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="my-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Add Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="px-3">
                    <form class="form">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group p-lr-30">
                                    <label for="post_name">Name</label>
                                    <input type="text" id="post_name" class="form-control" name="post_name" />
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="ft-x"></i> Close</button>
                <button type="button" class="btn btn-primary" id="save" edit="false"><i class="fa fa-check-square-o"></i> Save</button>
            </div>
        </div>
    </div>
</div>
@push('js')
<script>
    $(document).ready(function() {
        
        $('#add_button').on('click', function() {
            $('#modal_title').text('Add Post');
            $('#my-modal').modal('show');
            $('#save').attr('edit', false);
        });

        $('#save').on('click', function() {
            var name = $('#post_name').val();
            var url = 'posts';
            var type = 'POST';

            if($(this).attr('edit') == 'true'){
                url += '/' + $(this).attr('row_id');
                type = 'PUT'
            }
            $.ajax({
                url: url,
                type: type,
                data: {name},
                complete: function() {},
                success: function(res) {
                    $('#my-modal').modal('hide');
                    toastr.success(res.message);
                    location.reload();
                },
                error:function(jqXHR, textStatus, errorThrown) {
                    var error = jqXHR.responseJSON.errors;
                    $.each(error, function(k, v) {
                        toastr.error(v[0]);
                    });
                }
            });
        });

        $('.edit').click(function(){
            var id = $(this).attr('row_id');
            var url = 'posts/'+id;
            $.ajax({
                url: url,
                type: 'GET',
                complete: function() {},
                success: function(res) {
                    if(res.type == 'success'){
                        post = res.data;
                        $('#modal_title').text('Edit Post');
                        $('#my-modal').modal('show');
                        $('#post_name').val(post.name);
                        $('#save').attr({'edit': true, row_id: id});
                    }
                }
            });
        });
        $('.delete').click(function(){
            var id = $(this).attr('row_id');
            var url = 'posts/'+id;
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            })
            .then((willDelete) => {
                if (willDelete.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        complete: function() {},
                        success: function(res) {
                            $('tr[row_id="'+id+'"]').remove();
                            toastr.success('Post Deleted Successfully');
                            // location.reload();
                        }
                    });
                } else {
                    swal.fire("Your record is safe!");
                }
            });
        });
    });

</script>
@endpush
@endsection