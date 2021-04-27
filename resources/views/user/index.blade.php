
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Users  App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    
    <script
src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.css"/>
 
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>
      <div style="padding: 30px;"></div>
      <div class ="container">
          <div class="row">
              <div class="col-sm-8">
                  <div class="card">
                      <div class="card-header">
                           All Users
                      </div>
                      <div class="card-body">
                          <table class="table table-bordered">
                              <thead>
                                  <tr>
                                      
                                      <th scope="col">id</th>
                                      <th scope="col">email</th>
                                      <th scope="col">phone</th>
                                      <th scope="col">Verified user</th>
                                      <th scope="col">Action</th>
                                  </tr>
                              </thead>
                              <tbody>
                                 
                                {{--  <tr>
                                      <td>1</td>
                                      <td>stefan1</td>
                                      <td>065545343</td>
                                      <td><input type="checkbox" name="verify" value="" checked></td>
                                      <td>
                                        <button type="button" class="btn btn-primary mr-2">Edit</button>
                                        <button type="button" class="btn btn-danger">Delete</button>
                                        
                                      </td>
                                  </tr> --}}
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
              <div class="col-sm-4">
                
                  <div class="card">
                      <div class="card-header">
                          <span id="addUser">Add New User</span>
                          <span id="updateUser">Update User</span>
                      </div> <br/>
                      <div class="card-body">
                          <div class="form-group">
                            <label for="email">Enter email:</label>
                            <input type="email" id="email" name="email">                            
                          </div><br/>
                          <div class="form-group">                            
                            <label for="phone">Phone:</label>
                            <input type="text" id="phone" name="phone">
                          </div><br/>
                          <button class="btn btn-primary" id="addButton" onclick="addData()" type="submit">Add</button>
                          <button class="btn btn-primary" id="updateButton" onclick="updateData()" type="submit">Update</button>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    

     <script>
      $('#addUser').hide();
      $('#addButton').hide();
      $('#updateUser').show();
      $('#updateButton').show();

      $.ajaxSetup({
          headers:{
              'X-CSRF-TOKEN': $('meta [name="csrf-token"]').attr('content')
          }
      })

      function allData(){
          $.ajax({
              type: "GET",
              dataType: 'json',
              url:"/user/all",
              success:function(response){
                  var data = ""
                $.each(response, function(key, value){
                    data = data + "<tr>"
                    data = data + "<td>"+value.id +"</td>"
                    data = data + "<td>"+value.email +"</td>"
                    data = data + "<td>"+value.phone +"</td>"
                    data = data + "<td>"+value.email_verified_at +"</td>"
                    data = data + "<td>"
                    data = data + "<button class='btn btn-primary mr-2' onclick='editData("+value.id+")'>Edit</button>"
                    data = data + "<button class='btn btn-danger'>Delete</button>"
                    data = data + "</td>"
                    data = data + "</tr>"
                })
                $('tbody').html(data);
              }
          })
      }
      allData();
      function clearData(){
          $('#email').val('');
          $('#phone').val('');
          $('#emailError').text('');
          $('#phoneError').text('');
      }
    //-----------------------------add data------------------------------
      function addData(){
        var email=  $('#email').val();
        var phone=  $('#phone').val();

         $.ajax({
                 type: "POST",
                 dataType:"json",
                 data: {email:email, phone:phone},
                
             })
      }
   //-----------------------------edit data------------------------------
    function editData(id){
        $.ajax({
            type: "GET",
            dataType: "json",
            url:"user/edit/"+id,
            success: function(data){
                $('#addUser').hide();
                $('#addButton').hide();
                $('#updateUser').show();
                $('#updateButton').show();
                $('#id').val(data.id);
                $('#email').val(data.email);
                $('#phone').val(data.phone);
                console.log(data);
            }
        })
    }

    //-----------------------------update data------------------------------
    
      function updateData(){
        var id=  $('#id').val(); 
        var email=  $('#email').val();
        var phone=  $('#phone').val();

         $.ajax({
                 type: "POST",
                 dataType: "json",
                 data: { email:email, phone:phone},
                 url: "/user/update/"+id,
                 success:function(data)
                 {
                     clearData();
                     allData();
                    console.log('data updated' );
                 }
                 /*
                 error: function(error){
                     $('#idError').text(error.responseJSON.errors.id);
                     $('#emailError').text(error.responseJSON.errors.email);
                     $('#phoneError').text(error.responseJSON.errors.phone);
                 }
                */
             })
      }
    //-------------------------------delete data-----------------
   /*
    function deleteData($id){
       
         $.ajax({
                 type: "GET",
                 dataType: "json",
                 url: "/user/destroy/"+id,
                 success:function(data)
                 {
                    $('#addUser').hide();
                $('#addButton').hide();
                $('#updateUser').show();
                $('#updateButton').show();
                     clearData();
                     allData();
                    console.log('deleted' );
                 }
         */
     </script>

</body>
</html>
