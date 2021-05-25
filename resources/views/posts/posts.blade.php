@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Posts') }}</div>
                <div><button type="button" class="btn btn-primary">ADD POST</button></div>
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
@push('js')
<script>
    $(document).ready(function() {
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
                        type: 'delete',
                        complete: function() {
                            if(table == 'logic_delete')
                                location.reload();
                            else
                                table.ajax.reload();
                        },
                        success: function(res) {
                            $('tr[row_id="'+id+'"]').remove();
                            Swal.fire(
                                'Deleted!',
                                'Your record has been deleted.',
                                'success'
                            );
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