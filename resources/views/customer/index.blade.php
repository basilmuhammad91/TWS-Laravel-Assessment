@extends('layouts.master')
@section('body')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">

<section class="content">
	<div class="container-fluid">
		<div class="row mb-3 text-right">
			<div class="col-md-12">
				<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-new-customer-modal">Add New Customer</a>
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
							<th>Phone</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($customers as $customer)
							<tr>
								<td>{{$customer->customer_id}}</td>
								<td>{{$customer->name}}</td>
								<td>{{$customer->email}}</td>
								<td>{{$customer->phone}}</td>
								<td>
									<a href="" onclick="set_value({{$customer->customer_id}}, '{{$customer->name}}', '{{$customer->email}}', '{{$customer->phone}}')" class="btn btn-secondary" data-toggle="modal" data-target="#update-customer-modal"><i class="fas fa-pencil-alt"></i></a>
									<a href="{{route('customers.delete', $customer->customer_id)}}" class="btn btn-danger ml-2"><i class="fas fa-trash"></i></a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
	</div>
</section>


<!-- Add New Customer Modals -->
<div class="modal fade" id="add-new-customer-modal">
	<div class="modal-dialog">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title">Add New Customer</h4>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	      </button>
	    </div>
	    <div class="modal-body">
	      <!-- Form Start -->
	      <form id="add-customer-form" role="form" data-plugin="ajaxForm">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputName">Customer Name</label>
                    <input type="text" id="name" name="name" class="form-control" id="exampleInputEmail1" placeholder="Enter customer name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" id="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPhone">Phone Number</label>
                    <input type="text" id="phone" name="phone" class="form-control" id="exampleInputPassword1" placeholder="Enter phone number">
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
<!-- End of Add New Customer Modals -->

<!-- Edit Modal -->
<div class="modal fade" id="update-customer-modal">
	<div class="modal-dialog">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title">Update Customer</h4>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	      </button>
	    </div>
	    <div class="modal-body">
	      <!-- Form Start -->
	      <form id="update-customer-form" role="form" data-plugin="ajaxForm">
                <div class="card-body">
                  <div class="form-group">
                  	<input type="hidden" name="customer_id" id="customer_id">
                    <label for="exampleInputName">Customer Name</label>
                    <input type="text" id="update_name" name="name" class="form-control" id="exampleInputEmail1" placeholder="Enter customer name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" id="update_email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPhone">Phone Number</label>
                    <input type="text" id="update_phone" name="phone" class="form-control" id="exampleInputPassword1" placeholder="Enter phone number">
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
		$('#add-customer-form').on('submit', function(e){
		e.preventDefault();
		let name = $('#name').val();
		let email = $('#email').val();
		let phone = $('#phone').val();

			$.ajax({
				url: "{{route('customers.submit')}}",
				type: "POST",
				data: {
					"_token": "{{ csrf_token() }}",
					name: name,
					email: email,
					phone: phone,
				},
				success:function(response){
					// alertify.set('notifier','position', 'top-right');
	    //         	alertify.success('Customer Added!');
	    location.reload();
	            	$('#add-new-customer-modal').modal('hide');
				},
				error: function(ts) { alert(ts.responseText) }
			});

		});
	});
</script>

<script>

$(document).ready(function(){
		$('#update-customer-form').on('submit', function(e){
		e.preventDefault();
		let customer_id = $('#customer_id').val();
		let name = $('#update_name').val();
		let email = $('#update_email').val();
		let phone = $('#update_phone').val();

			$.ajax({
				url: "{{route('customers.update')}}",
				type: "POST",
				data: {
					"_token": "{{ csrf_token() }}",
					customer_id: customer_id,
					name: name,
					email: email,
					phone: phone,
				},
				success:function(response){
					// alertify.set('notifier','position', 'top-right');
	    //         	alertify.success('Customer Added!');
	    location.reload();
	            	$('#update-customer-modal').modal('hide');
				},
				error: function(ts) { alert(ts.responseText) }
			});

		});
	});

</script>

<script type="text/javascript">
		function set_value(id, name, email, phone)
		{
			$('#customer_id').val(id);
			$('#update_name').val(name);
			$('#update_email').val(email);
			$('#update_phone').val(phone);
		}
</script>

<script type="text/javascript">
	$(document).ready( function () {
	    $('#customer_table').DataTable();
	} );
</script>