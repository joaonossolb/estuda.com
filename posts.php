<?php
@session_start();
include("conexao.php");
include("funcoes.php");



//########################################################### INICIO ALUNOS ###########################################################




//########################################################### INICIO CADASTRO ALUNOS ###########################################################

if (isset($_POST['id_aluno']) and isset($_POST['nome_aluno']) and isset($_POST['telefone_aluno']) and isset($_POST['email_aluno']) and isset($_POST['nascimento_aluno']) and isset($_POST['genero_aluno']) and isset($_POST['btn_cadastrar_aluno'])) {
	//recebe inputs POST cadastra aluno
	$id_aluno = $_POST['id_aluno'];
	$nome_aluno = $_POST['nome_aluno'];
	$telefone_aluno = $_POST['telefone_aluno'];
	$email_aluno = $_POST['email_aluno'];
	$nascimento_aluno = $_POST['nascimento_aluno'];
	$genero_aluno = $_POST['genero_aluno'];



	//valida campos cadastra aluno
	$id_aluno_valida = valida_inputs(0, $id_aluno);
	$nome_aluno_valida = valida_inputs(1, $nome_aluno);
	$telefone_aluno_valida = valida_inputs(0, $telefone_aluno);
	$email_aluno_valida = valida_inputs(2, $email_aluno);
	$nascimento_aluno_valida = valida_inputs(3, $nascimento_aluno);
	$genero_aluno_valida = valida_inputs(0, $genero_aluno);


	$nome_aluno_trim = trim($nome_aluno);
	$email_aluno_trim = trim($email_aluno);
	if (empty($nome_aluno_trim) and isset($nome_aluno) or empty($email_aluno_trim) and isset($email_aluno)) {
		$nome_aluno_valida = 2;
		$email_aluno_valida = 2;
		echo "<script>alert('Nome e E-mail é obrigatorio!');</script>";
		echo "<script>window.history.back();</script>";
	} //fim if(empty(trim($nome_aluno)) or empty(trim($email_aluno))){

	//se $id_aluno não for preenchido, $id_aluno vai ser o valor do utlimo id+1
	if (empty($id_aluno)) {
		$id_aluno_valida = 1;
		$sql_utlimo_id = "SELECT MAX(id) FROM alunos;";
		$query_id_repetido = mysqli_query($conn, $sql_utlimo_id);
		$ultimo_id_array = mysqli_fetch_array($query_id_repetido);
		$ultimo_id = $ultimo_id_array["MAX(id)"];
		$ultimo_id_inserir = $ultimo_id + 1;
		$id_aluno = $ultimo_id_inserir;
	} //fim if (empty($id_aluno)) {

	// se algum dos campos abaixo for vazio, vai ser definida a validação como 1, porquê o regex não passa valores em branco
	if (empty($telefone_aluno)) {
		$telefone_aluno_valida = 1;
	} //fim if (empty($telefone_aluno)) {
	if (empty($nascimento_aluno)) {
		$nascimento_aluno_valida = 1;
	} //fim if (empty($nascimento_aluno)) {
	if (empty($genero_aluno)) {
		$genero_aluno_valida = 1;
	} //fim if (empty($genero_aluno)) {

	//se todos os campos de validação for igual a 1, quer dizer que passou no regex e vai prosseguir com o cadastro
	if (
		$id_aluno_valida == 1 and
		$nome_aluno_valida == 1 and
		$telefone_aluno_valida == 1 and
		$email_aluno_valida == 1 and
		$nascimento_aluno_valida == 1 and
		$genero_aluno_valida == 1
	) {
		//VERIFICA ID REPETIDO
		$sql_id_repetido = "SELECT id FROM alunos WHERE id = '" . $id_aluno . "';";
		$query_id_repetido = mysqli_query($conn, $sql_id_repetido);
		$quantidade_id_repetido = mysqli_num_rows($query_id_repetido);

		//se o id nao for repetido, cadastra
		if ($quantidade_id_repetido == 0) {
			//cadastra
			$sql_cadastra = "INSERT INTO alunos (visivel, id, nome, telefone, email, data_nascimento, genero) VALUES ('1','" . $id_aluno . "','" . $nome_aluno . "','" . $telefone_aluno . "','" . $email_aluno . "','" . $nascimento_aluno . "','" . $genero_aluno . "')";
			if (mysqli_query($conn, $sql_cadastra)) {




				//cadastra aluno nas turmas
				$vetor = explode(",", $_SESSION['qtd_registros_turmas']);
				$n = 0;
				//laço infinito
				while (1 == 1) {
					if (isset($vetor[$n])) {
						$id_turma = $vetor[$n];
						if (isset($_POST['checkbox_turmas' . $id_turma])) {
							if ($id_turma != "") {


								//ver id aluno
								$sql_ver_id_aluno = "SELECT MAX(id), visivel FROM alunos WHERE visivel = '1'; ";
								$query_ver_id_aluno = mysqli_query($conn, $sql_ver_id_aluno);
								$ver_id_aluno = mysqli_fetch_array($query_ver_id_aluno);
								$id_aluno = $ver_id_aluno['MAX(id)'];
								//atualiza visivel para 0, na visualização só vai ser visivel os que forem 1
								$sql = "INSERT INTO alunos_de_turmas (pk_id, visivel, fk_id_aluno, fk_id_turma) VALUES (NULL,'1','" . $id_aluno . "','" . $id_turma . "' )";

								mysqli_query($conn, $sql);
							} //fim if($id_turma != ""){
						} //fim if (isset($_POST['checkbox_turmas' . $id_turma])) {

					} //fim if (isset($vetor[$n])) {
					else {
						break;
					}
					$n = $n + 1;
				} //fim while










				echo "<script> alert('Aluno cadastrado com sucesso!');</script>";
				echo "<script>window.history.back();</script>";
			} //fim if (mysqli_query($conn, $sql_cadastra)) {

		}/*fim if(
	$id_aluno_valida == 1 and
	$nome_aluno_valida == 1 and
	$telefone_aluno_valida == 1 and
	$email_aluno_valida == 1 and
	$nascimento_aluno_valida == 1 and
	$genero_aluno_valida == 1
	){*/ else {
			echo "<script> alert('Esse id já está em uso!');</script>";
			echo "<script>javascript:history.back()<script>";
		} //fim else {

	} //fim if($quantidade_id_repetido == 0){

} //fim if (isset($_POST['id_aluno']) and isset($_POST['nome_aluno']) and isset($_POST['telefone_aluno']) and isset($_POST['email_aluno']) and isset($_POST['nascimento_aluno']) and isset($_POST['genero_aluno'])){

//########################################################### FIM CADASTRO ALUNOS ###########################################################





//########################################################### INICIO EDITA ALUNOS ###########################################################

if (isset($_POST['btn_editar_aluno'])) {
	//aqui vai percorrer vetor para ver todos os IDs de registros etc
	$vetor = explode(",", $_SESSION['qtd_registros']);
	$n = 0;
	//laço infinito
	while (1 == 1) {
		//se existir posição no vetor, acrescenta o id ao nome do POST, e faz as devidas validações
		if (isset($vetor[$n])) {
			$nome_input = $vetor[$n];

			$id_aluno = @$_POST['id_aluno' . $nome_input];
			$nome_aluno = @$_POST['nome_aluno' . $nome_input];
			$telefone_aluno = @$_POST['telefone_aluno' . $nome_input];
			$email_aluno = @$_POST['email_aluno' . $nome_input];
			$nascimento_aluno = @$_POST['nascimento_aluno' . $nome_input];
			$genero_aluno = @$_POST['genero_aluno' . $nome_input];






			//valida campos
			$id_aluno_valida = valida_inputs(0, $id_aluno);
			$nome_aluno_valida = valida_inputs(1, $nome_aluno);
			$telefone_aluno_valida = valida_inputs(0, $telefone_aluno);
			$email_aluno_valida = valida_inputs(2, $email_aluno);
			$nascimento_aluno_valida = valida_inputs(3, $nascimento_aluno);
			$genero_aluno_valida = valida_inputs(0, $genero_aluno);

			$nome_aluno_trim = trim($nome_aluno);
			$email_aluno_trim = trim($email_aluno);


			if (empty($nome_aluno_trim) and isset($nome_aluno) or empty($email_aluno_trim) and isset($email_aluno)) {
				$nome_aluno_valida = 2;
				$email_aluno_valida = 2;
				echo "<script>alert('Nome e E-mail é obrigatorio! ');</script>";
				echo "<script>window.history.back();</script>";
			} //fim if(empty(trim($nome_aluno)) or empty(trim($email_aluno))){



			// se algum dos campos abaixo for vazio, vai ser definida a validação como 1, porquê o regex não passa valores em branco
			if (empty($telefone_aluno)) {
				$telefone_aluno_valida = 1;
			} //fim if (empty($telefone_aluno)) {
			if (empty($nascimento_aluno)) {
				$nascimento_aluno_valida = 1;
			} //fim if (empty($nascimento_aluno)) {
			if (empty($genero_aluno)) {
				$genero_aluno_valida = 1;
			} //fim if (empty($genero_aluno)) {

			//se todos os campos de validação for igual a 1, quer dizer que passou no regex e vai prosseguir com o cadastro
			if (
				$id_aluno_valida == 1 and
				$nome_aluno_valida == 1 and
				$telefone_aluno_valida == 1 and
				$email_aluno_valida == 1 and
				$nascimento_aluno_valida == 1 and
				$genero_aluno_valida == 1
			) {
				//VERIFICA ID REPETIDO
				$sql_id_repetido = "SELECT id FROM alunos WHERE id = '" . $id_aluno . "';";
				$query_id_repetido = mysqli_query($conn, $sql_id_repetido);
				$quantidade_id_repetido = mysqli_num_rows($query_id_repetido);
				//se o id nao for repetido, edita
				if ($quantidade_id_repetido == 1) {
					//edita
					//$sql_atualiza_descricao = "UPDATE final_relatorio SET descricao = '".$descricao."' WHERE id = '".$id."';";
					$sql_edita = "UPDATE alunos SET nome='" . $nome_aluno . "', telefone='" . $telefone_aluno . "', email='" . $email_aluno . "', data_nascimento='" . $nascimento_aluno . "', genero='" . $genero_aluno . "' WHERE id = '" . $id_aluno . "'; ";
					mysqli_query($conn, $sql_edita);
				} //fim if($quantidade_id_repetido == 0){




				//percorre a tabela aluno de turmas, para ver se cadastrou ou se tirou o cadastro de um aluno especifico na edição

				$sql_ver_aluno_de_turmas = "SELECT * FROM turmas WHERE visivel = '1'; ";
				$query_ver_aluno_de_turmas = mysqli_query($conn, $sql_ver_aluno_de_turmas);

				while ($ver_aluno_de_turmas = mysqli_fetch_array($query_ver_aluno_de_turmas)) {
					$id_turma = $ver_aluno_de_turmas['pk_id'];
					//se existir o POST da checkbox, vai verificar se tem o registro e se não, inserir

					if (isset($_POST['checkbox_turmas' . $id_turma . "_" . $id_aluno])) {
						echo '<br> Marcada checkbox_turmas' . $id_turma . "<br>";


						//verifica se já tem essa turma cadastrada com esse aluno
						$sql_verifica_qtd_turma = "SELECT * FROM alunos_de_turmas WHERE fk_id_aluno = '" . $id_aluno . "' AND fk_id_turma = '" . $id_turma . "';";
						$query_verifica_qtd_turma = mysqli_query($conn, $sql_verifica_qtd_turma);
						$numreo_de_turmas_repetido_aluno = mysqli_num_rows($query_verifica_qtd_turma);

						echo "<br>" . $sql_verifica_qtd_turma . "<br>";
						echo $numreo_de_turmas_repetido_aluno;

						if ($numreo_de_turmas_repetido_aluno == 0) {
							$sql_cadastra = "INSERT INTO alunos_de_turmas (pk_id, visivel, fk_id_aluno, fk_id_turma) VALUES (NULL,'1','" . $id_aluno . "','" . $id_turma . "' )";
							echo $sql_cadastra;
							mysqli_query($conn, $sql_cadastra);
						} //fim if($numreo_de_turmas_repetido_aluno == 0){

					} //fim if(isset($_POST['checkbox_turmas'.$ver_aluno_de_turmas['pk_id']])){

					//se não existir o POST da checkbox, vai excluir o registro

					if (!isset($_POST['checkbox_turmas' . $id_turma . "_" . $id_aluno])) {

						/*
  //verifica se já tem essa turma cadastrada com esse aluno
  $sql_verifica_qtd_turma = "SELECT * FROM alunos_de_turmas WHERE ";
  */

						$sql_deleta = "DELETE FROM alunos_de_turmas WHERE fk_id_aluno = '" . $id_aluno . "' AND fk_id_turma = '" . $id_turma . "'; ";
						echo $sql_deleta;
						mysqli_query($conn, $sql_deleta);
					} //fim if(!isset($_POST['checkbox_turmas'.$id_turma])){









				}/*
			fim if(
			$id_aluno_valida == 1 and
			$nome_aluno_valida == 1 and
			$telefone_aluno_valida == 1 and
			$email_aluno_valida == 1 and
			$nascimento_aluno_valida == 1 and
			$genero_aluno_valida == 1
			){
			*/


				$n = $n + 1;
			} //fim if (isset($vetor[$n])) {
			else {
				//quebra o laço infinito
				break;
			}
		} //fim while


	} //fim  while($ver_aluno_de_turmas = mysqli_fetch_array($query_ver_aluno_de_turmas)){

	echo "<script>alert('Aluno Editado com Scuesso!');</script>";
	//echo "<script>window.history.back();</script>";
} //fim if(isset($_POST['btn_editar'])){

//########################################################### FIM EDITA ALUNOS ###########################################################


//########################################################### INICIO EXCLUIR TEMPORARIAMENTE ALUNOS ###########################################################


if (isset($_POST['btn_excluir_temporariamente_aluno'])) {
	//aqui vai percorrer vetor para ver todos os IDs de registros etc
	$vetor = explode(",", $_SESSION['qtd_registros']);
	$n = 0;
	$nenhum_checkbox_marcado = 0; //vai ser 1 se marcar algum checkbox
	//laço infinito
	while (1 == 1) {
		if (isset($vetor[$n])) {
			$id = $vetor[$n];
			if (isset($_POST['checkbox' . $id])) {
				$nenhum_checkbox_marcado = 1; //vai ser true se marcar algum checkbox
				//atualiza visivel para 0, na visualização só vai ser visivel os que forem 1
				$sql_atualiza_visivel = "UPDATE alunos SET visivel = '0' WHERE id = '" . $id . "'; ";
				mysqli_query($conn, $sql_atualiza_visivel);
			} //fim if(isset($_POST['checkbox'.$id])){


		} //fim if (isset($vetor[$n])) {
		else {
			break;
		}
		$n = $n + 1;
	} //fim while
	if ($nenhum_checkbox_marcado == 0) {
		echo "<script>alert('Selecione algum checkbox para excluir!');</script>";
	} //fim if($nenhum_checkbox_marcado == 0){
	else {
		echo "<script>alert('Aluno Excluido com Sucesso!');</script>";
	} //fim else{
	echo "<script>window.history.back();</script>";
} //fim if(isset($_POST['btn_excluir_temporariamente'])){

//########################################################### FIM EXCLUIR TEMPORARIAMENTE ALUNOS ###########################################################


//########################################################### INICIO EXCLUIR PERMANENTE ALUNOS ###########################################################
if (isset($_POST['btn_excluir_permanente_aluno'])) {
	//aqui vai percorrer vetor para ver todos os IDs de registros etc
	$vetor = explode(",", $_SESSION['qtd_registros']);
	$n = 0;
	$nenhum_checkbox_marcado = 0; //vai ser 1 se marcar algum checkbox
	//laço infinito
	while (1 == 1) {
		if (isset($vetor[$n])) {
			$id = $vetor[$n];
			if (isset($_POST['checkbox' . $id])) {
				$nenhum_checkbox_marcado = 1;
				//atualiza visivel para 0, na visualização só vai ser visivel os que forem 1
				$sql_exclui_alunos_permanente = "DELETE FROM alunos WHERE id = '" . $id . "'; ";
				mysqli_query($conn, $sql_exclui_alunos_permanente);
			} //fim if(isset($_POST['checkbox'.$id])){


		} //fim if (isset($vetor[$n])) {
		else {
			//quebra laço infinito
			break;
		}
		$n = $n + 1;
	} //fim while
	if ($nenhum_checkbox_marcado == 0) {
		echo "<script>alert('Selecione algum checkbox para excluir!');</script>";
	} //fim if($nenhum_checkbox_marcado == 0){
	else {
		echo "<script>alert('Aluno Excluido com Sucesso!');</script>";
	} //fim else{
	echo "<script>window.history.back();</script>";
} //fim if(isset($_POST['btn_excluir_temporariamente'])){
//########################################################### FIM EXCLUIR PERMANENTE ALUNOS ###########################################################

//########################################################### INICIO PESQUISAR ALUNOS ###########################################################
if (isset($_POST['pesquisar_text_aluno']) and isset($_POST['btn_pesquisar_aluno'])) {
	$pesquisar_text = $_POST['pesquisar_text_aluno'];
	$pesquisar_text_valida = valida_inputs(1, $pesquisar_text);
	if ($pesquisar_text_valida == 1) {
		$_SESSION['html_pesquisa_aluno'] = "";
?>
		<?php
		$_SESSION['html_pesquisa_aluno'] .= '<table width="100%" border="1">';
		?>
		<?php
		$sql_ver_alunos = "SELECT * FROM alunos WHERE visivel = '1' AND id = '" . $pesquisar_text . "' or nome LIKE '%" . $pesquisar_text . "%' or telefone LIKE '%" . $pesquisar_text . "%' or email LIKE '%" . $pesquisar_text . "%' ORDER BY id DESC;";

		$query_ver_alunos = mysqli_query($conn, $sql_ver_alunos);

		$_SESSION['qtd_registros'] = "";
		while ($ver_alunos = mysqli_fetch_array($query_ver_alunos)) {
			$_SESSION['qtd_registros'] .= $ver_alunos['id'] . ",";
		?>


			<?php $_SESSION['html_pesquisa_aluno'] .= '<tr>'; ?>
			<?php $_SESSION['html_pesquisa_aluno'] .= '<td><input type="checkbox" name="checkbox' . $ver_alunos['id']; ?>

			<?php $_SESSION['html_pesquisa_aluno'] .= '"></td>'; ?>

			<?php $_SESSION['html_pesquisa_aluno'] .= '<td><label for="id_aluno2"></label>'; ?>

			<?php $_SESSION['html_pesquisa_aluno'] .= '<input type="text" name="id_aluno' . $ver_alunos['id']; ?><?php $_SESSION['html_pesquisa_aluno'] .= '" id="id_aluno2" value="' . $ver_alunos["id"]; ?><?php $_SESSION['html_pesquisa_aluno'] .= '" /></td>'; ?>
			<?php $_SESSION['html_pesquisa_aluno'] .= '<td><input type="text" name="nome_aluno' . $ver_alunos['id']; ?><?php $_SESSION['html_pesquisa_aluno'] .= '" id="nome_aluno2" required="required" value="' . $ver_alunos["nome"]; ?><?php $_SESSION['html_pesquisa_aluno'] .= '"/></td>
    <td><input type="text" name="telefone_aluno' . $ver_alunos['id']; ?><?php $_SESSION['html_pesquisa_aluno'] .= '" id="telefone_aluno2" value="' . $ver_alunos["telefone"]; ?><?php $_SESSION['html_pesquisa_aluno'] .= '"/></td>
    <td><input type="email" name="email_aluno' . $ver_alunos['id']; ?><?php $_SESSION['html_pesquisa_aluno'] .= '" id="email_aluno2" required="required" value="' . $ver_alunos["email"]; ?><?php $_SESSION['html_pesquisa_aluno'] .= '"/></td>
    <td><input type="date" name="nascimento_aluno' . $ver_alunos['id']; ?><?php $_SESSION['html_pesquisa_aluno'] .= '" id="nascimento_aluno2" value="' . $ver_alunos["data_nascimento"]; ?><?php $_SESSION['html_pesquisa_aluno'] .= '"/></td>
    <td><select name="genero_aluno' . $ver_alunos['id']; ?><?php $_SESSION['html_pesquisa_aluno'] .= '" id="genero_aluno">'; ?>
			<?php
			if ($ver_alunos['genero'] == "") {
			?>
				<?php $_SESSION['html_pesquisa_aluno'] .= '<option value=""></option>'; ?>
				<?php $_SESSION['html_pesquisa_aluno'] .= '<option value="0">F</option>'; ?>
				<?php $_SESSION['html_pesquisa_aluno'] .= '<option value="1">M</option>'; ?>
			<?php
			} //fim if($row['genero']== ""){

			else if ($ver_alunos['genero'] == 0) {
			?>
				<?php $_SESSION['html_pesquisa_aluno'] .= '<option value="0">F</option>'; ?>
				<?php $_SESSION['html_pesquisa_aluno'] .= '<option value="1">M</option>'; ?>
			<?php
			} //fim if($row['genero'] == 0){

			else if ($ver_alunos['genero'] == 1) {
			?>
				<?php $_SESSION['html_pesquisa_aluno'] .= '<option value="1">M</option>'; ?>
				<?php $_SESSION['html_pesquisa_aluno'] .= '<option value="0">F</option>'; ?>
			<?php
			} //fim if($row['genero'] == 0){

			?>
			<?php $_SESSION['html_pesquisa_aluno'] .= '</select></td>
    <td>'; ?>




			<?php $_SESSION['html_pesquisa_aluno'] .= '<table width="100%" border="1">'; ?>
			<?php
			$sql_ver_escolas = "SELECT * FROM escolas WHERE visivel = '1' ORDER BY id DESC;";
			//echo $sql;
			$query_ver_escolas = mysqli_query($conn, $sql_ver_escolas);

			$_SESSION['qtd_registros_turmas'] = "";
			while ($ver_escola = mysqli_fetch_array($query_ver_escolas)) {
			?>

				<?php $_SESSION['html_pesquisa_aluno'] .= '<tr>'; ?>
				<?php $_SESSION['html_pesquisa_aluno'] .= '<td nowrap="nowrap"> <b>'; ?>
				<?php $_SESSION['html_pesquisa_aluno'] .= '"("' . $ver_escola['id'] . ") " . $ver_escola['nome_escola']; ?><?php $_SESSION['html_pesquisa_aluno'] .= ':'; ?> <?php $_SESSION['html_pesquisa_aluno'] .= '</b> <br>'; ?>
				<?php
				$sql_ver_turmas = "SELECT * FROM turmas WHERE fk_id_escola = '" . $ver_escola['id'] . "' AND visivel = '1';";
				$query_ver_turmas = mysqli_query($conn, $sql_ver_turmas);
				//a session para verificar a checkbox clicada, vai ser o pk_id de turmas
				while ($ver_turmas = mysqli_fetch_array($query_ver_turmas)) {
					$_SESSION['qtd_registros_turmas'] .= $ver_turmas['pk_id'] . ",";
				?>
					<?php
					$sql_ver_turmas = "SELECT * FROM turmas WHERE fk_id_escola = '" . $ver_escola['id'] . "' AND visivel = '1';";
					$query_ver_turmas = mysqli_query($conn, $sql_ver_turmas);
					//a session para verificar a checkbox clicada, vai ser o pk_id de turmas
					while ($ver_turmas = mysqli_fetch_array($query_ver_turmas)) {
						$_SESSION['qtd_registros_turmas'] .= $ver_turmas['pk_id'] . ",";
					?>
						<?php $_SESSION['html_pesquisa_aluno'] .= '<label for="checkbox' . $ver_turmas['pk_id']; ?><?php $_SESSION['html_pesquisa_aluno'] .= '">'; ?>
						<?php
						$sql_ver_alunos_de_turmas = "SELECT * FROM alunos_de_turmas WHERE visivel = '1' AND fk_id_aluno = '" . $ver_alunos['id'] . "' AND fk_id_turma = '" . $ver_turmas['pk_id'] . "' ; ";
						$query_ver_alunos_de_turmas = mysqli_query($conn, $sql_ver_alunos_de_turmas);
						$aluno_na_turma = mysqli_num_rows($query_ver_alunos_de_turmas);
						//se tiver mais do que 0 registros, é poeque está cadastrado nessa turma
						if ($aluno_na_turma > 0) {
						?>
							<?php $_SESSION['html_pesquisa_aluno'] .= '<input type="checkbox" name="checkbox_turmas' . $ver_turmas['pk_id'] . "_" . $ver_alunos['id']; ?><?php $_SESSION['html_pesquisa_aluno'] .= '" checked="checked"/>' ?>

						<?php
						} //fim if($aluno_na_turma > 0){
						else {
						?>
							<?php $_SESSION['html_pesquisa_aluno'] .= '<input type="checkbox" name="checkbox_turmas' . $ver_turmas['pk_id'] . "_" . $ver_alunos['id']; ?><?php $_SESSION['html_pesquisa_aluno'] .= '" />'; ?>
						<?php } //fi eslse
						?>



						<?php $_SESSION['html_pesquisa_aluno'] .= '"("' . $ver_turmas['pk_id'] . '")"' . $ver_turmas['nome_turma']; ?><?php $_SESSION['html_pesquisa_aluno'] .= '</label>
          <br />'; ?>
					<?php
					} //fim while($ver_turmas = mysqli_fetch_array($query_ver_turmas)){
					?>
					<?php echo "(" . $ver_turmas['pk_id'] . ")" . $ver_turmas['nome_turma']; ?><?php $_SESSION['html_pesquisa_aluno'] .= '</label><br>'; ?>
				<?php
				} //fim while($ver_turmas = mysqli_fetch_array($query_ver_turmas)){
				?>
				<?php $_SESSION['html_pesquisa_aluno'] .= '
    </td>
  </tr>'; ?>
			<?php  } //fim while($row = mysqli_fetch_array($query)){ 
			?>
			<?php $_SESSION['html_pesquisa_aluno'] .= '</table>'; ?>


			<?php $_SESSION['html_pesquisa_aluno'] .= '
    </td>
</tr>'; ?>
	<?php
		} //fim if(!isset($_GET['pesquisa'])){

	} //fim while


	?>



	<?php $_SESSION['html_pesquisa_aluno'] .= '
</table>'; ?>

	<?php echo "<meta http-equiv='refresh' content='0;url=index.php?page=cad_alunos&pesquisa=1'>";
	//echo $_SESSION['html_pesquisa_aluno'];
	?>

	<?php

} //fim if (isset($_POST['pesquisar_text_aluno']) and isset($_POST['btn_pesquisar_aluno'])) {
//########################################################### FIM PESQUISAR ALUNOS ###########################################################


//########################################################### FIM ALUNOS ###########################################################


//########################################################### INICIO ESCOLA ###########################################################

//########################################################### INICIO CADASTRA ESCOLA ###########################################################






if (isset($_POST['id_escola']) and isset($_POST['nome_escola']) and isset($_POST['cep_escola']) and isset($_POST['data_escola']) and isset($_POST['situacao_escola'])) {

	$id_escola = $_POST['id_escola'];
	$nome_escola = $_POST['nome_escola'];
	$cep_escola = $_POST['cep_escola'];
	$data_escola = $_POST['data_escola'];
	$situacao_escola = $_POST['situacao_escola'];


	$id_escola_valida = valida_inputs(0, $id_escola);
	$nome_escola_valida = valida_inputs(1, $nome_escola);
	$cep_escola_valida = valida_inputs(0, $cep_escola);
	$data_escola_valida = valida_inputs(3, $data_escola);
	$situacao_escola_valida = valida_inputs(0, $situacao_escola);

	if (empty(trim($nome_escola))) {
		$nome_escola_valida = 1;
	} //fim if(empty(trim($nome_escola))){

	if (empty(trim($cep_escola))) {
		$cep_escola_valida = 1;
	} //fim if(empty(trim($cep_escola))){

	//verifica campos obrigatorios
	$id_escola_trim = trim($id_escola);
	$data_escola_trim = trim($data_escola);
	$situacao_escola_trim = trim($situacao_escola);

	if (is_null($id_escola_trim) and isset($id_escola) or is_null($data_escola_trim) and isset($data_escola) or is_null($situacao_escola_trim) and isset($situacao_escola)) {
		$id_escola_valida = 2;
		$data_escola_valida = 2;
		echo "<script>alert('ID e DATA e STIUAÇÃO é obrigatorio!');</script>";
		echo "<script>window.history.back();</script>";
	} //fim if (is_null($id_escola_trim) and isset($id_escola) or is_null($data_escola_trim) and isset($data_escola) or is_null($situacao_escola_trim) and isset($situacao_escola)) {




	if (
		$id_escola_valida == 1 and
		$nome_escola_valida == 1 and
		$cep_escola_valida == 1 and
		$data_escola_valida == 1 and
		$situacao_escola_valida == 1
	) {

		//VERIFICA ID REPETIDO
		$sql_id_repetido = "SELECT id FROM escolas WHERE id = '" . $id_escola . "';";
		$query_id_repetido = mysqli_query($conn, $sql_id_repetido);
		$quantidade_id_repetido = mysqli_num_rows($query_id_repetido);

		//se o id nao for repetido, cadastra
		if ($quantidade_id_repetido == 0) {
			//cadastra
			$sql_cadastra = "INSERT INTO escolas (visivel, id, nome_escola, endereco_cep, situacao, data) VALUES ('1','" . $id_escola . "','" . $nome_escola . "','" . $cep_escola . "','" . $situacao_escola . "','" . $data_escola . "' )";
			if (mysqli_query($conn, $sql_cadastra)) {
				echo "<script> alert('Escola cadastrada com sucesso!');</script>";
				echo "<meta http-equiv='refresh' content='0;url=index.php'>";
			} //fim if (mysqli_query($conn, $sql_cadastra)) {
		} //if ($quantidade_id_repetido == 0) {
		else {
			echo "<script> alert('Esse ID já foi cadastrado!');</script>";
			echo "<meta http-equiv='refresh' content='0;url=index.php'>";
		}
	}/*
	fim if($id_escola_valida == 1 and
	$nome_escola_valida == 1 and
	$cep_escola_valida == 1 and
	$data_escola_valida == 1 and
	$situacao_escola_valida == 1){
	*/
} //fiim if (isset($_POST['id_escola']) and isset($_POST['nome_escola']) and isset($_POST['cep_escola']) and isset($_POST['data_escola']) and isset($_POST['situacao_escola']) ) {

//########################################################### FIM CADASTRA ESCOLA ###########################################################


//########################################################### INICIO EDITA ESCOLA ###########################################################

if (isset($_POST['btn_editar_escola'])) {
	//aqui vai percorrer vetor para ver todos os IDs de registros etc
	$vetor = explode(",", $_SESSION['qtd_registros']);
	$n = 0;
	//laço infinito
	while (1 == 1) {
		//se existir posição no vetor, acrescenta o id ao nome do POST, e faz as devidas validações
		if (isset($vetor[$n])) {
			$nome_input = $vetor[$n];


			$id_escola = @$_POST['id_escola' . $nome_input];
			$nome_escola = @$_POST['nome_escola' . $nome_input];
			$cep_escola = @$_POST['cep_escola' . $nome_input];
			$data_escola = @$_POST['data_escola' . $nome_input];
			$situacao_escola = @$_POST['situacao_escola' . $nome_input];


			$id_escola_valida = valida_inputs(0, $id_escola);
			$nome_escola_valida = valida_inputs(1, $nome_escola);
			$cep_escola_valida = valida_inputs(0, $cep_escola);
			$data_escola_valida = valida_inputs(3, $data_escola);
			$situacao_escola_valida = valida_inputs(0, $situacao_escola);


			if (empty($nome_escola)) {
				$nome_escola_valida = 1;
			}
			if (empty($cep_escola)) {
				$cep_escola_valida = 1;
			}


			//verifica campos obrigatorios
			$id_escola_trim = trim($id_escola);
			$data_escola_trim = trim($data_escola);
			$situacao_escola_trim = trim($situacao_escola);


			if (is_null($id_escola_trim) and isset($id_escola) or is_null($data_escola_trim) and isset($data_escola) or is_null($situacao_escola_trim) and isset($situacao_escola)) {

				$id_escola_valida = 2;
				$data_escola_valida = 2;
				echo "<script>alert('ID e DATA e STIUAÇÃO é obrigatorio!');</script>";
				echo "<script>window.history.back();</script>";
			} //fim if (is_null($id_escola_trim) and isset($id_escola) or is_null($data_escola_trim) and isset($data_escola) or is_null($situacao_escola_trim) and isset($situacao_escola)) {


			//se todos os campos de validação for igual a 1, quer dizer que passou no regex e vai prosseguir com o cadastro
			if (
				$id_escola_valida == 1 and
				$nome_escola_valida == 1 and
				$cep_escola_valida == 1 and
				$data_escola_valida == 1 and
				$situacao_escola_valida == 1
			) {

				//edita
				$sql_edita = "UPDATE escolas SET nome_escola='" . $nome_escola . "', endereco_cep='" . $cep_escola . "', situacao='" . $situacao_escola . "', data='" . $data_escola . "' WHERE id = '" . $id_escola . "' ;";

				mysqli_query($conn, $sql_edita);
			}/*
	fim if($id_escola_valida == 1 and
	$nome_escola_valida == 1 and
	$cep_escola_valida == 1 and
	$data_escola_valida == 1 and
	$situacao_escola_valida == 1){
	*/


			$n = $n + 1;
		} //fim if (isset($vetor[$n])) {
		else {
			//quebra o laço infinito
			break;
		}
	} //fim while
	echo "<script>alert('ESCOLA EDITADA COM SUCESSO!');</script>";
	echo "<script>window.history.back();</script>";
} //fim if(isset($_POST['btn_editar'])){

//########################################################### FIM EDITA ESCOLA ###########################################################


//########################################################### INICIO EXCLUIR TEMPORARIAMENTE ESCOLA ###########################################################


if (isset($_POST['btn_excluir_temporariamente_escola'])) {
	//aqui vai percorrer vetor para ver todos os IDs de registros etc
	$vetor = explode(",", $_SESSION['qtd_registros']);
	$n = 0;
	$nenhum_checkbox_marcado = 0; //vai ser 1 se marcar algum checkbox
	//laço infinito
	while (1 == 1) {
		if (isset($vetor[$n])) {
			$id = $vetor[$n];
			if (isset($_POST['checkbox' . $id])) {
				$nenhum_checkbox_marcado = 1; //vai ser true se marcar algum checkbox
				//atualiza visivel para 0, na visualização só vai ser visivel os que forem 1
				$sql_atualiza_visivel = "UPDATE escolas SET visivel = '0' WHERE id = '" . $id . "'; ";
				mysqli_query($conn, $sql_atualiza_visivel);
			} //fim if(isset($_POST['checkbox'.$id])){


		} //fim if (isset($vetor[$n])) {
		else {
			break;
		}
		$n = $n + 1;
	} //fim while
	if ($nenhum_checkbox_marcado == 0) {
		echo "<script>alert('Selecione algum checkbox para excluir!');</script>";
	} //fim if($nenhum_checkbox_marcado == 0){
	else {
		echo "<script>alert('ESCOLA Excluida com Sucesso!');</script>";
	} //fim else{
	echo "<script>window.history.back();</script>";
} //fim if(isset($_POST['btn_excluir_temporariamente'])){

//########################################################### FIM EXCLUIR TEMPORARIAMENTE ESCOLA ###########################################################



//########################################################### INICIO EXCLUIR PERMANENTE ESCOLA ###########################################################
if (isset($_POST['btn_excluir_permanente_escola'])) {
	//aqui vai percorrer vetor para ver todos os IDs de registros etc
	$vetor = explode(",", $_SESSION['qtd_registros']);
	$n = 0;
	$nenhum_checkbox_marcado = 0; //vai ser 1 se marcar algum checkbox
	//laço infinito
	while (1 == 1) {
		if (isset($vetor[$n])) {
			$id = $vetor[$n];
			if (isset($_POST['checkbox' . $id])) {
				$nenhum_checkbox_marcado = 1;
				//atualiza visivel para 0, na visualização só vai ser visivel os que forem 1
				$sql_exclui_alunos_permanente = "DELETE FROM escolas WHERE id = '" . $id . "'; ";
				mysqli_query($conn, $sql_exclui_alunos_permanente);
			} //fim if(isset($_POST['checkbox'.$id])){


		} //fim if (isset($vetor[$n])) {
		else {
			//quebra laço infinito
			break;
		}
		$n = $n + 1;
	} //fim while
	if ($nenhum_checkbox_marcado == 0) {
		echo "<script>alert('Selecione algum checkbox para excluir!');</script>";
	} //fim if($nenhum_checkbox_marcado == 0){
	else {
		echo "<script>alert('Escola Excluida com Sucesso!');</script>";
	} //fim else{
	echo "<script>window.history.back();</script>";
} //fim if(isset($_POST['btn_excluir_temporariamente'])){
//########################################################### FIM EXCLUIR PERMANENTE ESCOLA ###########################################################




//########################################################### INICIO PESQUISAR ESCOLA ###########################################################
if (isset($_POST['pesquisar_text_escola']) and isset($_POST['btn_pesquisar_escola'])) {
	$pesquisar_text = $_POST['pesquisar_text_escola'];
	$pesquisar_text_valida = valida_inputs(1, $pesquisar_text);
	if ($pesquisar_text_valida == 1) {
		$_SESSION['html_pesquisa_escola'] = "";
	?>

		<?php $_SESSION['html_pesquisa_escola'] .= '<table width="100%" border="1">'; ?>
		<?php
		$sql = "SELECT * FROM escolas WHERE visivel = '1' AND id LIKE '%" . $pesquisar_text . "%' or nome_escola LIKE '%" . $pesquisar_text . "%' or endereco_cep LIKE '%" . $pesquisar_text . "%' ORDER BY id DESC;";
		$query = mysqli_query($conn, $sql);

		$_SESSION['qtd_registros'] = "";
		while ($row = mysqli_fetch_array($query)) {
			$_SESSION['qtd_registros'] .= $row['id'] . ",";
		?>
			<?php $_SESSION['html_pesquisa_escola'] .= '<tr>'; ?>


			<?php $_SESSION['html_pesquisa_escola'] .= '<td><input type="checkbox" name="checkbox' . $row['id']; ?><?php $_SESSION['html_pesquisa_escola'] .= '"></td>
    <td><label for="id_aluno2"></label>
      <input type="text" name="id_escola' . $row['id']; ?><?php $_SESSION['html_pesquisa_escola'] .= '" id="id_escola2" value="' . $row['id']; ?><?php $_SESSION['html_pesquisa_escola'] .= '" /></td>
    <td><input type="text" name="nome_escola' . $row['id']; ?><?php $_SESSION['html_pesquisa_escola'] .= '" id="nome_escola2" value="' . $row['nome_escola']; ?><?php $_SESSION['html_pesquisa_escola'] .= '"/></td>
    <td><input type="text" name="cep_escola' . $row['id']; ?><?php $_SESSION['html_pesquisa_escola'] .= '" id="cep_escola2" value="' . $row['endereco_cep']; ?><?php $_SESSION['html_pesquisa_escola'] .= '"/></td>
    <td><input type="date" name="data_escola' . $row['id']; ?><?php $_SESSION['html_pesquisa_escola'] .= '" id="data_escola2" required="required" value="' . $row['data']; ?><?php $_SESSION['html_pesquisa_escola'] .= '"/></td>
    <td><select name="situacao_escola' . $row['id']; ?><?php $_SESSION['html_pesquisa_escola'] .= '" required="required">'; ?>
			<?php if ($row['situacao'] == 0) { ?>
				<?php $_SESSION['html_pesquisa_escola'] .= '<option value="0">Situação 1</option>'; ?>
				<?php $_SESSION['html_pesquisa_escola'] .= '<option value="1">Situação 2</option>'; ?>
			<?php } //fim if($row['stiuacao'] == 0) {
			?>

			<?php if ($row['situacao'] == 1) { ?>
				<?php $_SESSION['html_pesquisa_escola'] .= '<option value="1">Situação 2</option>'; ?>
				<?php $_SESSION['html_pesquisa_escola'] .= '<option value="0">Situação 1</option>'; ?>
			<?php } //fim if($row['stiuacao'] == 0) {
			?>
			</select></td>
		<?php

		} //fim while

		?>

		<?php $_SESSION['html_pesquisa_escola'] .= '
</tr>

</table>
'; ?>
		<?php

		echo "<meta http-equiv='refresh' content='0;url=index.php?page=cad_escola&pesquisa=1'>"; ?>
	<?php
	} //fim if($pesquisar_text_valida == 1){
} //fim if (isset($_POST['pesquisar_text_aluno']) and isset($_POST['btn_pesquisar_aluno'])) {
//########################################################### FIM PESQUISAR ESCOLA ###########################################################




//########################################################### INICIO CADASTRO TURMAS ###########################################################

if (isset($_POST['select_escola']) and isset($_POST['nome_turma']) and isset($_POST['ano']) and isset($_POST['nivel_turma']) and isset($_POST['serie_turma']) and isset($_POST['turno_turma']) and isset($_POST['btn_cadastrar_turma'])) {
	//recebe inputs POST cadastra TURMA
	$select_escola = $_POST['select_escola'];
	$nome_turma = $_POST['nome_turma'];
	$ano = $_POST['ano'];
	$nivel_turma = $_POST['nivel_turma'];
	$serie_turma = $_POST['serie_turma'];
	$turno_turma = $_POST['turno_turma'];




	//valida campos cadastra TURMA
	$select_escola_valida = valida_inputs(0, $select_escola);
	$nome_turma_valida = valida_inputs(1, $nome_turma);
	$ano_valida = valida_inputs(0, $ano);
	$nivel_turma_valida = valida_inputs(0, $nivel_turma);
	$serie_turma_valida = valida_inputs(0, $serie_turma);
	$turno_turma_valida = valida_inputs(0, $turno_turma);


	if (empty($nome_escola)) {
		$nome_turma_valida = 1;
	}
	if (empty($ano)) {
		$ano_valida = 1;
	}
	if (empty($serie_turma)) {
		$serie_turma_valida = 1;
	}
	$select_escola_trim = trim($select_escola);
	if (empty($select_escola_trim) and isset($select_escola)) {
		$select_escola_valida = 2;
		echo "<script>alert('Escola é obrigatorio!');</script>";
		echo "<script>window.history.back();</script>";
	} //fim if (empty($nome_aluno_trim) and isset($nome_aluno)) {



	//se todos os campos de validação for igual a 1, quer dizer que passou no regex e vai prosseguir com o cadastro
	if (
		$select_escola_valida == 1 and
		$nome_turma_valida == 1 and
		$ano_valida == 1 and
		$nivel_turma_valida == 1 and
		$serie_turma_valida == 1 and
		$turno_turma_valida == 1
	) {
		//cadastra
		$sql_cadastra = "INSERT INTO turmas (pk_id, visivel, fk_id_escola, ano, nivel_ensino, serie, turno, nome_turma) VALUES (NULL,'1','" . $select_escola . "','" . $ano . "','" . $nivel_turma . "','" . $serie_turma . "','" . $turno_turma . "','" . $nome_turma . "')";
		if (mysqli_query($conn, $sql_cadastra)) {
			echo "<script> alert('Turma cadastrada com sucesso!');</script>";
			echo "<script>window.history.back();</script>";
		} //fim if (mysqli_query($conn, $sql_cadastra)) {

	}/*fimif (
		$select_escola_valida == 1 and
		$nome_turma_valida == 1 and
		$ano_valida == 1 and
		$nivel_turma_valida == 1 and
		$serie_turma_valida == 1 and
		$turno_turma_valida == 1
	) {*/ else {
		echo "<script> alert('Esse id já está em uso!');</script>";
		echo "<script>javascript:history.back()<script>";
	} //fim else {

} //fim if (isset($_POST['id_aluno']) and isset($_POST['nome_aluno']) and isset($_POST['telefone_aluno']) and isset($_POST['email_aluno']) and isset($_POST['nascimento_aluno']) and isset($_POST['genero_aluno'])){

//########################################################### FIM CADASTRO TURMAS ###########################################################


//########################################################### INICIO EDITA TURMA ###########################################################

if (isset($_POST['btn_editar_turma'])) {
	//aqui vai percorrer vetor para ver todos os IDs de registros etc
	$vetor = explode(",", $_SESSION['qtd_registros']);
	$n = 0;
	//laço infinito
	while (1 == 1) {
		//se existir posição no vetor, acrescenta o id ao nome do POST, e faz as devidas validações
		if (isset($vetor[$n])) {
			$nome_input = $vetor[$n];


			$id_turma = @$_POST['id_turma' . $nome_input];
			$select_escola_editar = @$_POST['select_escola_editar' . $nome_input];
			$nome_turma_editar = @$_POST['nome_turma_editar' . $nome_input];
			$ano_editar = @$_POST['ano_editar' . $nome_input];
			$nivel_turma_editar = @$_POST['nivel_turma_editar' . $nome_input];
			$serie_turma_editar = @$_POST['serie_turma_editar' . $nome_input];
			$turno_turma_editar = @$_POST['turno_turma_editar' . $nome_input];


			$id_turma_editar_valida = valida_inputs(0, $id_turma);
			$select_edtitar_escola_valida = valida_inputs(0, $select_escola_editar);
			$nome_turma_editar_valida = valida_inputs(1, $nome_turma_editar);
			$ano_editar_valida = valida_inputs(0, $ano_editar);
			$nivel_turma_editar_valida = valida_inputs(0, $nivel_turma_editar);
			$serie_turma_editar_valida = valida_inputs(0, $serie_turma_editar);
			$turno_turma_editar_valida = valida_inputs(0, $turno_turma_editar);



			//verifica campos obrigatorios
			$nivel_turma_trim = trim($nivel_turma_editar);
			$turno_turma_trim = trim($turno_turma_editar);

			if (is_null($nivel_turma_trim) and isset($nivel_turma_editar) or is_null($turno_turma_trim) and isset($turno_turma_editar)) {
				$nivel_turma_valida = 2;
				$turno_turma_valida = 2;
				echo "<script>alert('NIVEL E TURMA é obrigatorio!');</script>";
				echo "<script>window.history.back();</script>";
			} //fim if(empty($id_escola_trim) and isset($id_escola) or empty($data_escola_trim) and isset($data_escola) or empty($situacao_escola_trim) and isset($situacao_escola)){


			//se todos os campos de validação for igual a 1, quer dizer que passou no regex e vai prosseguir com o cadastro



			if (empty($nome_turma_editar)) {
				$nome_turma_editar_valida = 1;
			} //fim if(empty($nome_turma_editar)){

			if (empty($ano_editar)) {
				$ano_editar_valida = 1;
			} //fim if(empty($ano_editar)){
			if (empty($nivel_turma_editar)) {
				$nivel_turma_editar_valida = 1;
			} //fim if(empty($nivel_turma_editar)){
			if (empty($serie_turma_editar)) {
				$serie_turma_editar_valida = 1;
			} //fim if(empty($serie_turma_editar)){
			if (empty($turno_turma_editar)) {
				$turno_turma_editar_valida = 1;
			} //fim if(empty($turno_turma_editar)){

			echo $id_turma_editar_valida . "<br>";
			echo $select_edtitar_escola_valida . "<br>";
			echo $nome_turma_editar_valida . "<br>";
			echo $ano_editar_valida . "<br>";
			echo $nivel_turma_editar_valida . "<br>";
			echo $serie_turma_editar_valida . "<br>";
			echo $turno_turma_editar_valida . "<br>";

			if (
				$id_turma_editar_valida == 1 and
				$select_edtitar_escola_valida == 1 and
				$nome_turma_editar_valida == 1 and
				$ano_editar_valida == 1 and
				$nivel_turma_editar_valida == 1 and
				$serie_turma_editar_valida == 1 and
				$turno_turma_editar_valida == 1
			) {

				//edita
				$sql_edita = "UPDATE turmas SET fk_id_escola='" . $select_escola_editar . "', ano='" . $ano_editar . "', nivel_ensino='" . $nivel_turma_editar . "', serie='" . $serie_turma_editar . "', turno = '" . $turno_turma_editar . "', nome_turma = '" . $nome_turma_editar . "' WHERE pk_id = '" . $id_turma . "' ;";
				mysqli_query($conn, $sql_edita);
			}/*
	fim if (
				$id_turma_editar_valida == 1 and
			$select_edtitar_escola_valida == 1 and
			$nome_turma_editar_valida == 1 and
			$ano_editar_valida == 1 and
			$nivel_turma_editar_valida == 1 and
			$serie_turma_editar_valida == 1 and
			$turno_turma_editar_valida == 1
			) {
	*/


			$n = $n + 1;
		} //fim if (isset($vetor[$n])) {
		else {
			//quebra o laço infinito
			break;
		}
	} //fim while
	echo "<script>alert('TURMA EDITADA COM SUCESSO!');</script>";
	echo "<script>window.history.back();</script>";
} //fim if(isset($_POST['btn_editar'])){

//########################################################### FIM EDITA TURMA ###########################################################


//########################################################### INICIO EXCLUIR TEMPORARIAMENTE TURMA ###########################################################


if (isset($_POST['btn_excluir_temporariamente_turma'])) {
	//aqui vai percorrer vetor para ver todos os IDs de registros etc
	$vetor = explode(",", $_SESSION['qtd_registros']);
	$n = 0;
	$nenhum_checkbox_marcado = 0; //vai ser 1 se marcar algum checkbox
	//laço infinito
	while (1 == 1) {
		if (isset($vetor[$n])) {
			$id = $vetor[$n];
			if (isset($_POST['checkbox' . $id])) {
				$nenhum_checkbox_marcado = 1; //vai ser true se marcar algum checkbox
				//atualiza visivel para 0, na visualização só vai ser visivel os que forem 1
				$sql_atualiza_visivel = "UPDATE turmas SET visivel = '0' WHERE pk_id = '" . $id . "'; ";
				mysqli_query($conn, $sql_atualiza_visivel);
			} //fim if(isset($_POST['checkbox'.$id])){


		} //fim if (isset($vetor[$n])) {
		else {
			break;
		}
		$n = $n + 1;
	} //fim while
	if ($nenhum_checkbox_marcado == 0) {
		echo "<script>alert('Selecione algum checkbox para excluir!');</script>";
	} //fim if($nenhum_checkbox_marcado == 0){
	else {
		echo "<script>alert('TURMA Excluida com Sucesso!');</script>";
	} //fim else{
	echo "<script>window.history.back();</script>";
} //fim if(isset($_POST['btn_excluir_temporariamente'])){

//########################################################### FIM EXCLUIR TEMPORARIAMENTE TURMA ###########################################################

//########################################################### INICIO EXCLUIR PERMANENTE TURMA ###########################################################
if (isset($_POST['btn_excluir_permanente_turma'])) {
	//aqui vai percorrer vetor para ver todos os IDs de registros etc
	$vetor = explode(",", $_SESSION['qtd_registros']);
	$n = 0;
	$nenhum_checkbox_marcado = 0; //vai ser 1 se marcar algum checkbox
	//laço infinito
	while (1 == 1) {
		if (isset($vetor[$n])) {
			$id = $vetor[$n];
			if (isset($_POST['checkbox' . $id])) {
				$nenhum_checkbox_marcado = 1;
				//atualiza visivel para 0, na visualização só vai ser visivel os que forem 1
				$sql_exclui_tumas = "DELETE FROM turmas WHERE pk_id = '" . $id . "'; ";
				mysqli_query($conn, $sql_exclui_tumas);
			} //fim if(isset($_POST['checkbox'.$id])){


		} //fim if (isset($vetor[$n])) {
		else {
			//quebra laço infinito
			break;
		}
		$n = $n + 1;
	} //fim while
	if ($nenhum_checkbox_marcado == 0) {
		echo "<script>alert('Selecione algum checkbox para excluir!');</script>";
	} //fim if($nenhum_checkbox_marcado == 0){
	else {
		echo "<script>alert('TURMA Excluida com Sucesso!');</script>";
	} //fim else{
	echo "<script>window.history.back();</script>";
} //fim if(isset($_POST['btn_excluir_temporariamente'])){
//########################################################### FIM EXCLUIR PERMANENTE TURMA ###########################################################

//########################################################### INICIO PESQUISAR turma ###########################################################
if (isset($_POST['pesquisar_text_escola_turma']) and isset($_POST['btn_pesquisar_turma'])) {
	$pesquisar_text = $_POST['pesquisar_text_escola_turma'];
	$pesquisar_text_valida = valida_inputs(1, $pesquisar_text);
	if ($pesquisar_text_valida == 1) {
		$_SESSION['html_pesquisa_turma'] = "";
	?>
		<?php $_SESSION['html_pesquisa_turma'] .= '<table width="100%" border="1">'; ?>

		<?php


		$_SESSION['qtd_registros'] = "";


		$sql_ver_turmas = "SELECT * FROM turmas WHERE visivel = '1' AND pk_id = '" . $pesquisar_text . "' or nome_turma LIKE '%" . $pesquisar_text . "%' ORDER BY pk_id DESC;";

		$query_ver_turmas = mysqli_query($conn, $sql_ver_turmas);

		while ($linha = mysqli_fetch_array($query_ver_turmas)) {
			$_SESSION['qtd_registros'] .= $linha['pk_id'] . ",";
		?>

			<?php $_SESSION['html_pesquisa_turma'] .= '<tr>
    <td><input type="checkbox" name="checkbox' . $linha['pk_id']; ?><?php $_SESSION['html_pesquisa_turma'] .= '"/>'; ?><?php $_SESSION['html_pesquisa_turma'] .= '</td>'; ?>


			<?php $_SESSION['html_pesquisa_turma'] .= '<td>' . $linha['pk_id']; ?>
			<?php $_SESSION['html_pesquisa_turma'] .= '<input type="hidden" name="id_turma' . $linha['pk_id']; ?><?php $_SESSION['html_pesquisa_turma'] .= '" value="' . $linha['pk_id']; ?><?php $_SESSION['html_pesquisa_turma'] .= '"'; ?> <?php $_SESSION['html_pesquisa_turma'] .= '/>
    </td>
      <td>
        <select name="select_escola_editar' . $linha['pk_id']; ?><?php $_SESSION['html_pesquisa_turma'] .= '" required="required" id="select_escola_editar">'; ?>

			<?php
			$sql_select_escolas = "SELECT id, nome_escola FROM escolas WHERE id = '" . $linha['fk_id_escola'] . "';";
			$query_select_escolas = mysqli_query($conn, $sql_select_escolas);
			$row_escola = mysqli_fetch_array($query_select_escolas);

			?>
			<?php $_SESSION['html_pesquisa_turma'] .= '<option value="' . $row_escola['id']; ?><?php $_SESSION['html_pesquisa_turma'] .= '">' . "(" . $row_escola['id'] . ") " . $row_escola['nome_escola']; ?><?php $_SESSION['html_pesquisa_turma'] .= '</option>'; ?>
			<?php
			$sql_select_escolas_all = "SELECT * FROM escolas WHERE visivel = '1' ORDER BY id DESC;";
			$query_select_escolas_all = mysqli_query($conn, $sql_select_escolas_all);
			while ($ver_todas_escolas = mysqli_fetch_array($query_select_escolas_all)) {

			?>
				<?php $_SESSION['html_pesquisa_turma'] .= '<option value="' . $ver_todas_escolas['id'] . '"'; ?><?php $_SESSION['html_pesquisa_turma'] .= '>' . "(" . $ver_todas_escolas['id'] . ") " . $ver_todas_escolas['nome_escola']; ?><?php $_SESSION['html_pesquisa_turma'] .= '</option>'; ?>
			<?php
			} //fim  while($ver_todas_escolas = mysqli_fetch_array($query_select_escolas)){
			?>

			<?php $_SESSION['html_pesquisa_turma'] .= '</select></td>
      <td><input type="text" name="nome_turma_editar' . $linha['pk_id']; ?><?php $_SESSION['html_pesquisa_turma'] .= '" id="nome_turma_editar" value="' . $linha['nome_turma']; ?><?php $_SESSION['html_pesquisa_turma'] .= '"/></td>
      <td><input type="text" name="ano_editar' . $linha['pk_id']; ?><?php $_SESSION['html_pesquisa_turma'] .= '" id="ano_editar" value="' . $linha['ano']; ?><?php $_SESSION['html_pesquisa_turma'] .= '"/></td>
      <td><select name="nivel_turma_editar' . $linha['pk_id']; ?><?php $_SESSION['html_pesquisa_turma'] .= '" required="required" id="nivel_turma_editar">'; ?>
			<?php
			if ($linha['nivel_ensino'] == 0) {
			?>
				<?php $_SESSION['html_pesquisa_turma'] .= '<option value="0">Fundamental</option>'; ?>
				<?php $_SESSION['html_pesquisa_turma'] .= '<option value="1">medio</option>'; ?>
			<?php
			} //fim if($linha['nivel_ensino'] == 0){
			?>

			<?php
			if ($linha['nivel_ensino'] == 1) {
			?>
				<?php $_SESSION['html_pesquisa_turma'] .= '<option value="1">medio</option>'; ?>
				<?php $_SESSION['html_pesquisa_turma'] .= '<option value="0">Fundamental</option>'; ?>

			<?php
			} //fim if($linha['nivel_ensino'] == 1){
			?>


			<?php $_SESSION['html_pesquisa_turma'] .= '</select></td>
      <td><input type="number" name="serie_turma_editar' . $linha['pk_id']; ?><?php $_SESSION['html_pesquisa_turma'] .= '" id="serie_turma_editar" value="' . $linha['serie']; ?> <?php $_SESSION['html_pesquisa_turma'] .= '"/></td>
      <td><select name="turno_turma_editar' . $linha['pk_id']; ?><?php $_SESSION['html_pesquisa_turma'] .= '"'; ?> <?php $_SESSION['html_pesquisa_turma'] .= 'required id="turno_turma_editar">'; ?>


			<?php
			if ($linha['turno'] == 0) {
			?>
				<?php $_SESSION['html_pesquisa_turma'] .= '<option value="0">Matutino</option>'; ?>
				<?php $_SESSION['html_pesquisa_turma'] .= '<option value="1">Vespertino</option>'; ?>
				<?php $_SESSION['html_pesquisa_turma'] .= '<option value="2">Noturno</option>'; ?>

			<?php
			} //fim if($linha['turno'] == 0){
			?>

			<?php
			if ($linha['turno'] == 1) {
			?>
				<?php $_SESSION['html_pesquisa_turma'] .= '<option value="1">Vespertino</option>'; ?>
				<?php $_SESSION['html_pesquisa_turma'] .= '<option value="0">Matutino</option>'; ?>
				<?php $_SESSION['html_pesquisa_turma'] .= '<option value="2">Noturno</option>'; ?>

			<?php
			} //fim if($linha['turno'] == 1){

			?>

			<?php
			if ($linha['turno'] == 2) {
			?>
				<?php $_SESSION['html_pesquisa_turma'] .= '<option value="2">Noturno</option>'; ?>
				<?php $_SESSION['html_pesquisa_turma'] .= '<option value="1">Vespertino</option>'; ?>
				<?php $_SESSION['html_pesquisa_turma'] .= '<option value="0">Matutino</option>'; ?>


			<?php
			} //fim if($linha['turno'] == 2){
			?>



			<?php $_SESSION['html_pesquisa_turma'] .= '</select></td>'; ?>

		<?php

		} //fim while($linha = mysqli_fetch_array($query_ver_turmas)){

		?>

		<?php $_SESSION['html_pesquisa_turma'] .= '
</tr>

</table>
'; ?>
		<?php echo "<meta http-equiv='refresh' content='0;url=index.php?page=cad_turma&pesquisa=1'>";

		?>
<?php
	} //fim if($pesquisar_text_valida == 1){
} //fim if (isset($_POST['pesquisar_text_aluno']) and isset($_POST['btn_pesquisar_aluno'])) {
//########################################################### FIM PESQUISAR turma ###########################################################
