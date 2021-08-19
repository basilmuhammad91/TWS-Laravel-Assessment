@extends('layouts.master')
@section('body')
<style type="text/css">
	.select2-container
	{
		width: 100% !important;
	}
</style>
<section class="content">
	<div class="container-fluid">
		<div class="row mb-3 text-right">
			<div class="col-md-12">
				<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-new-sale-modal">Add New Sale</a>
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
							<th>Reference Number</th>
							<th>Customer</th>
							<th>Grand Total</th>
							<th>Product Details</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($sales as $sale)
							<tr>
								<td>{{$sale->sale_id}}</td>
								<td>{{$sale->reference}}</td>
								<td>{{@$sale->customer->name}}</td>
								<td>{{$sale->grand_total}}</td>
								<td><a href="" data-toggle="modal" data-target="#show-product-modal{{$sale->sale_id}}">Product Details</a></td>
<!-- Show Product Modals -->
<div class="modal fade" id="show-product-modal{{$sale->sale_id}}">
	<div class="modal-dialog">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title">Product Details</h4>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	      </button>
	    </div>
	    <div class="modal-body">
	    	<div class="row">
	    		<div class="col-md-2">
	    			<h6>Id</h6>
	    		</div>
	    		<div class="col-md-2">
	    			<h6>Qty</h6>
	    		</div>
	    		<div class="col-md-2">
	    			<h6>Product</h6>
	    		</div>
	    		<div class="col-md-2">
	    			<h6>Retail Price</h6>
	    		</div>
	    		<div class="col-md-2">
	    			<h6>Description</h6>
	    		</div>
	    		<div class="col-md-2">
	    			<h6>Subtotal</h6>
	    		</div>
	    	</div> 
	    	<hr>
    		@foreach($sale->product_sale as $obj)
               <div class="row">
		    		<div class="col-md-2">
		    			<h6>{{$obj->product_sale_id}}</h6>
		    		</div>
		    		<div class="col-md-2">
		    			<h6>{{$obj->quantity}}</h6>
		    		</div>
		    		<div class="col-md-2">
		    			<h6>{{$obj->product->name}}</h6>
		    		</div>
		    		<div class="col-md-2">
		    			<h6>{{$obj->product->retail_price}}</h6>
		    		</div>
		    		<div class="col-md-2">
		    			<h6>{{$obj->product->description}}</h6>
		    		</div>
		    		<div class="col-md-2">
		    			<h6>${{$obj->total}}</h6>
		    		</div>
		    	</div> 
		    	<hr>
            @endforeach
	    </div>
	  </div>
	  <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- End of Show Product Details Modals -->

								<td>
									<a href="{{route('sales.report', $sale->sale_id)}}">Download</a> 
									<a href=""  data-toggle="modal" data-target="#edit-product-modal{{$sale->sale_id}}">Edit</a>

<!-- Edit Sale Modals -->
<div class="modal fade" id="edit-product-modal{{$sale->sale_id}}">
	<div class="modal-dialog">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title">Edit Sales</h4>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	      </button>
	    </div>
	    <div class="modal-body">
	      <!-- Form Start -->
	      <form id="edit-sale-form" role="form" data-plugin="ajaxForm" enctype="multipart/form-data">
	      	@csrf()
                <div class="card-body">
                  <div class="form-group text-left">
                  	<input type="hidden" name="sale_id" value="{{$sale->sale_id}}">
                    <label for="exampleInputName">Reference Number</label>
                    <input type="text" name="reference" class="form-control" placeholder="Enter reference number" value="{{$sale->reference}}">
                  </div>
                  <div class="form-group text-left">
                    <label for="exampleInputEmail1">Customer</label>
                    <select class="customer_dropdown form-control col-md-12" name="customer_id">
					  @foreach($customers as $customer)
					  	<option @if($customer->customer_id == $sale->customer_id) { "selected" } @endif class="form-control" value="{{$customer->customer_id}}">{{$customer->name}}</option>
					  @endforeach
					</select>
                  </div>
                  <div class="form-group text-left">
                  	<label>Product Details</label>
                  </div>
                  @foreach($sale->product_sale as $obj)

                  <div class="form-row form-group text-left">
                  	<div class="col-md-6">
                  		<label>Product</label>
                  		<select class="customer_dropdown form-control col-md-12" id="product_id" name="product_id[]" onchange="get_quantity_for_update(this,{{$obj->product_sale_id}})">
						  @foreach($products as $product)
						  	<option class="form-control" value="{{$product->product_id}}">{{$product->name}}</option>

						  @endforeach
						</select>
						<input type="hidden" name="product_sale_id[]" value="{{$obj->product_sale_id}}">
						<input type="hidden" name="" id="update_unitPrice_{{$obj->product_sale_id}}">
                  	</div>
                  	<div class="col-md-3">
                  		<label>Quantity</label>
                  		<input type="number" id="update_quantity_{{$obj->product_sale_id}}" name="quantity[]" class="form-control" onkeyup="set_total_for_update(this,{{$obj->product_sale_id}})" placeholder="Qty" value="{{$obj->quantity}}">
                  	</div>
                  	<div class="col-md-3">
                  		<label>Total</label>
                  		<input type="number" id="update_total_{{$obj->product_sale_id}}" name="total[]" class="form-control" value="{{$obj->total}}">
                  	</div>
                  </div>

                  @endforeach
                  <div class="form-group text-left">
                    <label for="exampleInputPhone">Grand Total</label>
                    <input type="number" id="update_grand_total" name="grand_total" class="form-control" value="{{$sale->grand_total}}">
                  </div>
                  
                </div>
                <!-- /.card-body -->
				<hr>
                <div class="">
                	<button type="button" class="btn btn-default float-left" data-dismiss="modal">Close</button>

                  	<input type="submit" id="my-btn" class="btn btn-primary float-right" value="Update">
                </div>
              </form>
	      <!-- End of Form -->
	    </div>
	  </div>
	  <!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- End of Add New Sale Modals -->

									<a href="{{route('sales.delete', $sale->sale_id)}}">Delete</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
	</div>
</section>


<!-- Add New Sale Modals -->
<div class="modal fade" id="add-new-sale-modal">
	<div class="modal-dialog">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h4 class="modal-title">Add New Sales</h4>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	      </button>
	    </div>
	    <div class="modal-body">
	      <!-- Form Start -->
	      <form id="add-sale-form" role="form" data-plugin="ajaxForm" enctype="multipart/form-data">
	      	@csrf()
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputName">Reference Number</label>
                    <input type="text" id="reference" name="reference" class="form-control" placeholder="Enter reference number">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Customer</label>
                    <select class="customer_dropdown form-control col-md-12" id="customer_id" name="customer_id">
					  @foreach($customers as $customer)
					  	<option class="form-control" value="{{$customer->customer_id}}">{{$customer->name}}</option>
					  @endforeach
					</select>
                  </div>
                  <div class="form-group">
                  	<label>Product Details</label>
                  	<button type="button" class="btn btn-success float-right" id="add_row"><i class="fas fa-plus"></i></button>
                  </div>
                  <div class="form-row form-group">
                  	<div class="col-md-6">
                  		<label>Product</label>
                  		<select class="customer_dropdown form-control col-md-12" id="product_id" name="product_id[]" onchange="get_quantity(this,1)">
						  @foreach($products as $product)
						  	<option class="form-control" value="{{$product->product_id}}">{{$product->name}}</option>

						  @endforeach
						</select>
						<input type="hidden" name="" id="unitPrice_1">
                  	</div>
                  	<div class="col-md-3">
                  		<label>Quantity</label>
                  		<input type="number" id="quantity_1" name="quantity[]" class="form-control" onkeyup="set_total(this,1)" placeholder="Qty">
                  	</div>
                  	<div class="col-md-3">
                  		<label>Total</label>
                  		<input type="number" id="total_1" name="total[]" class="form-control" value="0">
                  	</div>
                  </div>
                  <div id="content"></div>
                  <div class="form-group">
                    <label for="exampleInputPhone">Grand Total</label>
                    <input type="number" id="grand_total" name="grand_total" value="0" class="form-control">
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
<!-- End of Add New Sale Modals -->



@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var count=2
		$('#add_row').click(function(){
			$('#content').append('<div class="form-row form-group"><div class="col-md-6"><label>Product</label><select onchange="get_quantity(this,'+count+')" class="customer_dropdown form-control col-md-12" id="product_id" name="product_id[]">@foreach($products as $product)<option class="form-control" value="{{$product->product_id}}">{{$product->name}}</option>@endforeach</select><input type="hidden" name="" id="unitPrice_'+count+'"></div><div class="col-md-3"><label>Quantity</label><input type="number" onkeyup="set_total(this,'+count+')" id="quantity_'+count+'" name="quantity[]" class="form-control" placeholder="Qty"></div><div class="col-md-3"><label>Total</label><input type="number" id="total_'+count+'" name="total[]" class="form-control" value="0" ></div></div>');
			count++;
		});
	});
</script>

<!-- AJAX SUBMISSION FOR ADDING SALES -->
<script type="text/javascript">
	$(document).ready(function(){
		$('#add-sale-form').on('submit', function(e){
		e.preventDefault();
			$.ajax({
				url: "{{route('sales.submit')}}",
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
	            	$('#add-new-sale-modal').modal('hide');
				},
				error: function(ts) { alert(ts.responseText) }
			});

		});
	});
</script>


<!-- FUNCTION TO RUN AJAX ON ONCHANGE -->
<script type="text/javascript">
	var grand_total = 0;
	function get_quantity(e,count)
	{
		var id = e.value;
			$.ajax({
				url: "{{route('sales.get_quantity')}}?id="+id,
				success: function(res){
					// alert(res.response.retail_price);
					document.getElementById('unitPrice_'+count).value=res.response.retail_price;
					var q=document.getElementById('quantity_'+count).value;
					grand_total+= document.getElementById('total_'+count).value=res.response.retail_price*q;
					document.getElementById('grand_total').value=grand_total;
				},
				error: function(ts) 
				{ 
					alert(ts.responseText)
				}
			});

	}
	function set_total(e,count)
	{
		var q = e.value;
		
					//alert(JSON.stringify(res));
					var p=document.getElementById('unitPrice_'+count).value
					grand_total+= document.getElementById('total_'+count).value=p*q;
				document.getElementById('grand_total').value=grand_total;
	}
</script>


<!-- AJAX UPDATION FOR SALES -->
<script type="text/javascript">
	$(document).ready(function(){
		$('#edit-sale-form').on('submit', function(e){
		e.preventDefault();
			$.ajax({
				url: "{{route('sales.update')}}",
				method: "POST",
				data: new FormData(this),
				dataType:'JSON',
			    contentType: false,
			    cache: false,
			    processData: false,
				success:function(response){
					// alertify.set('notifier','position', 'top-right');
	    //         	alertify.success('Customer Added!');
	   // alert(response);
	    location.reload();
	            	$('#add-new-sale-modal').modal('hide');
				},
				error: function(ts) { alert(ts.responseText) }
			});

		});
	});
</script>


<!-- FUNCTION TO RUN AJAX ON ONCHANGE UPDATE -->
<script type="text/javascript">
	function get_quantity_for_update(e,count)
	{
		var id = e.value;
			$.ajax({
				url: "{{route('sales.get_quantity')}}?id="+id,
				success: function(res){
					// alert(res.response.retail_price);
					document.getElementById('update_unitPrice_'+count).value=res.response.retail_price;
					var q=document.getElementById('update_quantity_'+count).value;
					document.getElementById('update_total_'+count).value=res.response.retail_price*q;

				},
				error: function(ts) 
				{ 
					alert(ts.responseText)
				}
			});
	}
	function set_total_for_update(e,count)
	{
		var q = e.value;
		
					//alert(JSON.stringify(res));
					var p=document.getElementById('update_unitPrice_'+count).value
					document.getElementById('update_total_'+count).value=p*q;

	}
</script>