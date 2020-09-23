<?php
	include('header.php');
	$sql_get_products = "SELECT *
						 FROM products ORDER BY rowid;";
	$query_get_products = pg_query($sql_get_products);
	$rows_get_products = pg_num_rows($query_get_products); 
	$createError = array();
	$createSuccess = array();

    $sql_get_max_id = "SELECT MAX(rowid)
						 FROM products;";
	$query_get_max_id = pg_query($sql_get_max_id);
	$max = pg_fetch_result($query_get_max_id, 0, 0);


    // Add product into table
    if(isset($_POST['add_data']))
    {
        // variables for input data
        $sku = $_POST['sku'];
        $barcode_1 = $_POST['barcode_1'];
        $description = $_POST['description'];
        $put_method = $_POST['put_method'];
        $inv_xdock = $_POST['inv_xdock'];
        $storage_type = $_POST['storage_type'];

        // insert products into table
        $sql_insert_products = "INSERT INTO products(sku,
                             barcode_1,
                             description,
                             put_method,
                             inv_xdock,
                             storage_type)
        VALUES ('$sku',
                '$barcode_1',
                '$description',
                '$put_method',
                '$inv_xdock',
                '$storage_type');";

        $query_insert_products = pg_query($sql_insert_products);

    }

    // Delete product from table
    if (isset($_POST['delete_data'])) 
    {
        $sku = $_POST['del-id'];

        $sql_delete_product = "DELETE FROM products 
                                WHERE sku='del-id';";
        
        $query_delete_product = pg_query($sql_delete_product);
    }

?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src='js/multifilter.js'></script>   
<script type='text/javascript'>
      $(document).ready(function() {
          $('.filter').multifilter({
            'target': $('#dbTableData')
          });
        });
</script>

<html>
	<br>
    <body>  
        <div class="container" style="width:700px;">  
            <div class="table-responsive">   
                <div id="datatable">  
                	<input type="button" name="create" id="create" value="Add Product" class="btn btn-info btn-m add_data" data-toggle="modal" data-target="#modal_view_edit">
                	<br><br>
                    <table class="table table-bordered" id="dbTableData">  
                        <thead>  
                        	<th colspan="1" align="left">
                        		SKU
                        		<br>
                        		<input autocomplete='off' class='filter' name='Search SKU' placeholder='Search SKU' data-col='SKU'>
                        	</th>
                            <th colspan="3" align="left">
                            	Description
                            	<br>
                        		<input autocomplete='off' class='filter' name='Search Description' placeholder='Search Description' data-col='Description'>
                            </th>  
                        </thead>  
                        <?php  
                            for($i = 0; $i < $rows_get_products; $i++)  
    	                    {  
    	                    	$rowid = pg_result($query_get_products, $i, 'rowid');
    	                    	$sku = pg_result($query_get_products, $i, 'sku');
    	                    	$barcode_1 = pg_result($query_get_products, $i, 'barcode_1');
    	                    	$put_method = pg_result($query_get_products, $i, 'put_method');
    	                    	$inv_xdock = pg_result($query_get_products, $i, 'inv_xdock');
    	                    	$storage_type = pg_result($query_get_products, $i, 'storage_type');
    	                    	$description = pg_result($query_get_products, $i, 'description');
                        ?>  
        	                    <tr>  
        	                    	<td><?php echo $sku; ?></td>
            	                    <td><?php echo $description; ?></td>
                                    <td><input type="button" name="edit" value="Edit" data-id="<?php echo $rowid; ?>"  class="btn btn-info btn-xs edit_data"></td>  
                                    <td><input id="delete-btn" type="button" name="delete" value='Delete' data-delete_id="<?php echo $sku;?>"  class="btn btn-info btn-xs delete_data" data-toggle="modal" data-target="#modal_delete"></td>
                               </tr>  
                        <?php  
                            }  
                        ?>  
                    </table>  
                </div>  
            </div>  
        </div>  
    </body>  
</html>  

<div id="modal_view_edit" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">
           <form name="add_product" method = "POST">  
                <div class="modal-header">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title" id='modal_title'></h4>  
                </div> 
                <div class="modal-body"> 
                    <table>
                        <tr>
                            <th width="25%">SKU :</th>
                            <td width="75%"><input type="number" name="sku" id="sku" class="form-control" value="" required="required"  ></td>
                        </tr><tr>
                            <th>Barcode :</th>
                            <td><input type="number" name="barcode_1" id="barcode_1" class="form-control" size="100" value="" required="required"></td>
                        </tr><tr>
                            <th>Description :</th>
                            <td><input type="text" name="description" id="description" class="form-control" value="" ></td>
                        </tr><tr>   
                            <th>Put Method :</th>
                            <td>
                                <select name="put_method" id="put_method">
                                    <option value="CASE">CASE</option>
                                    <option value="PIECE">PIECE</option>
                                </select>
                            </td>
                        </tr><tr>   
                            <th>Inv xDock :</th>
                            <td>
                                <select name="inv_xdock" id="inv_xdock">
                                    <option value="INVENTORY">INVENTORY</option>
                                    <option value="FLOWTHROUGH">FLOWTHROUGH</option>
                                </select>
                            </td>
                        </tr><tr>   
                            <th>Storage Type :</th>
                            <td>
                                <select name="storage_type" id="storage_type">
                                    <option value="AMBIENT">AMBIENT</option>
                                    <option value="AIRCON">AIRCON</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <br><br>
                    <input type="submit" name="add_data" id="submit_btn" value="Submit" class="btn btn-success">   
                </div>  
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </div> 
            </form>
           </div>  
      </div>  
 </div>  

 <div id="modal_delete" class="modal fade">  
      <div class="modal-dialog">  
           <div class="modal-content">
           <form name="delete_product" method = "POST">  
                <div class="modal-header">  
                     <button type="button" class="close" data-dismiss="modal">&times;</button>  
                     <h4 class="modal-title">Enter Admin Password</h4>  
                </div>  
                <div class="modal-body">
                    <input type="hidden" name="del-id" id="del-id" value="" />
                    Password : <input type="password" name="password" id="password"><br><i id="comment"></i><br>
                    <input type="submit" name="delete_data" id="delete_data" value="Delete" class="delete">
                </div>  
                <div class="modal-footer">  
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                </div>
                </form>  
           </div>  
      </div>  
 </div>  


<script>

    // Pass delete ID to modal
    $(document).on("click", ".delete_data", function () {
        var ids = $(this).attr('data-delete_id');
        $("#del-id").val( ids );
        $('#modal_delete').modal('show');
    });

</script>

<!-- <script>
    $( document ).ready(function() {
        $('#delete_confirm').click(function(){
            var password = $('#password').val();
            if(password != '')
            {
                $.ajax({
                    method: "POST",
                    data:{password:password},
                    success:function(data){

                    }
                })
            }
            // console.log( "Hewwo uwu" );
        })
});
</script> -->