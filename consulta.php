<?php
//////////////// CONEXION A LA BD ///////////////////////
$host = 'localhost';
$basededatos = 'cie10';
$usuario = 'admin';
$contrasena = '3201442';

$conexion = mysqli_connect($host,$usuario,$contrasena,$basededatos);
mysqli_query($conexion,"SET CHARACTER SET 'utf8'");
mysqli_query($conexion,"SET SESSION collation_connection ='utf8_unicode_ci'");

//////////////// VALORES INICIALES ///////////////////////
$tabla="";
$query="SELECT * FROM diagnosticos ORDER BY id_cie10 DESC LIMIT 5";
///////// LO QUE OCURRE AL TECLEAR SOBRE EL INPUT DE BUSQUEDA ////////////
if(isset($_POST['diagnosticos']))
{
	$q=$conexion->real_escape_string($_POST['diagnosticos']);
	$query="SELECT * FROM diagnosticos WHERE 
		ccie10 LIKE '%".$q."%'OR
		diagnostico LIKE '%".$q."%'
		 LIMIT 30" ;
}
$buscarDiagnosticos=$conexion->query($query);
if ($buscarDiagnosticos->num_rows > 0)
{
	$tabla.= 
	'<table class="table">
		<tr class="bg-primary">
			<td>Cod. CIE-10</td>
			<td>Descripción</td>
			<td></td>
		</tr>';
	while($filaDiagnosticos= $buscarDiagnosticos->fetch_assoc())
	{
		$tabla.=
		'<tr>
			<td><input id="ccie10" type="text" size="7" value="'.$filaDiagnosticos['ccie10'].'"></td>
			<td><input id="diagnostico" type="text" size="120" value="'.$filaDiagnosticos['diagnostico'].'"></td>
		</tr>
		';
	}
	// Use  <td>'.$filaDiagnosticos['diagnostico'].'</td> para traer campo sin input
	$tabla.='</table>';
} else
	{
		$tabla="No se encontraron coincidencias con sus criterios de búsqueda.";
	}
echo $tabla;
echo '	<script>
		function copy_Cie10() {
		document.getElementById("ccie102").value = document.getElementById("ccie10").value;
		document.getElementById("diagnostico2").value = document.getElementById("diagnostico").value;
		document.getElementById("cie10completo").value = document.getElementById("ccie10").value +" "+document.getElementById("diagnostico").value;
			};
		</script>';	
echo '
<table class="table">
<div class="form-group">	
		<tr class="bg-primary">
			<td>Código + Descripción (Clasificación internacional de enfermedades)</td>
		</tr>
		<tr>
		<td><input class="form-group text-primary" size="132"  id="cie10completo"></td>
		</tr>
		<tr>	
			<td><input class="text-primary" type="hidden" size="6" id="ccie102"></td>
			<td><input class="text-primary" type="hidden" size="120" id="diagnostico2"></td>
		</tr>
</div>		
</table>
<p>
<button id="botonObtener" type="button" class="btn btn-primary btn-md" onclick="copy_Cie10()">Obtener CIE10 </button>
<button id="botonCopiar" type="button" class="btn btn-success btn-md" onclick="copiarCie10Completo()">Copiar CIE10 al Portapapeles</button>
</p>
';
echo '	<script>
			function copiarCie10Completo() {
				var copyText = document.getElementById("cie10completo");
				copyText.select();
				copyText.setSelectionRange(0, 99999)
				document.execCommand("copy");
				alert("Ha copiado:" + copyText.value);
				}	
		</script>';	
mysqli_close($conexion);
?>