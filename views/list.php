<div class="modal fade" id="del" tabindex="-1" role="dialog" aria-labelledby="notaModalLabel">
	<form action="index.php" method="POST">
	<input type="hidden" name="accion" value="del">
	<input type="hidden" name="id" id="id_del" value="">
	<div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
        <h5 class="modal-title">Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
	  </div>
	  <div class="modal-body">
		<p>Are you sure?</p>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn pull-left btn-default" data-target="#del" data-dismiss="modal">Cancel</button>
		<button type="submit" class="btn btn-danger">Delete</button>
	  </div>
	</div><!-- /.modal-content -->
	</form>
  </div>		
</div>
<!-- Modal -->
	
<!-- Modal -->
<form id="uploadform"  method="post" enctype="multipart/form-data">
<div class="modal fade" id="imagenModal" tabindex="-1" role="dialog" aria-labelledby="notaModalLabel" style="z-index:9999999999 !important">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">File Upload</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label class="control-label">Select a file</label>
		<input name="archivo" id="archivo" type="file" class="file">	
		<p id="resultado"></p>
      </div>	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="submit" type="submit" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>	
</form>
	
<div class="modal fade" id="notaModal" tabindex="-1" role="dialog" aria-labelledby="notaModalLabel">
  <div class="modal-dialog modal-lg" role="document">
  	<form action="index.php" method="POST" id="form">  
	<input type="hidden" name="accion" id="accion" value="">
	<input type="hidden" name="id" id="id_edit" value="">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> 
      </div>
      <div class="modal-body">
			<div class="box-body">									
						<div class="form-group">
							<label for="titulo">Title</label>													
							<input type="text" class="form-control" id="titulo" name="form[titulo]">							
						</div>
						<div class="form-group">
							<label for="texto">Text</label>																				
							<textarea id="texto" name="form[texto]"></textarea>
						</div>											
				<hr>
				<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#imagenModal">
				  UPLOAD FILE
				</button>    				
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Publish</button>
      </div>	  
    </div>
	</form>
  </div>
</div>		
        <div class="container">
        	<div class="row">
                <div class="col-12">
                  <table class="table table-striped table-responsive" id="table-main">
                  	<thead class="thead-dark">
						<tr>
							<th>#</th>
							<th style="width:100%">Title</th>
							<th>Options</th>
						</tr>
					</thead>
                    <tbody>					
						<?php 
						$array_coleccion = $obj->getCollection();
						foreach ($array_coleccion as $k => $v) { ?>						
							<tr>	
								<td>
									<?php if ($v['pos'] != $max) { ?><a href="index.php?accion=move&pos=up&id=<?php echo $k ?>"><i class="fa fa-fw fa-caret-up"></i></a><?php } ?>
									<?php if ($v['pos'] > 1) { ?><a href="index.php?accion=move&pos=down&id=<?php echo $k ?>"><i class="fa fa-fw fa-caret-down"></i></a><?php } ?>
								</td>
								<td>
									<button type="button" class="btn btn-link" data-toggle="modal" data-target="#notaModal" onclick="$('#accion').val('update');$('#id_edit').val('<?php echo $k ?>');volcar('<?php echo $k ?>')"><?php echo $v['titulo']; ?></button>
								</td>
								<td>
		                        <div class="btn-group">
		                          <button class="btn btn-primary" data-toggle="modal" data-target="#notaModal" onclick="$('#accion').val('update');$('#id_edit').val('<?php echo $k ?>');volcar('<?php echo $k ?>')" title="Edit"><i class="fa fa-edit"></i></button>
		                          <button class="btn btn-danger" data-toggle="modal" data-target="#del" onclick="$('#id_del').val('<?php echo $k ?>')" title="Delete"> <i class="fa fa-close"></i></button>
		                        </div>
		                      </td>                      
						  </tr>
						  <?php } ?>
                  </tbody>
				  </table>
                </div><!-- /.box-body -->
              </div>                    	
			<button class="btn btn-block btn-success" data-toggle="modal" data-target="#notaModal" onclick="$('#accion').val('add');reset()"><i class="fa fa-share-square"> New</i></button>
        </div>	

		
<script>
var array_coleccion = <?php echo json_encode($array_coleccion) ?>;    
function volcar(id) {	
	obj = array_coleccion[id];	
	for(var key in obj){            
            var attrValue = obj[key];			
			if ($('#'+key).length) { 
				$('#'+key).val(attrValue);			 
			}
			//console.log(key + ':' + attrValue);
        }
		tinymce.get('texto').setContent(obj.texto);
}
function reset() {
	$('#form').trigger("reset");
}
$( '#uploadform' )
  .submit( function( e ) {
    $.ajax( {
      url: 'index.php?accion=upload',
      type: 'POST',
      data: new FormData( this ),
      processData: false,
      contentType: false
    } ).done(function(html) {
		$('#resultado').html('<hr>'+html);
		$( "#submit" ).prop( "disabled", false );
  })
  .fail(function(html) {
    $('#resultado').html('ERROR. ' + html);
	$( "#submit" ).prop( "disabled", false );
  });
	$( "#submit" ).prop( "disabled", true );
    e.preventDefault();
  } );
  
 $('#notaModal').on('hidden.bs.modal', function () {
    $( "#submit" ).prop( "disabled", false );
	$("#resultado").html('');
})
// prevent Bootstrap from hijacking TinyMCE modal focus    
$(document).on('focusin', function(e) {
        if ($(e.target).closest(".mce-window").length) {
            e.stopImmediatePropagation();
        }
    });
</script>