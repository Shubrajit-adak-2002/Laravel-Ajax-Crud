<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <div>
        <form enctype="multipart/form-data" id="form">
            @csrf
            Name : <input type="text" name="name" id=""><br>
            Email : <input type="text" name="email" id=""><br>
            Phone : <input type="text" name="phone" id=""><br>
            <input type="file" name="image" id=""><br>
            <button>Submit</button>
        </form>
        <span id="output"></span>
    </div>

    <script>
        $(document).ready(function(){
            $('#form').submit(function(e){
                e.preventDefault()
                let form = $('#form')[0]

                let data = new FormData(form)

                $.ajax({
                    type: "POST",
                    url: "{{route('submit')}}",
                    data: data,
                    processData: false,
                    contentType:false,
                    success:function(data){
                        $('#output').text(data.res)
                    },
                    error:function(e){
                        console.log(e.responseText);
                    }
                })
            })
        })
    </script>
</body>
</html>
