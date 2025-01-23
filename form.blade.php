<div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<form id="form" action="" method="post" enctype="multipart/form-data">
    @csrf
    Name: <input type="text" name="" id="name"><br>
    Email: <input type="text" name="" id="email"><br>
    <input type="file" name="" id="image"><br>
    <button id="submit">Submit</button>
</form>
<div id="output"></div>
</div>
<script>
    $(document).ready(function(){
        $('#submit').on('click',function(e){
            e.preventDefault()
            let form = new FormData()
            form.append('_token', '{{ csrf_token() }}'); // Add CSRF token here
            form.append('name',$('#name').val())
            form.append('email',$('#email').val())
            form.append('image',$('#image')[0].files[0])

            $('#form').trigger('reset')

            $.ajax({
                url:"{{route('submit')}}",
                method:"POST",
                data:form,
                processData:false,
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
