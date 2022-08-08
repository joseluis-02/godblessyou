<?php
        require 'header.php';
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Lugares <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table style="width:100%"id="datatable_lugar" class="display responsive nowrap table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Nombre</th>
                            <th>Prefijo</th>
                            <th>Padre</th>
                            <th>Nivel</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Nombre</th>
                            <th>Prefijo</th>
                            <th>Padre</th>
                            <th>Nivel</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario_lugar" id="formulario_lugar" method="POST" enctype="multipart/form-data">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Nombre:</label>
                            <input type="hidden" name="id" id="id">
                            <input type="text" class="form-control" name="nombre" id="nombre" maxlength="70" placeholder="Nombre" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Prefijo:</label>
                            <input type="text" class="form-control" name="prefijo" id="prefijo" maxlength="30" placeholder="Prefijo" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Nivel:</label>
                            <select id="nivel" data-live-search="true" name="nivel" class="form-control selectpicker" data-live-search="true" required>
                              <option value="0">Pais</option>
                              <option value="1">Departamento/provincia</option>
                              <option value="2">Región/local</option>
                            </select>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Padre:</label>
                            <select id="padre" data-live-search="true" name="padre" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" name="btnGuardar" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
  <?php
  require 'footer.php';
  ?>
 <script type="text/javascript" src="scripts/lugar.js"></script>