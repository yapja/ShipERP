<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
   
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" class="href">
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
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
        <div class="shadow p-3">
            <ul class="nav nav-tabs card-header-tabs justify-content-around">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" aria-current="page" href="#view">View</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#add">Add</a>
                </li>
            </ul>
            <form class="card-body tab-content">
                <div class="tab-pane active" id="view">
                    <div class="p-2">
                        <img src="https://images.dog.ceo/breeds/shihtzu/n02086240_5696.jpg" alt="Image">
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary" type="submit">Randomize</button>
                    </div>
                </div>
                
                <div class="tab-pane p2" id="add">
                    <div class="p-2">
                        <table class="table table-bordered datatable">
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
                    <div class="text-center">
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</body>
</html>

<script type="text/javascript">

$(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var table = $(".datatable").DataTable({
        serverSide: true,
        processing: true,
        ajax: '{{ route("getImages") }}'
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
    });
});

</script>
