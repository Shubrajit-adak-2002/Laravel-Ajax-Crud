<div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <img src="{{ asset($student->image)}}" width="100px" alt="">
    <form enctype="multipart/form-data" id="form">
        @csrf
        <input type="hidden" name="id" value="{{$student->id}}">
        Name : <input type="text" value="{{$student->name}}" name="name" id=""><br>
        Email : <input type="text" value="{{$student->email}}" name="email" id=""><br>
        Phone : <input type="text" value="{{$student->phone}}" name="phone" id=""><br>
        <input type="file" name="image" id=""><br>
        <button>Submit</button>
    </form>
</div>
<script>
    $(document).ready(function(){
            $('#form').submit(function(e){
                e.preventDefault()
                let form = $('#form')[0]

                let data = new FormData(form)

                $.ajax({
                    type: "POST",
                    url: "{{route('student.update')}}",
                    data: data,
                    processData: false,
                    contentType:false,
                    success:function(data){
                        alert(data.res)
                        window.open("/show","_self")
                    },
                    error:function(e){
                        console.log(e.responseText);
                    }
                })
            })
        })
</script>
