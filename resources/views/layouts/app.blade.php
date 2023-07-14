<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- CSRF token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- jQuery library -->
    <script src="{{asset('/js/jquery.min.js')}}"></script>

    @vite(['resources/js/app.js', 'resources/sass/app.scss'])

    <title>Overview</title>

</head>

<style>
    .error {
        color: #ff0000;
    }
</style>

<body>
    <div class="container text-center mt-4">
        @yield('content')
    </div>
</body>
<script>
    let stat;
    let yr;
    let page = 1;


    // setup ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#stat-selector').change(function(){
        const val = $(this).val()
        stat = val
        search(stat,yr)
    })

    $('#year-selector').change(function(){
        yr = $(this).val()
        search(stat,yr)
    })

    const search = (stat, yr, page) => {

        $('#table-viewer').html("Filtering Record. . . ")
        $.post('/search', {statistic: stat, year: yr, page: page}, function(r){
            $('#table-viewer').html(r)
        }).fail( function(xhr, textStatus, errorThrown) {
            error = JSON.parse(xhr.responseText);
            $('#table-viewer').html("<span class='error'>"+error.message+"</span>")
        });
    }

    $(function(){
       $(document).on("click", "#paginationLinks a", function(event) {
            event.preventDefault();
            page = $(this).attr("href").split("page=")[1];
            search(stat, yr, page);
        });
    })
</script>

</html>