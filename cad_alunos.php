<?php
@session_start();
?>
<form action="posts.php" method="post">

  <table width="100%" border="1">
    <tr>
      <td colspan="4"><label for="textfield"></label>
        <table width="100%" border="1">
          <tr>

          </tr>
        </table>
      </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th nowrap="nowrap">ID</th>
      <th nowrap="nowrap">NOME</th>
      <th nowrap="nowrap">TELEFONE</th>
      <th nowrap="nowrap">E-MAIL</th>
      <th nowrap="nowrap">NASCIMENTO</th>
      <th nowrap="nowrap">GENERO</th>
      <th nowrap="nowrap">#</th>
    </tr>

    <tr>
      <td><label for="id_aluno"></label>
        <input type="text" name="id_aluno" id="id_aluno" />
      </td>
      <td><input type="text" name="nome_aluno" id="nome_aluno" required="required" /></td>
      <td><input type="text" name="telefone_aluno" id="telefone_aluno" /></td>
      <td><input type="email" name="email_aluno" id="email_aluno" required="required" /></td>
      <td><input type="date" name="nascimento_aluno" id="nascimento_aluno" /></td>
      <td><select name="genero_aluno" id="select">
          <option></option>
          <option value="0">F</option>
          <option value="1">M</option>
        </select></td>
      <td>
        <table width="100%" border="1">
          <?php
          $sql_ver_escolas = "SELECT * FROM escolas WHERE visivel = '1' ORDER BY id DESC;";
          $query_ver_escolas = mysqli_query($conn, $sql_ver_escolas);

          $_SESSION['qtd_registros_turmas'] = "";
          while ($ver_escola = mysqli_fetch_array($query_ver_escolas)) {
          ?>

            <tr>
              <td nowrap="nowrap">
                <b><?php echo "(" . $ver_escola['id'] . ") " . $ver_escola['nome_escola']; ?>: </b> <br>
                <?php
                $sql_ver_turmas = "SELECT * FROM turmas WHERE fk_id_escola = '" . $ver_escola['id'] . "' AND visivel = '1';";
                $query_ver_turmas = mysqli_query($conn, $sql_ver_turmas);
                //a session para verificar a checkbox clicada, vai ser o pk_id de turmas
                while ($ver_turmas = mysqli_fetch_array($query_ver_turmas)) {
                  $_SESSION['qtd_registros_turmas'] .= $ver_turmas['pk_id'] . ",";
                ?>
                  <label for="checkbox<?php echo $ver_turmas['pk_id']; ?>">
                    <input type="checkbox" name="checkbox_turmas<?php echo $ver_turmas['pk_id']; ?>" />
                    <?php echo "(" . $ver_turmas['pk_id'] . ")" . $ver_turmas['nome_turma']; ?></label><br>
                <?php
                } //fim while($ver_turmas = mysqli_fetch_array($query_ver_turmas)){
                ?>

              </td>
            </tr>
          <?php  } //fim while($row = mysqli_fetch_array($query)){ 
          ?>
        </table>

      </td>
    </tr>

    <tr>
      <td colspan="7"><input type="submit" name="btn_cadastrar_aluno" id="btn_cadastrar_aluno" value="Cadastrar" /></td>
    </tr>
    <tr>
      <td colspan="7">&nbsp;</td>
    </tr>
  </table>
</form>


<form action="posts.php" method="post">
  <table width="100%" border="1">
    <tr>
      <td colspan="5"><label for="textfield2"></label>
        <table width="100%" border="1">
          <tr>
            <td><input name="pesquisar_text_aluno" type="text" id="textfield2" size="90" placeholder="ID OU NOME OU TELEFONE OU E-MAIL" />
              <input type="submit" name="btn_pesquisar_aluno" id="button2" value="Pesquisar" />
            </td>
          </tr>
        </table>
      </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th nowrap="nowrap">#</th>
      <th nowrap="nowrap">ID</th>
      <th nowrap="nowrap">NOME</th>
      <th nowrap="nowrap">TELEFONE</th>
      <th nowrap="nowrap">E-MAIL</th>
      <th nowrap="nowrap">NASCIMENTO</th>
      <th nowrap="nowrap">GENERO</th>
      <th nowrap="nowrap">#</th>
    </tr>
    <?php
    $sql_ver_alunos = "SELECT * FROM alunos WHERE visivel = '1' ORDER BY id DESC;";
    //echo $sql;
    $query_ver_alunos = mysqli_query($conn, $sql_ver_alunos);

    $_SESSION['qtd_registros'] = "";
    while ($ver_alunos = mysqli_fetch_array($query_ver_alunos)) {
      $_SESSION['qtd_registros'] .= $ver_alunos['id'] . ",";
    ?>

      <?php
      if (!isset($_GET['pesquisa'])) {
      ?>
        <tr>
          <td><input type="checkbox" name="checkbox<?php echo $ver_alunos['id']; ?>"></td>
          <td><label for="id_aluno2"></label>
            <input type="text" name="id_aluno<?php echo $ver_alunos['id']; ?>" id="id_aluno2" value="<?php echo $ver_alunos["id"]; ?>" />
          </td>
          <td><input type="text" name="nome_aluno<?php echo $ver_alunos['id']; ?>" id="nome_aluno2" required="required" value="<?php echo $ver_alunos["nome"]; ?>" /></td>
          <td><input type="text" name="telefone_aluno<?php echo $ver_alunos['id']; ?>" id="telefone_aluno2" value="<?php echo $ver_alunos["telefone"]; ?>" /></td>
          <td><input type="email" name="email_aluno<?php echo $ver_alunos['id']; ?>" id="email_aluno2" required="required" value="<?php echo $ver_alunos["email"]; ?>" /></td>
          <td><input type="date" name="nascimento_aluno<?php echo $ver_alunos['id']; ?>" id="nascimento_aluno2" value="<?php echo $ver_alunos["data_nascimento"]; ?>" /></td>
          <td><select name="genero_aluno<?php echo $ver_alunos['id']; ?>" id="genero_aluno">
              <?php
              if ($ver_alunos['genero'] == "") {
              ?>
                <option value=""></option>
                <option value="0">F</option>
                <option value="1">M</option>
              <?php
              } //fim if($row['genero']== ""){

              else if ($ver_alunos['genero'] == 0) {
              ?>
                <option value="0">F</option>
                <option value="1">M</option>
              <?php
              } //fim if($row['genero'] == 0){

              else if ($ver_alunos['genero'] == 1) {
              ?>
                <option value="1">M</option>
                <option value="0">F</option>
              <?php
              } //fim if($row['genero'] == 0){

              ?>
            </select></td>
          <td>




            <table width="100%" border="1">
              <?php
              $sql_ver_escolas = "SELECT * FROM escolas WHERE visivel = '1' ORDER BY id DESC;";
              //echo $sql;
              $query_ver_escolas = mysqli_query($conn, $sql_ver_escolas);

              $_SESSION['qtd_registros_turmas'] = "";
              while ($ver_escola = mysqli_fetch_array($query_ver_escolas)) {
              ?>

                <tr>
                  <td nowrap="nowrap">
                    <b><?php echo "(" . $ver_escola['id'] . ") " . $ver_escola['nome_escola']; ?>: </b> <br>
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
                        <label for="checkbox<?php echo $ver_turmas['pk_id']; ?>2">
                          <?php
                          $sql_ver_alunos_de_turmas = "SELECT * FROM alunos_de_turmas WHERE visivel = '1' AND fk_id_aluno = '" . $ver_alunos['id'] . "' AND fk_id_turma = '" . $ver_turmas['pk_id'] . "' ; ";
                          $query_ver_alunos_de_turmas = mysqli_query($conn, $sql_ver_alunos_de_turmas);
                          $aluno_na_turma = mysqli_num_rows($query_ver_alunos_de_turmas);
                          //se tiver mais do que 0 registros, é poeque está cadastrado nessa turma
                          if ($aluno_na_turma > 0) {
                          ?>
                            <input type="checkbox" name="checkbox_turmas<?php echo $ver_turmas['pk_id'] . "_" . $ver_alunos['id']; ?>" checked="checked" />

                          <?php
                          } //fim if($aluno_na_turma > 0){
                          else {
                          ?>
                            <input type="checkbox" name="checkbox_turmas<?php echo $ver_turmas['pk_id'] . "_" . $ver_alunos['id']; ?>" />
                          <?php } //fi eslse
                          ?>



                          <?php echo "(" . $ver_turmas['pk_id'] . ")" . $ver_turmas['nome_turma']; ?></label>
                        <br />
                      <?php
                      } //fim while($ver_turmas = mysqli_fetch_array($query_ver_turmas)){
                      ?>
                      <?php echo "(" . $ver_turmas['pk_id'] . ")" . $ver_turmas['nome_turma']; ?></label><br>
                    <?php
                    } //fim while($ver_turmas = mysqli_fetch_array($query_ver_turmas)){
                    ?>

                  </td>
                </tr>
              <?php  } //fim while($row = mysqli_fetch_array($query)){ 
              ?>
            </table>



          </td>
        </tr>
    <?php
      } //fim if(!isset($_GET['pesquisa'])){

    } //fim while

    if (isset($_GET['pesquisa'])) {
      echo @$_SESSION['html_pesquisa_aluno'];
    } //fim if(isset($_GET['pesquisa'])){

    ?>



    <tr>
      <td colspan="8">
        <input type="submit" name="btn_editar_aluno" id="btn_editar_aluno" value="Editar Todos" />
        <input type="submit" name="btn_excluir_temporariamente_aluno" id="btn_editar" value="Excluir Temporariamente" />
        <input type="submit" name="btn_excluir_permanente_aluno" id="btn_editar" value="Excluir Permanente" />

      </td>
    </tr>
    <tr>
      <td colspan="8">&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>


</form>