<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<div>
    <label for="search">Search</label>
    <input type="text" name="search" id="search">
    <div id="result"></div>
</div>
<script>
    $(document).ready(function(){
        $('#search').on('keyup',function(){
            let value = $(this).val()
            $.ajax({
                type:"GET",
                url:"{{route('search')}}",
                data:{'name':value},
                success:function(data){
                    $('#result').html(data)
                }
            })
        })

        $(document).on('click','li',function(){
            var value = $(this).text()
            $('#search').val(value)
            $('#result').html('')
        })
    })
</script>
