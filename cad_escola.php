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
    </tr>
    <tr>
      <th nowrap="nowrap">ID*</th>
      <th nowrap="nowrap">NOME ESCOLA</th>
      <th nowrap="nowrap">ENDEREÇO(CEP)</th>
      <th nowrap="nowrap">DATA*</th>
      <th nowrap="nowrap">SITUAÇÃO*</th>
    </tr>

    <tr>
      <td><label for="id_escola"></label>
        <input type="text" name="id_escola" id="id_escola" required="required" />
      </td>
      <td><input type="text" name="nome_escola" id="nome_escola" /></td>
      <td><input type="text" name="cep_escola" id="cep_escola" /></td>
      <td><input type="date" name="data_escola" id="data_escola" required="required" /></td>
      <td><select name="situacao_escola" required>
          <option></option>
          <option value="0">Situação 1</option>
          <option value="1">Situação 2</option>
        </select></td>
    </tr>

    <tr>
      <td colspan="5"><input type="submit" name="btn_cadastrar_escola" id="btn_cadastrar_escola" value="Cadastrar" /></td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
  </table>
</form>


<form action="posts.php" method="post">
  <table width="100%" border="1">
    <tr>
      <td colspan="5"><label for="textfield2"></label>
        <table width="100%" border="1">
          <tr>
            <td><input name="pesquisar_text_escola" type="text" id="textfield2" size="90" placeholder="ID OU NOME OU CEP" />
              <input type="submit" name="btn_pesquisar_escola" id="button2" value="Pesquisar" />
            </td>
          </tr>
        </table>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th nowrap="nowrap">#</th>
      <th nowrap="nowrap">ID</th>
      <th nowrap="nowrap">NOME ESCOLA</th>
      <th nowrap="nowrap">ENDEREÇO(CEP)</th>
      <th nowrap="nowrap">DATA</th>
      <th nowrap="nowrap">SITUAÇÃO</th>
    </tr>
    <?php
    $sql = "SELECT * FROM escolas WHERE visivel = '1' ORDER BY id DESC;";
    $query = mysqli_query($conn, $sql);

    $_SESSION['qtd_registros'] = "";
    while ($row = mysqli_fetch_array($query)) {
      $_SESSION['qtd_registros'] .= $row['id'] . ",";
    ?>
      <tr>
        <?php
        if (!isset($_GET['pesquisa'])) {
        ?>

          <td><input type="checkbox" name="checkbox<?php echo $row['id']; ?>"></td>
          <td><label for="id_aluno2"></label>
            <input type="text" name="id_escola<?php echo $row['id']; ?>" id="id_escola2" value="<?php echo $row['id']; ?>" />
          </td>
          <td><input type="text" name="nome_escola<?php echo $row['id']; ?>" id="nome_escola2" value="<?php echo $row['nome_escola']; ?>" /></td>
          <td><input type="text" name="cep_escola<?php echo $row['id']; ?>" id="cep_escola2" value="<?php echo $row['endereco_cep']; ?>" /></td>
          <td><input type="date" name="data_escola<?php echo $row['id']; ?>" id="data_escola2" required="required" value="<?php echo $row['data']; ?>" /></td>
          <td><select name="situacao_escola<?php echo $row['id']; ?>" required="required">
              <?php if ($row['situacao'] == 0) { ?>
                <option value="0">Situação 1</option>
                <option value="1">Situação 2</option>
              <?php } //fim if($row['stiuacao'] == 0) {
              ?>

              <?php if ($row['situacao'] == 1) { ?>
                <option value="1">Situação 2</option>
                <option value="0">Situação 1</option>
              <?php } //fim if($row['stiuacao'] == 0) {
              ?>
            </select></td>
      <?php
        } //fim if(!isset($_GET['pesquisar'])){

      } //fim while

      if (isset($_GET['pesquisa'])) {
        echo @$_SESSION['html_pesquisa_escola'];
      } //fim if(isset($_GET['pesquisar'])){{

      ?>


      </tr>
      <tr>
        <td colspan="6">
          <input type="submit" name="btn_editar_escola" id="btn_editar_escola" value="Editar Todos" />
          <input type="submit" name="btn_excluir_temporariamente_escola" id="btn_editar" value="Excluir Temporariamente" />
          <input type="submit" name="btn_excluir_permanente_escola" id="btn_editar" value="Excluir Permanente" />

        </td>
      </tr>
      <tr>
        <td colspan="6">&nbsp;</td>
      </tr>
  </table>
  <p>&nbsp;</p>


</form>