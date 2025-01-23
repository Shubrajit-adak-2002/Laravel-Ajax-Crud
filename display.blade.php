<div>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <table border="1">
        <thead>
            <th>Name</th>
            <th>Email</th>
            <th>Image</th>
            <th>Action</th>
        </thead>
        <tbody id="data"></tbody>
    </table>
    <div id="edit-f"></div>
</div>
<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ route('display') }}",
            method: "GET",
            success: function(data) {
                console.log(data);
                if (data.students.length > 0) {
                    for (let i = 0; i < data.students.length; i++) {
                        let image = data.students[i]['image']
                        let imgPath = image.includes('upload/') ? "{{ asset('') }}" + image :
                            "{{ asset('upload') }}/" + image

                        $('#data').append(`
                            <tr>
                                <td>` + (data.students[i]['name']) + `</td>
                                <td>` + (data.students[i]['email']) + `</td>
                                <td><img src="${imgPath}" height="100px" width="100px" alt="Student Image"></td>
                                <td><button class="edit-btn" data-id="` + data.students[i]['id'] + `">Edit</button>
                                     | <button class="delete-btn" data-id="${data.students[i]['id']}">Delete</button></td>
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
            error: function(err) {
                console.log(err);
            }
        })

        $(document).on('click', '.edit-btn', function(e) {
            e.preventDefault()
            let id = $(this).data('id');
            console.log(id);

            $.ajax({
                url: "{{ route('edit',':id') }}".replace(':id',id),
                method: "GET",
                success: function(data) {
                    if (data.student) {
                        $('#edit-f').html(`
                        <form enctype="multipart/form-data" id="e-form">
                            @csrf
                            Name : <input type="text" name="name" value="`+(data.student['name'])+`" id="name"><br>
                            Email : <input type="text" name="email" value="`+(data.student['email'])+`" id="email"><br>
                            <input type="file" name="image" id="image"><br>
                            <button id="update" data-id="${data.student['id']}">Update</button>
                        </form>
                        `)
                    }else {
                        $('#edit-f').html('<p>Student not found.</p>');
                    }
                },
                error:function(xhr){
                    console.error("Responded Text",xhr.responseText);
                }
            })
        })

        function load(){
            $.ajax({
                url: "{{ route('display') }}",
                method: "GET",
                success: function (response) {
                    let html = '';
                    response.students.forEach(student => {
                        html += `
                            <tr>
                                <td>${student.name}</td>
                                <td>${student.email}</td>
                                <td><img src="${student.image}" alt="Image" width="50"></td>
                                <td>
                                    <button class="edit-btn" data-id="${student.id}">Edit</button>
                                    | <button class="delete-btn" data-id="${student.id}">Delete</button></td>
                                </td>
                            </tr>
                        `;
                    });
                    $('#data').html(html);
                },
                error:function(xhr){
                    console.error("Error"+xhr.responseJSON.error);
                }
            })
        }

        load()

        $(document).on('click','#update',function(e){
            e.preventDefault()

            let form = $('#e-form')[0]
            let id = $(this).data('id')

            let formData = new FormData(form)

            $.ajax({
                url:"{{route('update',':id')}}".replace(':id',id),
                method:"POST",
                data:formData,
                processData:false,
                contentType:false,
                success:function(data){
                    alert('Data updated')
                    load()
                },
                error:function(xhr){
                    console.error("Error"+xhr.responseJSON.error);
                }
            })
        })

        $(document).on('click','.delete-btn',function(e){
            e.preventDefault()
            let id = $(this).data('id')
            let self = this

            $.ajax({
                url:"{{route('delete',':id')}}".replace(':id',id),
                method:"POST",
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
