<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<table border="1">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="data">
    </tbody>
</table>
<style>
    #modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.4);
        width: 100%;
        height: 100%;
        overflow: auto;
        padding-top: 150px;
        padding-left: 50px;
    }

    #modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 40%;
        border-radius: 8px;
    }

    #close {
        float: right;
        background-color: red;
        padding: 5px;
        border-radius: 3px;
        cursor: pointer;
    }

    h3 {
        text-align: center;
    }
</style>

<div id="modal">
    <div id="modal-content">
        <span id="close">X</span>
        <h3>Edit Form</h3>
        <form id="e-form" enctype="multipart/form-data">
        </form>
    </div>
</div>
<script>
    $(function(){
        function load(){
            $.ajax({
                url:"{{route('data')}}",
                method:"GET",
                success:function(res){
                   let html = ''

                    res.data.forEach(student => {
                        html += `
                            <tr>
                                <td>${student.name}</td>
                                <td>${student.email}</td>
                                <td><img src='${student.image}' height='100px' width='100px'/></td>
                                <td><button class='edit' data-id=${student.id}>Edit</button> | <button class='delete' data-id=${student.id}>Delete</button></td>
                            </tr>
                        `
                    });
                    $('#data').html(html)
                },
                error:function(xhr){
                    console.log(xhr.responsJSON.error);

                }
            })
        }
        load()

        $(document).on('click','#close',function(e){
            e.preventDefault()

            $('#modal').hide()
        })

        $(document).on('click','.edit',function(e){
            e.preventDefault()
            $('#modal').show()

            let id = $(this).data('id')

            $.ajax({
                url:"{{route('edit',':id')}}".replace(':id',id),
                method:"GET",
                data:{id:id},
                success:function(data){
                    if (data.edit) {
                        $('#e-form').html(`
                            @csrf
                            <input type='text' id='name' value='${data.edit['name']}'><br>
                            <input type='text' id='email' value='${data.edit['email']}'><br>
                            <input type='file' id='image'><br>
                            <input type='submit' id='update' data-id=${data.edit['id']}>
                        `)
                    }
                },
                error:function(err){
                    console.error(err.responseJSON.error);

                }
            })
        })

        $(document).on('click','#update',function(e){
            e.preventDefault()

            let form = new FormData()

            let id = $(this).data('id')
            console.log(id);


            form.append('_token','{{csrf_token()}}')
            form.append('_method','PATCH')
            form.append('name',$('#name').val())
            form.append('email',$('#email').val())
            form.append('image',$('#image')[0].files[0])

            $.ajax({
                url:"{{route('update',':id')}}".replace(':id',id),
                method:"POST",
                data:form,
                processData:false,
                contentType:false,
                success:function(data){
                    load()
                    $('#modal').hide()
                },
                error:function(xhr){
                    console.error("Error"+xhr.responseJSON.error);
                }
            })
        })

        $(document).on('click','.delete',function(e){
            e.preventDefault()

            let id = $(this).data('id')

            let self = this

            $.ajax({
                url:"{{route('delete',':id')}}".replace(':id',id),
                method:"DELETE",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Add CSRF token here
                },
                success:function(data){
                    $(self).closest('tr').remove()
                },
                error:function(e){
                    console.error(e.responseText);
                }
            })
        })
    })
</script>
