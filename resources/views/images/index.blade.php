<!doctype html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" class="href">
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    
    <title>ShipERP Technical Assessment</title>
</head>

<style>
    body{
    height: 100vh;
    }
    .container{
        height: 100%;
    }
</style>

<body>
    <div class="container d-flex align-items-center justify-content-center">
        <div class="shadow card w-50 h-50 p-2">
            <ul class="nav nav-tabs justify-content-around">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" aria-current="page" href="#view" id="viewTab">View</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#add" id="manageTab">Manage</a>
                </li>
                </ul>
            <form class="card-body tab-content">
                <div class="tab-pane active" id="view">
                    <div class="d-flex justify-content-center">
                        <p id="providerDisplay"></p>
                    </div>
                    <div class="p-1 d-flex justify-content-center">
                        <img id="imageDisplay" class="rounded">
                    </div>
                    <div class="pb-3 text-center position-absolute bottom-0 start-50 translate-middle-x">
                        <a class="btn btn-primary" href="javascript:void(0)" id="randomizeImage">Randomize</a>
                    </div>
                </div>
                
                <div class="tab-pane p2" id="add">
                    <div class="p-2">
                        <table class="table table-bordered data-table w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Provider</th>
                                    <th>URL</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="pb-3 text-center position-absolute bottom-0 start-50 translate-middle-x">
                        <a class="btn btn-primary" href="javascript:void(0)" id="submitImage">Submit an Image</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="imageModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100" id="modalHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="submitImageForm" name="submitImageForm" class="form-horizontal">
                        <input type="hidden" name="imageid" id="imageid">
                        <div class="form-group">
                            Provider: <br>
                            <input type="text" class="form-control" id="provider" name="provider" placeholder="Enter Name" required>
                        </div>
                        <div class="form-group">
                            URL: <br>
                            <input type="text" class="form-control" id="url" name="url" placeholder="Enter URL" required>
                        </div>
                        <div class="pt-3 text-center">
                            <button type="submit" class="btn btn-primary" id="submitImageButton">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">

$(function(){
    const isValidUrl = urlString=> {
	
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('.data-table').DataTable({
        bDestroy: true,
        responsive: true,
        serverSide: true,
        processing: true,
        ajax: '{{ route("images.index") }}',
        columns:[
            {data: 'id', name: 'id'},
            {data: 'provider', name: 'provider'},
            {data: 'url', name: 'url'},
            {
                data: 'actions', 
                name: 'actions', 
                orderable: false, 
                searchable: false
            },
        ],
        order:  [[ 0, "desc"]],
        'columnDefs': [{
            "targets": [0],
            "visible": false,
        }],
        pageLength: 5,
        bFilter: false,
        lengthChange: false,        
    });

    $('body').on('click', '#randomizeImage', function(e) {
        e.preventDefault();

        $.ajax({
            type: 'GET', 
            dataType: 'json',
            url: '{{ route("randomize") }}',
            success: function(data) {
                console.log(data);
                $('#providerDisplay').html(data.provider);
                $('#imageDisplay').attr('src', data.url).val();
            }
        });
    });

    $('#manageTab').click(function(e){
        e.preventDefault();
    });
    

    $('#submitImage').click(function(){
        $('#imageid').val('');
        $('#submitImageButton').html('Add');
        $('#submitImageForm').trigger('reset');
        $('#modalHeading').html('Submit Image');
        $('#imageModal').modal('show');
    });


    $('#submitImageButton').click(function(e){
        e.preventDefault();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            data:$('#submitImageForm').serialize(),
            url: '{{ route("images.store") }}',
            success: function(data){
                $('#submitImageForm').trigger('reset');
                $('#imageModal').modal('hide');
                table.draw(data);
            },
            error: function(data){
                console.log('Error', data);
            }    
        });
    });

    $('body').on('click', '.editImage', function() {
        var image_id = $(this).data('id');
        $('#submitImageButton').html('Update');
        $.get('{{ route("images.index") }}' + '/' + image_id + '/edit', function(data) {
            $('#modalHeading').html('Update Image');
            $('#imageModal').modal('show');
            $('#imageid').val(data.id);
            $('#provider').val(data.provider);
            $('#url').val(data.url);
        });
    });

    $('body').on('click', '.deleteImage', function() {
        var image_id = $(this).data('id');
        $.ajax({
            type: 'DELETE',
            url: '{{ route("images.store") }}' + '/' + image_id,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error', data);
            }
        });
    });   
});

</script>
</html>


