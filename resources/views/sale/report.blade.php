<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TWA - Laravel Assessment</title>



	 <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="description" content="Invoicebus Invoice Template">
    <meta name="author" content="Invoicebus">

    <meta name="template-hash" content="baadb45704803c2d1a1ac3e569b757d5">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
 
</head>

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
           
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                	<img src="https://dl.hiapphere.com/data/thumb/202007/com.invoice.maker.generator_HiAppHere_com_icon.png" width="100" height="100">
                  <h4>
                    <i class="fas fa-globe"></i> AdminLTE, Inc.
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  <h1>Sale Details</h1>
                  <address>
	                    <strong>Sale Id: </strong>	<span>{{$sales->sale_id}}</span> <br>
	                    <strong>Reference Number: </strong> <span>{{ $sales->reference }}</span> <br>
	                    <strong>Customer Name: </strong> <span>{{ @$sales->customer->name }}</span> <br>
	                </address>
                </div>
                <!-- /.col -->
                
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>Qty</th>
                      <th>Product</th>
                      <th>Retail Price</th>
                      <th>Description</th>
                      <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sales->product_sale as $obj)
	                    <tr>
	                      <td>{{$obj->quantity}}</td>
	                      <td>{{$obj->product->name}}</td>
	                      <td>{{$obj->product->retail_price}}</td>
	                      <td>{{$obj->product->description}}</td>
	                      <td>${{$obj->total}}</td>
	                    </tr>
                    @endforeach
                   
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- /.col -->
                <div class="col-6 offset-md-6">

                  <div class="table-responsive">
                    <table class="table">
                      <tbody>
                      	<tr>
	                        <th style="width:50%">Grand Total:</th>
	                        <td>${{$sales->grand_total}}</td>
	                      </tr>
                    </tbody></table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>