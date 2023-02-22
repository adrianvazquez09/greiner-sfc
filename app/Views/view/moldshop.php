<html>


<div class=" jumbotron jumbotron-fluid" >
  <div class="container"><br>

    <div class="row">
      <div class="col-sm-3"><img src="<?php echo base_url() ?>/plugins/logo/logo.svg" width="120px"></div>
      <div class="col-sm-9">
        <h1>Tablero Mantenimiento / Moldes</h1>
      </div>
    </div>

    <br>
  </div>
</div>
<div class="container-fluid">
  <table class="table table-bordered border-primary">
    <thead>
      <tr class="table-warning">
        <th scope="col">OT #</th>
        <th scope="col">PRIORIDAD</th>
        <th scope="col">Máquina / Molde</th>
        <th scope="col">Tipo de trabajo</th>
        <th scope="col">Responsable</th>
        <th scope="col">Fecha de entrada</th>
        <th scope="col">Fecha tentativa de entrega</th>
        <th scope="col">Comentarios</th>
        <th scope="col">Status</th>
        <th scope="col">Progreso</th>
      </tr>
    </thead>
    <tbody>
      <?php for ($i = 0; $i < count($moldTable); $i++) { ?>
        <tr>
          <th scope="row"><?php echo $moldTable[$i]['id'] ?></th>
          <td><?php echo $moldTable[$i]['priority'] ?></td>
          <td><?php echo $moldTable[$i]['mold'] ?></td>
          <td><?php echo $moldTable[$i]['work_type'] ?></td>
          <td><?php echo $moldTable[$i]['responsable'] ?></td>
          <td><?php echo $moldTable[$i]['entry_date'] ?></td>
          <td><?php echo $moldTable[$i]['delivery_date'] ?></td>
          <td><?php echo $moldTable[$i]['comments'] ?></td>
          <td><?php echo $moldTable[$i]['status'] ?></td>
          <?php if ($moldTable[$i]['progress'] == 'A tiempo') { ?>
            <td class="bg-success"><?php echo $moldTable[$i]['progress'] ?>
</div>
</td>
<?php } else if ($moldTable[$i]['progress'] == 'Atrasado') { ?>
  <td class="bg-warning">
    <div style="color:white"><?php echo $moldTable[$i]['progress'] ?>
  </td>
<?php } else if ($moldTable[$i]['progress'] == 'Afuera' || $moldTable[$i]['progress'] == 'Expirado') { ?>
  <td class="bg-danger">
    <div style="color:white"><?php echo $moldTable[$i]['progress'] ?>
  </td>
  </tr>
<?php } ?>
<?php } ?>
</tbody>
</table>
Terminados en las ultimas 24 horas
<table class="table table-bordered border-primary">
  <thead>
    <tr class="table-warning">
      <th scope="col">#</th>
      <th scope="col">PRIORIDAD</th>
      <th scope="col">Máquina / Molde</th>
      <th scope="col">Tipo de trabajo</th>
      <th scope="col">Responsable</th>
      <th scope="col">Fecha de salida</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
    <?php for ($i = 0; $i < count($moldTableHist); $i++) { ?>
      <tr>
        <th scope="row"><?php echo $moldTableHist[$i]['id'] ?></th>
        <td><?php echo $moldTableHist[$i]['priority'] ?></td>
        <td><?php echo $moldTableHist[$i]['mold'] ?></td>
        <td><?php echo $moldTableHist[$i]['work_type'] ?></td>
        <td><?php echo $moldTableHist[$i]['responsable'] ?></td>
        <td><?php echo $moldTableHist[$i]['entry_date'] ?></td>
        <td><?php echo $moldTableHist[$i]['status'] ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>
<b>Last update:</b> <?php echo date('Y-m-d h:i:s'); ?>
</div>

</html>


<script type="text/javascript">
  var timeout = setTimeout("location.reload(true);", 10000);


  function resetTimeout() {
    clearTimeout(timeout);
    timeout = setTimeout("location.reload(true);", 10000);
  }
</script>