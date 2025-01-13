<div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <table border="1" id="table">
        <thead>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Image</th>
            <th>Action</th>
        </thead>
    </table>
</div>
<script>
    $(document).ready(function(){
        $.ajax({
            type:"GET",
            url:"{{route('student.display')}}",
            success:function(data){
                console.log(data);
                if (data.students.length > 0) {
                    for (let i = 0; i < data.students.length; i++) {
                        let img = data.students[i]['image']
                        let imgPath = img.includes('upload/')
                            ? "{{ asset('') }}" + img // Use directly if full path is provided
                            : "{{ asset('upload') }}/" + img;
                        console.log(imgPath);

                        $('#table').append(`
                            <tr>
                                <td>`+(data.students[i]['name'])+`</td>
                                <td>`+(data.students[i]['email'])+`</td>
                                <td>`+(data.students[i]['phone'])+`</td>
                                <td><img src="${imgPath}" height="100px" width="100px"/></td>
                                <td><a href="edit-student/`+(data.students[i]['id'])+`">Edit</a> |
                                    <a href="#" class="delete-student" data-id="`+ data.students[i]['id'] +`" >Delete</a></td>
                            </tr>
                        `)

                    }
                } else {
                    $('#table').append(`
                        <tr>
                            <td colspan="4">No Data Found</td>
                        </tr>
                    `)
                }
            },
            error:function(err){
                console.log(err);
            }
        })

        $('#table').on('click','.delete-student',function(e){
            e.preventDefault();
            let id = $(this).attr('data-id')
            let self = this
            if(confirm('Are you sure you want to delete ?')){
                $.ajax({
                    type:"GET",
                    url:"{{url('delete-student')}}/" + id,
                    success:function(e){
                        $(self).closest('tr').remove();
                        alert('Data deleted');
                    },
                    error:function(e){
                        e.responseText()
                    }
                })
            }
        })

    })
</script>
