@extends('layouts.master')
@section('body')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">

<section class="content">
	<div class="container-fluid">
		<div class="row mb-3 text-right">
			<div class="col-md-12">
				<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-new-user-modal">Add New User</a>
			</div>
		</div> 
		@if(session('success'))		
			<div class="alert alert-success" role="alert">
				<div class="alert-text">{{session('success')}}</div>
			</div>
		@endif
		<div class="row">
			<div class="col-md-12">
				<table class="table table-stripped text-center" id="customer_table">
					<thead>
						<tr>
							<th>Id</th>
							<th>Name</th>
							<th>Email</th>
							<th>Username</th>
							<th>Password</th>
							<th>Avatar</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($users as $user)
							<tr>
								<td>{{$user->id}}</td>
								<td>{{$user->name}}</td>
								<td>{{$user->email}}</td>
								<td>{{$user->username}}</td>
								<td>{{$user->password}}</td>
								<td>
									<img src="{{asset('storage/'.$user->avatar)}}" class="img-fluid" width="100" height="100">
								</td>
								<td>
									<a href="" onclick="set_value({{$user->id}}, '{{$user->name}}', '{{$user->email}}', '{{$user->username}}', '{{$user->password}}')" class="btn btn-secondary" data-toggle="modal" data-target="#update-user-modal"><i class="fas fa-pencil-alt"></i></a>
									<a href="{{route('users.delete', $user->id)}}" class="btn btn-danger ml-2"><i class="fas fa-trash"></i></a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
	</div>
</section>


<!-- Add New User Modals -->
<div class="modal fade" id="add-new-user-modal">
	<div class="modal-dialog">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title">Add New Users</h4>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	      </button>
	    </div>
	    <div class="modal-body">
	      <!-- Form Start -->
	      <form id="add-user-form" role="form" data-plugin="ajaxForm" enctype="multipart/form-data">
	      	@csrf()
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputName">User Name</label>
                    <input type="text" id="name" name="name" class="form-control" id="exampleInputEmail1" placeholder="Enter user name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" id="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPhone">Username</label>
                    <input type="text" id="username" name="username" class="form-control" id="exampleInputPassword1" placeholder="Enter username">
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter password">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPhone">Avatar</label>
                    <input type="file" accept="Image/*" id="avatar" name="avatar" class="form-control">
                  </div>
                </div>
                <!-- /.card-body -->
				<hr>
                <div class="">
                	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                  	<input type="submit" id="my-btn" class="btn btn-primary float-right" value="Save">
                </div>
              </form>
	      <!-- End of Form -->
	    </div>
	  </div>
	  <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- End of Add New User Modals -->

<!-- Edit Modal -->
<div class="modal fade" id="update-user-modal">
	<div class="modal-dialog">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title">Update User</h4>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	      </button>
	    </div>
	    <div class="modal-body">
	      <!-- Form Start -->
	      <form id="update-user-form" role="form" data-plugin="ajaxForm" enctype="multipart/form-data" method="post">
	      	@csrf()
                <div class="card-body">
                  <div class="form-group">
                  	<input type="hidden" name="user_id" id="user_id">
                    <label for="exampleInputName">User Name</label>
                    <input type="text" id="update_name" name="name" class="form-control" id="exampleInputEmail1" placeholder="Enter user name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" id="update_email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPhone">Username</label>
                    <input type="text" id="update_username" name="username" class="form-control" id="exampleInputPassword1" placeholder="Enter username">
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" id="update_password" name="password" class="form-control" placeholder="Enter password">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPhone">Avatar</label>
                    <input type="file" accept="Image/*" id="avatar" name="avatar" class="form-control">
                  </div>
                </div>
                <!-- /.card-body -->
				<hr>
                <div class="">
                	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                  	<input type="submit" class="btn btn-primary float-right" value="Update">
                </div>
              </form>
	      <!-- End of Form -->
	    </div>
	  </div>
	  <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- End of Edit Modal -->

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#add-user-form').on('submit', function(e){
		e.preventDefault();
		let name = $('#name').val();
		let email = $('#email').val();
		let username = $('#username').val();
		let password = $('#password').val();
		let avatar = $('#avatar').val();
			$.ajax({
				url: "{{route('users.submit')}}",
				method: "POST",
				data: new FormData(this),
				dataType:'JSON',
			    contentType: false,
			    cache: false,
			    processData: false,
				success:function(response){
					// alertify.set('notifier','position', 'top-right');
	    //         	alertify.success('Customer Added!');
	   
	    location.reload();
	            	$('#add-new-user-modal').modal('hide');
				},
				error: function(ts) { alert(ts.responseText) }
			});

		});
	});
</script>

<script>

$(document).ready(function(){
		$('#update-user-form').on('submit', function(e){
		e.preventDefault();

			$.ajax({
				url: "{{route('users.update')}}",
				method: "POST",
				data: new FormData(this),
				dataType:'JSON',
			    contentType: false,
			    cache: false,
			    processData: false,
				success:function(response){
					// alertify.set('notifier','position', 'top-right');
	    //         	alertify.success('Customer Added!');
	   
	    location.reload();
	            	$('#update-user-modal').modal('hide');
				},
				// error: function(ts) { alert(ts.responseText) }
			});


		});
	});

</script>

<script type="text/javascript">
		function set_value(id, name, email, username, password)
		{
			$('#user_id').val(id);
			$('#update_name').val(name);
			$('#update_email').val(email);
			$('#update_username').val(username);
			$('#update_password').val(password);
		}
</script>

<script type="text/javascript">
	$(document).ready( function () {
	    $('#customer_table').DataTable();
	} );
</script>