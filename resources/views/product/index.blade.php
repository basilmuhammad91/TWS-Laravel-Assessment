@extends('layouts.master')
@section('body')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">

<section class="content">
	<div class="container-fluid">
		<div class="row mb-3 text-right">
			<div class="col-md-12">
				<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-new-product-modal">Add New Product</a>
			</div>
		</div> 
		@if(session('success'))		
			<div class="alert alert-success" role="alert">
				<div class="alert-text">{{session('success')}}</div>
			</div>
		@endif
		<div class="row">
			<div class="col-md-12">
				<table class="table table-stripped text-center" id="product_table">
					<thead>
						<tr>
							<th>Id</th>
							<th>Name</th>
							<th>Description</th>
							<th>Retail Price</th>
							<th>Wholesale Price</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($products as $product)
							<tr>
								<td>{{$product->product_id}}</td>
								<td>{{$product->name}}</td>
								<td>{{$product->description}}</td>
								<td>{{$product->retail_price}}</td>
								<td>{{$product->wholesale_price}}</td>
								<td>
									<a href="" onclick="set_value({{$product->product_id}}, '{{$product->name}}', '{{$product->description}}', {{$product->retail_price}}, {{$product->wholesale_price}})" class="btn btn-secondary" data-toggle="modal" data-target="#update-product-modal"><i class="fas fa-pencil-alt"></i></a>
									<a href="{{route('products.delete', $product->product_id)}}" class="btn btn-danger ml-2"><i class="fas fa-trash"></i></a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
	</div>
</section>


<!-- Add New Product Modals -->
<div class="modal fade" id="add-new-product-modal">
	<div class="modal-dialog">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title">Add New Product</h4>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	      </button>
	    </div>
	    <div class="modal-body">
	      <!-- Form Start -->
	      <form id="add-product-form" role="form" data-plugin="ajaxForm">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputName">Product Name</label>
                    <input type="text" id="name" name="name" class="form-control" id="exampleInputEmail1" placeholder="Enter product name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Description</label>
                    <textarea id="description" name="description" class="form-control" placeholder="Enter product description"></textarea>
                  </div>
                  <div class="form-group">
                    <label >Retail Price</label>
                    <input type="number" id="retail_price" name="retail_price" class="form-control" placeholder="Enter retail price">
                  </div>
                  <div class="form-group">
                    <label >Wholesale Price</label>
                    <input type="number" id="wholesale_price" name="wholesale_price" class="form-control" placeholder="Enter wholesale price">
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
<!-- End of Add New Product Modals -->

<!-- Edit Modal -->
<div class="modal fade" id="update-product-modal">
	<div class="modal-dialog">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title">Update Product</h4>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	      </button>
	    </div>
	    <div class="modal-body">
	      <!-- Form Start -->
	      <form id="update-product-form" role="form" data-plugin="ajaxForm">
                <div class="card-body">
                  <div class="form-group">
                  	<input type="hidden" name="product_id" id="product_id">
                    <label for="exampleInputName">Product Name</label>
                    <input type="text" id="update_name" name="name" class="form-control" placeholder="Enter product name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Description</label>
                    <textarea id="update_description" name="description" class="form-control" placeholder="Enter product description"></textarea>
                  </div>
                  <div class="form-group">
                    <label >Retail Price</label>
                    <input type="number" id="update_retail_price" name="retail_price" class="form-control" placeholder="Enter retail price">
                  </div>
                  <div class="form-group">
                    <label >Wholesale Price</label>
                    <input type="number" id="update_wholesale_price" name="wholesale_price" class="form-control" placeholder="Enter wholesale price">
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
		$('#add-product-form').on('submit', function(e){
		e.preventDefault();
		let name = $('#name').val();
		let description = $('#description').val();
		let retail_price = $('#retail_price').val();
		let wholesale_price = $('#wholesale_price').val();

			$.ajax({
				url: "{{route('products.submit')}}",
				type: "POST",
				data: {
					"_token": "{{ csrf_token() }}",
					name: name,
					description: description,
					retail_price: retail_price,
					wholesale_price: wholesale_price,
				},
				success:function(response){
					// alertify.set('notifier','position', 'top-right');
	    //         	alertify.success('Customer Added!');
	    location.reload();
	            	$('#add-new-product-modal').modal('hide');
				},
				error: function(ts) { alert(ts.responseText) }
			});

		});
	});
</script>

<script>

$(document).ready(function(){
		$('#update-product-form').on('submit', function(e){
		e.preventDefault();
		let product_id = $('#product_id').val();
		let name = $('#update_name').val();
		let description = $('#update_description').val();
		let retail_price = $('#update_retail_price').val();
		let wholesale_price = $('#update_wholesale_price').val();

			$.ajax({
				url: "{{route('products.update')}}",
				type: "POST",
				data: {
					"_token": "{{ csrf_token() }}",
					product_id: product_id,
					name: name,
					description: description,
					retail_price: retail_price,
					wholesale_price: wholesale_price,
				},
				success:function(response){
					// alertify.set('notifier','position', 'top-right');
	    //         	alertify.success('Customer Added!');
	    location.reload();
	            	$('#update-product-modal').modal('hide');
				},
				error: function(ts) { alert(ts.responseText) }
			});

		});
	});

</script>

<script type="text/javascript">
		function set_value(id, name, description, retail_price, wholesale_price)
		{
			$('#product_id').val(id);
			$('#update_name').val(name);
			$('#update_description').val(description);
			$('#update_retail_price').val(retail_price);
			$('#update_wholesale_price').val(wholesale_price);
		}
</script>

<script type="text/javascript">
	$(document).ready( function () {
	    $('#product_table').DataTable();
	} );
</script>