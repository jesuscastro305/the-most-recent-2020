$(document).ready(function(){

	$('#genero').change(function()
	{
		var el = $(this).val();
		$.post( 'modelo_dinamico.php', { genero: el} ).done( function( respuesta )
			{
			$( '#modelo' ).html( respuesta );
		});
	});

	$('#modelo').change(function()
	{
	$('#add').attr("disabled", false);

		$("#modelo option:selected").each(function(){
			id_modelo = $(this).val();
			$.post("model_dinamico.php",{id_modelo: id_modelo}
				,function(data){$ ("#modo").html(data);

			});
		});

	
	});
	

	function reestablecer(){
		var nums= document.getElementsByName("cantidad[]");
        for(var i=0; i<nums.length; i++)
        {
            nums[i].value ='0';
        }

	}

	$('#add').click(function(){	
		alertify.confirm('labels changed!').set('labels', {ok:'SI!', cancel:'No!'}); 
		alertify.confirm('Confirmacion',"Favor de revisar los componentes antes de realizar la orden", function(){ 
			$.post("recibir.php",$("#formula").serialize()
	,function(data){ alertify.notify(data, 'custom', 2, function(){});
	}); reestablecer(); }
    , function(){  alertify.error('Orden Cancelada')});
	});	

	



});
