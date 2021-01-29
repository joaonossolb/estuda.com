<?php
@session_start();
?>
<form action="posts.php" method="post">

  <table width="100%" border="1">
    <tr>
      <td colspan="5"><label for="textfield"></label>
        <table width="100%" border="1">
          <tr>

          </tr>
        </table>
      </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th nowrap="nowrap">ID</th>
      <th nowrap="nowrap">Escola*</th>
      <th nowrap="nowrap">Nome Turma</th>
      <th nowrap="nowrap">Ano</th>
      <th nowrap="nowrap">Nivel</th>
      <th nowrap="nowrap">Serie</th>
      <th nowrap="nowrap">Turno</th>
    </tr>

    <tr>
      <td>

      </td>
      <td><label for="id_escola"></label>
        <select name="select_escola" required="required" id="select_escola">
          <?php
          $sql_select_escolas = "SELECT * FROM escolas WHERE visivel = '1' ORDER BY id DESC;";
          $query_select_escolas = mysqli_query($conn, $sql_select_escolas);

          while ($row = mysqli_fetch_array($query_select_escolas)) {
          ?>
            <option value="<?php echo $row['id']; ?>"><?php echo "(" . $row['id'] . ") " . $row['nome_escola']; ?></option>
          <?php

          } //fim while($row = mysqli_fetch_array($query_select_escolas)){
          ?>
        </select>
      </td>
      <td><input type="text" name="nome_turma" id="nome_turma" /></td>
      <td><input type="text" name="ano" id="ano" /></td>
      <td><select name="nivel_turma" required="required" id="nivel_turma">
          <option></option>
          <option value="0">Fundamental</option>
          <option value="1">medio</option>
        </select></td>
      <td><input type="number" name="serie_turma" id="serie_turma" /></td>
      <td><select name="turno_turma" required id="turno_turma">
          <option></option>
          <option value="0">Matutino</option>
          <option value="1">Vespertino</option>
          <option value="2">Noturno</option>
        </select></td>
    </tr>

    <tr>
      <td colspan="7"><input type="submit" name="btn_cadastrar_turma" id="btn_cadastrar_turma" value="Cadastrar" /></td>
    </tr>
    <tr>
      <td colspan="7">&nbsp;</td>
    </tr>
  </table>
</form>


<form action="posts.php" method="post">
  <table width="100%" border="1">
    <tr>
      <td colspan="6"><label for="textfield2"></label>
        <table width="100%" border="1">
          <tr>
            <td><input name="pesquisar_text_escola_turma" type="text" id="textfield2" size="90" placeholder="ID OU NOME_TURMA" />
              <input type="submit" name="btn_pesquisar_turma" id="button2" value="Pesquisar" />
            </td>
          </tr>
        </table>
      </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th nowrap="nowrap">#</th>
      <th nowrap="nowrap">ID</th>
      <th nowrap="nowrap">Escola*</th>
      <th nowrap="nowrap">Nome Turma</th>
      <th nowrap="nowrap">Ano</th>
      <th nowrap="nowrap">Nivel</th>
      <th nowrap="nowrap">Serie</th>
      <th nowrap="nowrap">Turno</th>
    </tr>
    <?php

    $_SESSION['qtd_registros'] = "";


    $sql_ver_turmas = "SELECT * FROM turmas WHERE visivel = '1' ORDER BY pk_id DESC;";
    $query_ver_turmas = mysqli_query($conn, $sql_ver_turmas);

    while ($linha = mysqli_fetch_array($query_ver_turmas)) {
      $_SESSION['qtd_registros'] .= $linha['pk_id'] . ",";
    ?>
      <tr>
        <td><input type="checkbox" name="checkbox<?php echo $linha['pk_id']; ?>" /></td>
        <?php
        if (!isset($_GET['pesquisa'])) {
        ?>

          <td><?php echo $linha['pk_id']; ?>
            <input type="hidden" name="id_turma<?php echo $linha['pk_id']; ?>" value="<?php echo $linha['pk_id']; ?>" />
          </td>
          <td>
            <select name="select_escola_editar<?php echo $linha['pk_id']; ?>" required="required" id="select_escola_editar">

              <?php
              //$sql_select_escolas_da_turma = "SELECT ";
              ?>
              <?php
              $sql_select_escolas = "SELECT id, nome_escola FROM escolas WHERE id = '" . $linha['fk_id_escola'] . "';";
              $query_select_escolas = mysqli_query($conn, $sql_select_escolas);
              $row_escola = mysqli_fetch_array($query_select_escolas);

              ?>
              <option value="<?php echo $row_escola['id']; ?>"><?php echo "(" . $row_escola['id'] . ") " . $row_escola['nome_escola']; ?></option>
              <?php
              $sql_select_escolas_all = "SELECT * FROM escolas WHERE visivel = '1' ORDER BY id DESC;";
              $query_select_escolas_all = mysqli_query($conn, $sql_select_escolas_all);
              while ($ver_todas_escolas = mysqli_fetch_array($query_select_escolas_all)) {

              ?>
                <option value="<?php echo $ver_todas_escolas['id']; ?>"><?php echo "(" . $ver_todas_escolas['id'] . ") " . $ver_todas_escolas['nome_escola']; ?></option>
              <?php
              } //fim  while($ver_todas_escolas = mysqli_fetch_array($query_select_escolas)){
              ?>

            </select>
          </td>
          <td><input type="text" name="nome_turma_editar<?php echo $linha['pk_id']; ?>" id="nome_turma_editar" value="<?php echo $linha['nome_turma']; ?>" /></td>
          <td><input type="text" name="ano_editar<?php echo $linha['pk_id']; ?>" id="ano_editar" value="<?php echo $linha['ano']; ?>" /></td>
          <td><select name="nivel_turma_editar<?php echo $linha['pk_id']; ?>" required="required" id="nivel_turma_editar">
              <?php
              if ($linha['nivel_ensino'] == 0) {
              ?>
                <option value="0">Fundamental</option>
                <option value="1">medio</option>
              <?php
              } //fim if($linha['nivel_ensino'] == 0){
              ?>

              <?php
              if ($linha['nivel_ensino'] == 1) {
              ?>
                <option value="1">medio</option>
                <option value="0">Fundamental</option>

              <?php
              } //fim if($linha['nivel_ensino'] == 1){
              ?>


            </select></td>
          <td><input type="number" name="serie_turma_editar<?php echo $linha['pk_id']; ?>" id="serie_turma_editar" value="<?php echo $linha['serie']; ?>" /></td>
          <td><select name="turno_turma_editar<?php echo $linha['pk_id']; ?>" required id="turno_turma_editar">


              <?php
              if ($linha['turno'] == 0) {
              ?>
                <option value="0">Matutino</option>
                <option value="1">Vespertino</option>
                <option value="2">Noturno</option>

              <?php
              } //fim if($linha['turno'] == 0){
              ?>

              <?php
              if ($linha['turno'] == 1) {
              ?>
                <option value="1">Vespertino</option>
                <option value="0">Matutino</option>
                <option value="2">Noturno</option>

              <?php
              } //fim if($linha['turno'] == 1){

              ?>

              <?php
              if ($linha['turno'] == 2) {
              ?>
                <option value="2">Noturno</option>
                <option value="1">Vespertino</option>
                <option value="0">Matutino</option>


              <?php
              } //fim if($linha['turno'] == 2){
              ?>



            </select></td>

      <?php
        } //fim if(!isset($_GET['pesquisar'])){

      } //fim while($linha = mysqli_fetch_array($query_ver_turmas)){
      if (isset($_GET['pesquisa'])) {
        echo @$_SESSION['html_pesquisa_turma'];
      } //fim if(isset($_GET['pesquisar'])){{

      ?>


      </tr>
      <tr>
        <td colspan="8">
          <input type="submit" name="btn_editar_turma" id="btn_editar_turma" value="Editar Todos" />
          <input type="submit" name="btn_excluir_temporariamente_turma" id="btn_editar" value="Excluir Temporariamente" />
          <input type="submit" name="btn_excluir_permanente_turma" id="btn_editar" value="Excluir Permanente" />

        </td>
      </tr>
      <tr>
        <td colspan="8">&nbsp;</td>
      </tr>
  </table>
  <p>&nbsp;</p>


</form>