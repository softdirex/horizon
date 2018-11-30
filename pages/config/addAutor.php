<?php
if (!isset($rootDir)) $rootDir = $_SERVER['DOCUMENT_ROOT']."/horizon";
require_once($rootDir . "/private/dao/AutorDao.php");
$dominio = $_SERVER['HTTP_HOST']; 

    $name="";
	if(isset($_POST['name'])){
		$name=$_POST['name'];
	}
	
	$validate = $name;

	$validate = str_replace(
        array("\\", "*", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "<code>", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ":",
             ".", " "),
        ' ',
        $validate
	);
	
	$estado=1;
	try{
		if($name != $validate){
			?>
				<script>
					alert('Ocurrió un error al registrar los datos: El nombre ingresado contiene caracteres inválidos.');
					window.location.href='javascript:history.go(-1);';
				</script>
			<?php
			return;
		}
		if(AutorDao::sqlExiste($name) > 0){
			?>
				<script>
					alert('Ocurrió un error al registrar los datos: El registro \"<?php echo $name;?>\" ya existe.');
					window.location.href='javascript:history.go(-1);';
				</script>
			<?php
		}else{
                $tp = new Autor(AutorDao::sqladdId(), $name,$estado);
                echo $tp->imprimir();
				AutorDao::sqlInsert($tp);
				?>
					<script>
						alert('Registro almacenado exitosamente.');
						window.location.href='autores';
					</script>
				<?php
				
		}
			
	}catch(Exception $e){
		?>
			<script>
				alert('Ocurrió un error al registrar los datos: \"<?php echo $e->getMessage(); ?>\". Póngase en contacto con su proveedor de software.');
				window.location.href='javascript:history.go(-1);';
			</script>
		<?php
	}

?>