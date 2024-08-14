<!-- MODAL EDITAR EQUIPO -->
<div class="modal fade" id="modal_editar_equipo">

  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form id="registro_equipos_edit">
        <div class="card card-primary card-outline">
          <div class="modal-header">
            <h3 class="card-title">
              <i class="fas fa-edit"></i>
              Editar datos equipo.
            </h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>


          </div>
          <div class="modal-body">
            <div class="form-group uk-text-center">

              <span style="color:#ff0000; font-size:12px;"> Todos los Campos Con (*) Son Obligatorios</span>

            </div>

            <div class="row">

              <!--  PRIMER DIV   -->
              <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Nombre:<span style="color:#ff0000;">*</span></label>
                        <input name="txt_nombre_edit" id="txt_nombre_edit" type="text" class="form-control uk-input" placeholder="Nombre..." />
                        <span class="help-block"></span>
                      </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Estación:</label>
                        <input name="txt_estacion_edit" id="txt_estacion_edit" type="text" class="form-control uk-input" placeholder="Estación..." />
                        <span class="help-block"></span>
                      </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Color:</label>
                        <input name="txt_color_edit" id="txt_color_edit" type="text" class="form-control uk-input" placeholder="Color..." />
                        <span class="help-block"></span>
                      </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Imagen:</label>
                        <div uk-form-custom="target: true">
                          <input type="file" id="txt_imagen_edit" name="txt_imagen_edit" accept="image/*" onchange="showPreview_edit(event);">
                          <div class="preview">
                            <img id="file-ip-1-preview_edit">
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </section>

              <!--  SEGUNDO DIV   -->
              <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">


                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Tipo Equipo:<span style="color:#ff0000;">*</span></label>
                        <select name="txt_tipo_equipo_edit" id="txt_tipo_equipo_edit" type="text" class="form-control uk-select">
                          <option value="">-- Seleccionar --</option>
                        </select>
                        <span class="help-block"></span>
                      </div>
                    </div>



                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Marca:</label>
                        <input name="txt_marca_edit" id="txt_marca_edit" type="text" class="form-control uk-input" placeholder="Marca..." />
                        <span class="help-block"></span>
                      </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Serie:</label>
                        <input name="txt_serie_edit" id="txt_serie_edit" type="text" class="form-control uk-input" placeholder="Serie..." />
                        <span class="help-block"></span>
                      </div>
                    </div>

                  </div>
                </div>
              </section>

              <!--  TERCER DIV   -->
              <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">


                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                          <label for="txtcar">Sub Equipo:<span style="color:#ff0000;">*</span></label>
                          <select name="txt_tipo_sub_equipo_edit" id="txt_tipo_sub_equipo_edit" type="text" class="form-control uk-select">
                            <option value="">-- Seleccionar --</option>
                          </select>
                          <span class="help-block"></span>
                        </div>
                      </div>

                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Modelo:</label>
                        <input name="txt_modelo_edit" id="txt_modelo_edit" type="text" class="form-control uk-input" placeholder="Modelo..." />
                        <span class="help-block"></span>
                      </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Año:</label>
                        <input name="txt_anio_edit" id="txt_anio_edit" type="text" class="form-control uk-input" placeholder="Año..." oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" />
                        <span class="help-block"></span>
                      </div>
                    </div>

                  </div>
                </div>
              </section>
              <!--  TERCER DIV   -->
              <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">

                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Unidad:<span style="color:#ff0000;">*</span></label>
                        <select name="txt_unidad_edit" id="txt_unidad_edit" type="text" class="form-control uk-select">
                        </select>
                        <span class="help-block"></span>
                      </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Encargado:</label>
                        <input name="txt_encargado_edit" id="txt_encargado_edit" type="text" class="form-control uk-input" placeholder="Encargado..." />
                        <span class="help-block"></span>
                      </div>
                    </div>


                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Capacidad:</label>
                        <input name="txt_capacidad_edit" id="txt_capacidad_edit" type="text" class="form-control uk-input" placeholder="Capacidad..." />
                        <span class="help-block"></span>
                      </div>
                    </div>


                  </div>
                </div>
              </section>




            </div>


          </div>
          <div class="modal-footer justify-content-between">

            <button type="submit" class="btn btn-info btn-block btn-flat"><i class="fas fa-edit"></i>Editar Equipo</button>
          </div>
        </div>

      </form>

      <div class="card-footer">
        Editar Equipo
      </div>
    </div>
  </div>

</div>
<!-- MODAL EDITAR EQUIPO -->


<!-- MODAL CREAER ORDEN MANTENIMIENTO -->

<div class="modal fade" id="modal_crear_orden">

  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form id="registro_equipos_edit1">
        <div class="card card-primary card-outline">
          <div class="modal-header">
            <h3 class="card-title">
              <i class="fas fa-edit"></i>
              Crear Requerimiento
            </h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>


          </div>
          <div class="modal-body">
            <div class="form-group uk-text-center">

              <span style="color:#ff0000; font-size:12px;"> Todos los Campos Con (*) Son Obligatorios</span>

            </div>

            <div class="row">

              <!--  PRIMER DIV   -->
			  
			  <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                   <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Orden de Corte:<span style="color:#ff0000;">*</span> </label>
                        <input name="txt_norden" id="txt_norden" type="text" class="form-control uk-input" placeholder="..." />
                        <span class="help-block"></span>
                      </div>
                    </div>

                    

                  </div>
                </div>
              </section>
              <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <div class="form-group">
                        <label>Fecha:<span style="color:#ff0000;">*</span></label>
                        <div class="input-group" >
                          <input type="date" id="txt_fecha" name="txt_fecha" class="form-control" value="<?php echo  date('Y-m-d');?>"  onchange="semana_fecha()"/>
                        </div>
                      </div>
                    </div>
                  </div>
</div>
              </section>

              <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <div class="form-group">
                        <label>Semana:<span style="color:#ff0000;">*</span></label>
                        <div class="input-group date" >
                          <input type="text" id="txt_semana_req" readonly name="txt_semana_req" class="form-control" />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </section>

              <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <div class="form-group">
                        <label>Semana Exportadora:<span style="color:#ff0000;">*</span></label>
                        <div class="input-group date" >
                          <input type="text" id="txt_semanaexpo_req" name="txt_semanaexpo_req" class="form-control" />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </section>


              <!--  TERCER DIV   -->
              <section class="col-md-6">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Cliente:</label><span style="color:#ff0000;">*</span>
                      <br>
                        <select name="txt_cliente" id="txt_cliente" type="text" style="width:100%; height:150%" class="form-control uk-select select_txtcli">
                        </select>
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
              <!--  TERCER DIV   -->
              
<script>
 //  alert('ok');
  
 //$('#txt_cliente').select2();  
  
</script>


              <section class="col-md-6">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Productor:</label><span style="color:#ff0000;">*</span>
                        <select name="txt_productor" id="txt_productor" type="text" class="form-control uk-select">
                        </select>
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </section>



              <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Hacienda:</label><span style="color:#ff0000;">*</span>
                        <select name="txt_hacienda" id="txt_hacienda" type="text" class="form-control uk-select">
                        </select>
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </section>

              <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Zona:</label><span style="color:#ff0000;">*</span>
                        <select name="txt_zona" id="txt_zona" type="text" class="form-control uk-select">
                        </select>
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </section>

              <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Marca Caja:</label><span style="color:#ff0000;">*</span>
                        <select name="txt_marcacaja" id="txt_marcacaja" type="text" class="form-control uk-select">
                        </select>
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </section>

              <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Sticker:</label><span style="color:#ff0000;">*</span>
                        <input name="txt_sticker" id="txt_sticker" type="text" class="form-control uk-input" placeholder="..." />
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </section>

              <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Peso:</label><span style="color:#ff0000;">*</span>
                        <input name="txt_peso" id="txt_peso" type="text" class="form-control uk-input" placeholder="..." />
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </section>


              <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">                      
                      <div class="form-group">
                        <label for="txtcar">Cupo:<span style="color:#ff0000;">*</span></label>
                        <input name="txt_cupo" id="txt_cupo" type="text" class="form-control uk-input" placeholder="..." />
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </section>

              <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">                      
                      <div class="form-group">
                        <label for="txtcar">Tipo:<span style="color:#ff0000;">*</span></label>
                        <select name="txt_tipo_req" id="txt_tipo_req" type="text" class="form-control uk-select">
                          <option value="Contenedor">Contenedor</option>
                          <option value="Suelta">Suelta</option>
                          <option value="GRANEL CONTENERIZADA">GRANEL CONTENERIZADA</option>
                          <option value="PALETIZADO CTNER ORITO - ZUNCHO 5KL">PALETIZADO CTNER ORITO - ZUNCHO 5KL</option>
                          <option value="BJO CBTA 48 PALLET 106*124 ESQ.PLAST.220 PROTEC.32*50*1.5">BJO CBTA 48 PALLET 106*124 ESQ.PLAST.220 PROTEC.32*50*1.5</option>
                          <option value="GRANEL">GRANEL</option>
                          <option value="PALLETS 48 BJO CUBIERTA ESQ. PLAST 220 CM PROTEC 50*32*1.5">PALLETS 48 BJO CUBIERTA ESQ. PLAST 220 CM PROTEC 50*32*1.5</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
  

              <section class="col-md-3"  style="display: none;">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">                      
                      <div class="form-group">
                        <label for="txtcar">Adjunto:</label>
                        <input type="file" id="txt_adjuntoreq" class="form-control" name="txt_adjuntoreq" >
                      </div>
                    </div>
                  </div>
                </div>
              </section>

              



<!--modulo de exportacion-->
<section class="col-md-12">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">                      
                      <div class="form-group" style="text-align: center">
                        <label for="txtcar">EXPORTACIÓN</label>
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </section>

<section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">                      
                      <div class="form-group">
                        <label for="txtcar">Plan:<span style="color:#ff0000;">*</span></label>
                        <input type="text" class="form-control" id="txt_plan_exportacion_req" autocomplete="off"  />
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </section>

              <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">                      
                      <div class="form-group">
                        <label for="txtcar">Vapor:<span style="color:#ff0000;">*</span></label>
                        <input type="text" class="form-control" id="txt_vapor_exportacion_req" autocomplete="off"  />
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </section>

              <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">                      
                      <div class="form-group">
                        <label for="txtcar">Booking:<span style="color:#ff0000;">*</span></label>
                        <input type="text" class="form-control" id="txt_booking_exportacion_req" autocomplete="off"  />
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </section>

          <!--    <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">                      
                      <div class="form-group">
                        <label for="txtcar">Tipo de Embarque:<span style="color:#ff0000;">*</span></label>
                        <select class="form-control uk-select" id="txt_tipoembarque_exportacion_req" required name="txt_tipoembarque_exportacion_req">
                    <option>Contenedor</option>
                    <option>Suelto</option>
                                  </select>
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
-->
              
              <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">                      
                      <div class="form-group">
                        <label for="txtcar">Puerto Embarque:<span style="color:#ff0000;">*</span></label>
                        <select class="form-control uk-select clase1" id="txt_puertoembarque_exportacion_req" name="txt_puertoembarque_exportacion_req">
                                  </select>
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </section>

              <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">                      
                      <div class="form-group">
                        <label for="txtcar">Destino:<span style="color:#ff0000;">*</span></label>
                                  <input type="text" class="form-control" id="txt_destino_exportacion_req" autocomplete="off"  />
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </section>




            </div>

          </div>
          <div class="modal-footer justify-content-between">

            <button type="button" id="btn_save_orden" class="btn btn-outline-info btn-block btn-flat"><i class="fas fa-save"></i> Crear Requerimiento</button>
          </div>
        </div>

      </form>

      <div class="card-footer">
        


      </div>
    </div>
  </div>

</div>

<!-- MODAL CREAER ORDEN MANTENIMIENTO -->


<!-- MODAL SERVICIOS CLIENTE-->
<div class="modal fade" id="modal_servicios_clientes">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="card card-primary card-outline">
        <div class="modal-header">
          <h3 class="card-title">
            <i class="fas fa-edit"></i>
            Servicios Clientes.
          </h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
		  
		  <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="form-group">
                <label for="txcar">Cliente:</label>
                <input name="txt_cliente_servicio" id="txt_cliente_servicio" type="text" class="form-control uk-input" placeholder="Cliente..." readonly="true" />
                <span class="help-block"></span>
              </div>

            </div>
		  
		  <!-- FORMULARIO -->
                <div class="card-body">


                  <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="custom-content-below-home-tab-client" data-toggle="pill" href="#custom-content-below-home-client" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Vinculados</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-content-below-profile-tab-client" data-toggle="pill" href="#custom-content-below-profile-client" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Existentes</a>
                    </li>

                  </ul>



                  <div class="tab-content" id="custom-content-below-tabContent">

                    <div class="tab-pane fade show active" id="custom-content-below-home-client" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                      <div class="col-md-12">

                        

                        <div id="monitor_cliente"></div>

                        <div class="step">
                          
						  <div class="col-xs-12">
							  <strong for="checkcaja">Seleccionar Todos</strong>
							  <input type="checkbox" id="checkegreso" />
							  <span class="help-block"></span>
							</div>

						<section class="col-md-12">
						  <table id="table_servicios_clientes" class="table table-striped table-bordered text-rigth tabla_detalle_fp">
							<thead>
							  <tr>
								<td style="width:40px">#</td>
								<td style="width:80px">Modalidad</td>
								<td style="width:80px;">Servicio</td>
								<td style="width:80px">Unidad</td>
								<td style="width:120px"></td>
							  </tr>
							</thead>
							<tbody>
							</tbody>
						  </table>
						</section>
						  <div class="modal-footer col-sm-12 uk-text-center">

                                <button type="button" id="btn_cargar_servicio" class="btn btn-outline-info btn-block btn-flat"><i class="fas fa-save"></i> Crear Servicio</button>

                              </div>
						  
                        </div>

                      </div>

                    </div>
                    <div class="tab-pane fade" id="custom-content-below-profile-client" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">

                      <div class="card-body">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                          <div class="table-responsive demo-x content">

                            <div class="box-body">

                              <table id="table_detalle_servicios_creados" class="table table-striped table-bordered text-rigth tabla_detalle_fp">
                                <thead>
                                  <tr>
                                    <td style="width:40px">#</td>
                                    <td style="width:40px">Fecha</td>
									<td style="width:20px">Semana</td>
									<td style="width:80px">Modalidad</td>
									<td style="width:80px">Servicio</td>
									<td style="width:80px">Unidad</td>
									<td style="width:80px">Vapor</td>
									<td style="width:80px">Caja</td>
									<td style="width:80px">Tipo</td>
									<td style="width:80px">Contenedor</td>
									<td style="width:80px"></td>
                                  </tr>
                                </thead>
                                <tbody>
                                </tbody>
                              </table>
							  <div class="modal-footer col-sm-12 uk-text-center">

                                <button type="button" id="btn_cargar_servicio_exit" class="btn btn-outline-info btn-block btn-flat"><i class="fas fa-save"></i> Crear Servicio</button>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>

                  </div>



                </div>

                <!-- FIN FORMULARIO -->

            
            

          </div>
        </div>
       
      </div>
      <div class="card-footer">
        Servicios Clientes.
      </div>
    </div>
  </div>

</div>
<!-- MODAL SERVICIOS CLIENTE-->




<!-- MODAL DETALLE DE REQUERIMIENTO-->
<div class="modal fade" id="modal_detalle_req">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="card card-primary card-outline">
        <div class="modal-header">
          <h3 class="card-title">
            <i class="fas fa-edit"></i>
            Detalle de servicios.
          </h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">

            


            <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="form-group">
                <label for="txcar">Cliente:</label>
                <input name="txt_cliente_requerimiento" id="txt_cliente_requerimiento" type="text" class="form-control uk-input" readonly="true" />
                <span class="help-block"></span>
              </div>
            </div>


            <section class="col-md-12">
              <div class="col-lg-12">
                <div class="card card-primary card-outline">
                  <div class="card-header">
                    <h5 class="m-0">Servicios</h5>
                  </div>
                  <div class="card-body">



                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <div class="table-responsive demo-x content">

                        <div class="box-body">
                          <table id="table_detalle_servicos" class="table table-striped table-bordered text-rigth tabla_detalle_fp">
                            <thead>
                              <tr>
                                <td style="width:10px">#</td>
								<td style="width:10px">Compania</td>
								<td style="width:40px">Fecha&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
								<td style="width:20px">Semana</td>
                                <td style="width:80px">Modalidad</td>
                                <td style="width:80px">Servicio</td>
                                <td style="width:80px">Unidad</td>
                                <td style="width:80px">Vapor</td>
                                <td style="width:80px">Caja</td>
                                <td style="width:80px">Tipo</td>
                                <td style="width:80px">Contenedor</td>
                                <td style="width:80px">Cantidad</td>
                                <td style="width:80px">Precio</td>
                                <td style="width:80px">Total</td>
                                
                                <td style="width:80px">Estatus</td>
                              </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>



          </div>
        </div>

      </div>
      <div class="card-footer">
        Detalle Servicios Clientes.
      </div>
    </div>
  </div>

</div>
<!-- MODAL SERVICIOS CLIENTE-->






<!-- MODAL PARA REALIZAR EL PAGO-->
<div class="modal fade" id="modal_pagos" data-backdrop="static" data-keyboard="true">
	<div class="modal-dialog modal-xs">
		<div class="modal-content">
		  <div class="card card-primary card-outline">
			<div class="modal-header">
			  <h3 class="card-title">
				<i class="fas fa-edit"></i>
				Pago Facturas
			  </h3>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body">
			  <div class="row">


				<div class="col-lg-12 col-md-12 col-sm-12">
				  <div class="form-group">
					
					<div id="nummonto"></div>
					
				  </div>
				</div>

				<div class="col-lg-12 col-md-12 col-sm-12">
				  <div class="form-group">
					<h6>Numero Factura:</h6>
	
	<input name="txt_numero_factura" id="txt_numero_factura" type="text" class="form-control uk-input"  />
	<input name="costotal" id="costotal" type="hidden" class="form-control uk-input"  />
				
				  </div>
				</div>
				
				<div class="col-lg-12 col-md-12 col-sm-12">
				  <div class="form-group">
					<h6>Observacion:</h6>
	
	<textarea name="txt_obs_factura" rows="3" class="form-control text-left " id="txt_obs_factura" autocomplete="off" data-mask="" placeholder="Datos Adicionales" maxlength="300"></textarea>

				
				  </div>
				</div>
				
					<div class="modal-footer col-sm-12 uk-text-center">

	<button type="button" class="btn btn-outline-info btn-block btn-flat btn_guardar_facturar"><i class="fas fa-save"></i>Guarda Factura</button>
	
					</div>
				 
			  </div>
			</div>

		  </div>
		  
		</div>
	</div>

</div>



<!-- MODAL PARA REALIZAR EL PAGO-->
<div class="modal fade" id="modal_detalles_productos" data-backdrop="static" data-keyboard="true" style="overflow-y: scroll;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="card card-primary card-outline">
			<div class="modal-header">
			  <h3 class="card-title">
				<i class="fas fa-edit"></i>
				Pago Facturas
			  </h3>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body">
			  <div class="row">

				  <div class="col-sm-12 col-md-12 col-lg-12">
                  <div class="table-responsive demo-x content">

                    <div class="box-body">

                    

                      <table id="table_detalle_facturas" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                          <tr>
                            <th style="width:10px">#</th>
                            <th style="width:10px">Cliente/Compania</th>
                            <th style="width:70px">Detalle&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                            <th style="width:20px">Cantidad</th>
                            <th style="width:20px">Precio</th>
                            <th style="width:20px">&nbsp;&nbsp;</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th style="width:10px">#</th>
                            <th style="width:10px">Cliente/Compania</th>
                            <th style="width:70px">Detalle&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                            <th style="width:20px">Cantidad</th>
                            <th style="width:20px">Precio</th>
                            <th style="width:20px">&nbsp;&nbsp;</th>
                          </tr>
                        </tfoot>
                      </table>

                      

                    </div>
                  </div>
                  <p>
                 
                </div>
				

			  </div>
			</div>

		  </div>
		  
		</div>
	</div>

</div>



<!-- MODAL PARA REALIZAR EL PAGO-->
<div class="modal fade" id="modal_cambio_precio">
	<div class="modal-dialog modal-xs">
		<div class="modal-content">
		  <div class="card card-primary card-outline">
			<div class="modal-header">
			  <h3 class="card-title">
				<i class="fas fa-edit"></i>
				Actualizar Costo
			  </h3>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body">
			  <div class="row">


				
				<div class="col-lg-12 col-md-12 col-sm-12">
				  <div class="form-group">
					<h6>Costo:</h6>
	
	<input name="txtprecio" id="txtprecio" type="text" class="form-control uk-input"  />
	<input name="txtid_detalle" id="txtid_detalle" type="hidden" class="form-control uk-input"  />
	<input name="txtcantidad" id="txtcantidad" type="hidden" class="form-control uk-input"  />
	<input name="txtpreciotemp" id="txtpreciotemp" type="hidden" class="form-control uk-input"  />
	<input name="txtid_factura" id="txtid_factura" type="hidden" class="form-control uk-input"  />
				
				  </div>
				</div>
				
				
					<div class="modal-footer col-sm-12 uk-text-center">

	<button type="button" class="btn btn-outline-info btn-block btn-flat btn_cambiar_costo"><i class="fas fa-save"></i>Cambiar Costo</button>
	
					</div>
				 
			

			  </div>
			</div>

		  </div>
		  
		</div>
	</div>

</div>




<!-- MODAL MODIFICAR EMPLEADOS-->
<div class="modal fade" id="modal_edit_empleados" data-backdrop="static" data-keyboard="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="card card-primary card-outline">
			<div class="modal-header">
				<h3 class="card-title">
					<i class="fas fa-edit"></i>
					Editar Evaluador
				</h3>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body">
				
				<div class="row">
           
			<div class="col-lg-4 col-ms-12 col-xs-12">

					<div class="col-sm-12 col-md-12 col-lg-12">
                      <div class="form-group">
                        <h6>Nombre <span style="color:#ff0000;">*</span></h6>
	<input type="text" class="form-control" id="nombreedi"  name="nombreedi"  autocomplete="off"  autofocus required placeholder="Ingrese el nombre del empleado" >

                      </div>
                    </div>
					
			</div>


      <div class="col-lg-4 col-ms-12 col-xs-12">

<div class="col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
            <h6>Cédula <span style="color:#ff0000;">*</span></h6>
	<input type="text" class="form-control" id="cedulaedi"  name="cedulaedi"  autofocus required placeholder="Ingrese la cédula" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
            </div>
          </div>

</div>


<div class="col-lg-4 col-ms-12 col-xs-12">

<div class="col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
            <h6>Correo</h6>
	<input type="text" class="form-control" id="correo_edit"  name="correo_edit"  autofocus required placeholder="Ingrese el correo" >
            </div>
          </div>

</div>

<div class="col-lg-4 col-ms-12 col-xs-12">

<div class="col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
            <h6>Celular</h6>
	<input type="text" class="form-control" id="celular_edit"  name="celular_edit"  autofocus required placeholder="Ingrese un número telefónico..." oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
            </div>
          </div>

</div>

<div class="col-sm-12 col-md-12 col-lg-3">
												  <div class="form-group">
													<h6>Zona</h6>
													<select name="evaluadorzona_edit" id="evaluadorzona_edit" type="text" class="form-control uk-select">
													</select>
												  </div>
												</div>
			
                        </div>
                        

                        <hr>
									<h3>Datos Bancarios</h3>	
										
									<div class="col-lg-12 col-ms-12 col-xs-12">
											<div class="row">	
												
												<div class="col-sm-12 col-md-12 col-lg-4">
												  <div class="form-group">
													<h6>Banco</h6>
														<select class="form-control"  id="banco_edit"  name="banco_edit" >
														</select> 
												  </div>
												</div>

                        <div class="col-sm-12 col-md-12 col-lg-4">
												  <div class="form-group">
													<h6>Tipo de Cuenta</h6>
														<select class="form-control"  id="tipocuenta_edit"  name="tipocuenta_edit" >
															<option>Ahorros</option>
															<option>Corriente</option>
														</select> 
												  </div>
												</div>

												
												
												 <div class="col-sm-6 col-md-6 col-lg-2">
													<div class="form-group">
													  <h6>Número Cuenta:</h6>
													   <div class="input-group date" id="reservationdate1" data-target-input="nearest">
														<input type="text" id="numcuenta_edit" name="numcuenta_edit" class="form-control" >
													  </div>
													</div>
												</div>

												<div class="col-sm-12 col-md-12 col-lg-4">
													<div class="form-group">
													  <h6>Titular:</h6>
													   <div class="input-group date" id="reservationdate1" data-target-input="nearest">
														<input type="text" id="titular_edit" name="titular_edit" class="form-control" >
													  </div>
													</div>
												</div>

												<div class="col-sm-6 col-md-6 col-lg-2">
													<div class="form-group">
													  <h6>Cédula Titular:</h6>
													   <div class="input-group date" id="reservationdate1" data-target-input="nearest">
														<input type="text" id="cedulatitular_edit" name="cedulatitular_edit" class="form-control" >
													  </div>
													</div>
												</div>
												
											</div>
										</div>                        

			
			
			<div class="col-lg-4 col-ms-12 col-xs-12">
				
				   <div class="col-sm-12 col-md-12 col-lg-12">
                      <br>
						<button  type="button" class="btn btn-lg btn-info btn-block actualizar_empleado">
							<span id="payment-button-amount">Actualizar evaluador</span>                                                    
						</button>
	
							<input type="hidden" class="form-control" id="idemple"  name="idemple"	>		  
                    </div>
			</div>	
            
		</div>
				
			  
			</div>

		  </div>
		  
		</div>
	</div>


<!-- MODAL VER HISTORIAL EMPLEADOS-->
	<div class="modal fade" id="modal_historial" data-backdrop="static" data-keyboard="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
			  <div class="card card-primary card-outline">
				<div class="modal-header">
					<h3 class="card-title">
						<i class="fas fa-edit"></i>
						Ver  Historial
					</h3>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>
				
					<div class="modal-body">
						<div class="row">
           
							<div class="col-lg-12 col-ms-12 col-xs-12">
								<div class="box-body">

										<table id="table_historial" class="table table-striped table-bordered text-rigth ">
												<thead>
												  <tr>
													<td style="width:40px">#</td>
													<td style="width:30px">Hacienda</td>
													<td style="width:20px;">Feha Registro</td>
													<td style="width:20px;">Asegurado</td>
													<td style="width:120px">Estatus</td>
												  </tr>
												</thead>
												<tbody>
												</tbody>
										</table>
											
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	
	
<!-- MODAL CAMBIAR HISTORIAL EMPLEADOS-->
	<div class="modal fade" id="modal_cambiahistorial" data-backdrop="static" data-keyboard="true">
		<div class="modal-dialog modal-ms">
			<div class="modal-content">
			  <div class="card card-primary card-outline">
				<div class="modal-header">
					<h3 class="card-title">
						<i class="fas fa-edit"></i>
						Cambiar  Historial
					</h3>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>
				
					<div class="modal-body">
						<div class="row">
           			
					<div class="col-sm-12 col-md-12 col-lg-12">
                      <div class="form-group">
                        <h6>Hacienda :</h6>
							<select name="haciendaedi" id="haciendaedi" type="text" class="form-control uk-select">
							</select>
                      </div>
                    </div>
					
			
						<div class="col-sm-12 col-md-12 col-lg-12">
						  <div class="form-group">
							<h6>Sector :</h6>
								<select id="sectoredi" name="sectoredi" class="form-control" >
									<option value='0'>Seleccione una opción</option>
								</select> 
						  </div>
						</div>	
						
						<div class="col-sm-12 col-md-12 col-lg-12">
						<br>
						<button  type="button" class="btn btn-lg btn-info btn-block actualizar_hacienda">
							<span id="payment-button-amount">Cambiar Hacienda</span>                                                    
						</button>
				  
                    </div>
							
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
<!-- FIN MODAL EMPLEADOS-->



		<!-- MODAL MODIFICAR TAREAS-->
	<!-- MODAL MODIFICAR TAREAS-->
	<div class="modal fade" id="modal_edit_tareas" data-backdrop="static" data-keyboard="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
			  <div class="card card-primary card-outline">
				<div class="modal-header">
					<h3 class="card-title">
						<i class="fas fa-edit"></i>
						Modificar Tareas
					</h3>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>
				
					<div class="modal-body">
						
						<div class="row">
           
			<div class="col-lg-12 col-ms-12 col-xs-12">
				<div class="row">
				
					<div class="col-sm-12 col-md-12 col-lg-4">
                      <div class="form-group">
                        <h6>Mayordomo</h6>
						
	<input type="text" class="form-control mayordomos limpiarmayor" id="mayordomoedito"  name="mayordomoedito"  autofocus  placeholder="Ingrese mayordomo">
	<input type="hidden" class= "form-control" id="txtidmayor" name="txtidmayor" value="0">
                      </div>
                    </div>
				
					
					<div class="col-sm-12 col-md-12 col-lg-4">
                      <div class="form-group">
                        <h6>Empleado<span style="color:#ff0000;">*</span></h6>
	<input type="text" class="form-control empleados limpiar" id="empleadoedi"  name="empleadoedi" data="" value=""
	placeholder="Ingrese la Empleado" data-input_type="autocomplete" >
	
	<input type="hidden" class= "form-control" id="txtidempledo" name="txtidempledo" value="0">
                      </div>
                    </div>
						
					<div class="col-sm-12 col-md-12 col-lg-4">
                      <div class="form-group">
                        <h6>Lote</h6>
		<input type="text" class="form-control" id="loteedi"  name="loteedi"  autofocus  placeholder="Ingrese el Lote" />
                      </div>
                    </div>
						
		
				</div>
			</div>
			
			
			<div class="col-lg-12 col-ms-12 col-xs-12">
				<div class="row">	
					
					
					<div class="col-sm-12 col-md-12 col-lg-4">
                   					  
						<div class="form-group">
                          <h6>Fecha<span style="color:#ff0000;">*</span></h6>
                         <div class="input-group date" id="reservationdateedi" data-target-input="nearest">
	<input type="text" id="fechaedi" name="fechaedi" class="form-control datetimepicker-input" data-target="#reservationdateedi" value="<?php echo  date('d-m-Y');?>"  />
                            <div class="input-group-append" data-target="#reservationdateedi" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                          </div>
                        </div>
					  
                    </div>
					
					
					<div class="col-sm-12 col-md-12 col-lg-4">
                      <div class="form-group">
                        <h6>Semana<span style="color:#ff0000;">*</span></h6>
		<input type="text" class="form-control" id="semanaedi"  name="semanaedi"  autofocus  placeholder="Ingrese el Semana" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                      </div>
                    </div>


                    <div class="col-sm-12 col-md-12 col-lg-4">
                      <div class="form-group">
                        <h6>Hacienda<span style="color:#ff0000;">*</span></h6>
							<select name="haciendaeditar" id="haciendaeditar" type="text" class="form-control uk-select">
								<option value="">-- Seleccionar --</option>
							</select>
                      </div>
                    </div>
					
					

                    <div class="col-sm-12 col-md-12 col-lg-4">
                      <div class="form-group">
                        <h6>Sector :</h6>
							<select id="sectoreditar" name="sectoreditar" class="form-control" >
								<option value='0'>Seleccione una opción</option>
							</select> 
                      </div>
                    </div>

                    <div class="col-sm-12 col-md-12 col-lg-4">
                      <div class="form-group">
                        <h6>Labor<span style="color:#ff0000;">*</span></h6>

	<input type="text" class="form-control labor limpiarlabo" id="laboredi"  name="laboredi"  autofocus  placeholder="Ingrese Labor">
	
	<input type="hidden" class= "form-control" id="idlaboredi" name="idlaboredi" value="0">
	<input type="hidden" class= "form-control" id="idtarea" name="idtarea" value="0">
                      </div>
                    </div>

                    <div class="col-sm-12 col-md-12 col-lg-4">
                      <div class="form-group">
                        <h6>Cantidad<span style="color:#ff0000;">*</span></h6>
		<input type="text" class="form-control" id="cantidadedi"  name="cantidadedi"  autofocus  placeholder="Ingrese la Cantidad" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                      </div>
                    </div>
						
					
					
				</div>
			</div>
		
			<div class="col-lg-12 col-ms-12 col-xs-12">
				<div class="row">	
					
						 <div class="col-sm-12 col-md-12 col-lg-4">
                      <div class="form-group">
                        <h6>Valor Unitario<span style="color:#ff0000;">*</span></h6>
		<input type="text" class="form-control" id="valor_labor"  name="valor_labor"  autofocus  placeholder="Ingrese la Cantidad" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                      </div>
                    </div>
					
					<div class="col-sm-12 col-md-12 col-lg-4">
                      <div class="form-group">
                        <h6>Adicionales</h6>
		<input type="text" class="form-control" id="adicionalesedi"  name="adicionalesedi"  autofocus  placeholder="Ingrese Adicionales">
                      </div>
                    </div>
					
					<div class="col-sm-12 col-md-12 col-lg-4">
                      <div class="form-group">
                        <h6>Observación<span style="color:#ff0000;">*</span></h6>
		<input type="text" class="form-control" id="txt_observacion"  name="txt_observacion"  autofocus/>
                      </div>
                    </div>
					
                    <div class="col-sm-12 col-md-12 col-lg-4">
                      <br>
						<button  type="button" class="btn btn-lg btn-info btn-block actualizar_tarea">
							<span id="payment-button-amount">Actualizar Tarea</span>                                                    
						</button>
					  
                    </div>
                   

				
				
				</div>
			</div>
			
				
			
			
		</div>
						
						
					</div>
				</div>
			</div>
		</div>
	</div>
	
	

<!-- FIN MODAL TAREAS-->


<!-- MODAL OPERACIONES-->
	<div class="modal fade" id="modal_operaciones" data-backdrop="static" data-keyboard="true">
		<div class="modal-dialog modal-ms">
			<div class="modal-content">
			  <div class="card card-primary card-outline">
				<div class="modal-header">
					<h3 class="card-title">
						<i class="fas fa-edit"></i>
					excel
					</h3>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>
				
					<div class="modal-body">
						<div class="row">
                        
                        
                       <div class="col-sm-12 col-md-12 col-lg-12">
						  <div class="form-group">
								<h6>Vapor</h6>
								
		<input type="text" class="form-control" autocomplete="off" placeholder="" id="txt_vapor"  name="txt_vapor"/>
	
						  </div>
						</div>


            <div class="col-sm-12 col-md-12 col-lg-12">
						  <div class="form-group">
								<h6>Contenedor</h6>
								
                <input type="text" class="form-control" autocomplete="off" placeholder="" id="txt_contenedor"  name="txt_contenedor"/>
	
						  </div>
						</div>


            
           			
						<div class="col-sm-12 col-md-12 col-lg-12">
						  <div class="form-group">
								<h6>Semana</h6>
								
		<input type="text" class="form-control" autocomplete="off" placeholder="" id="txtsemanaope"  name="txtsemanaope"  
	oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"
	min="1" step="1"  >
	
						  </div>
						</div>
					
					
						<div class="col-sm-12 col-md-12 col-lg-12" style="display:none;">
							  <div id="resultados">	 </div>
						 </div>
						
					
						
						<div class="col-sm-12 col-md-12 col-lg-12">
						<br>
						<button  type="button" class="btn btn-lg btn-info btn-block btnreporte">
							<span id="payment-button-amount">Generar Excel</span>  
						</button>
	
					
                    </div>
							
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- MODAL OPERACIONES-->
	<div class="modal fade" id="modal_edi_cab_cuadrilla" data-backdrop="static" data-keyboard="true">
		<div class="modal-dialog modal-ms">
			<div class="modal-content">
			  <div class="card card-primary card-outline">
				<div class="modal-header">
					<h3 class="card-title">
						<i class="fas fa-edit"></i>
					Cabecera cuadrilla
					</h3>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>
				
					<div class="modal-body">
						<div class="row">
                      
							
							<div class="col-sm-12 col-md-12 col-lg-6">
							  <div class="form-group">
								<h6>Hacienda :</h6>
									<select name="haciendacuadcua" id="haciendacuadcua" type="text" class="form-control uk-select">
										
									</select>
							  </div>
							</div>

							<div class="col-sm-12 col-md-12 col-lg-6">
							  <div class="form-group">
								<h6>Sector :</h6>
									<select id="sectorcuacua" name="sectorcuacua" class="form-control" >
										
									</select> 
							  </div>
							</div>	
								
							<div class="col-sm-12 col-md-12 col-lg-12">
								<div class="form-group">
									<h6>Capitan</h6>
					<input type="text" class="form-control capitan2 limpiar"   id="capitanpr"  name="capitanpr"/>
					<input type="hidden" class="form-control" id="capitanid"  name="capitanid"/>
								</div>
							</div>
							
							
							<div class="col-sm-12 col-md-12 col-lg-12">
                   					  
								<div class="form-group">
								  <h6>Fecha<span style="color:#ff0000;">*</span></h6>
								 <div class="input-group date" id="fechaed10" data-target-input="nearest" onChange='semana_fecha2()'>
										<input type="text" id="fechaed" name="fechaed" class="form-control datetimepicker-input" data-target="#fechaed10" value="<?php echo  date('d-m-Y');?>"  />
									<div class="input-group-append" data-target="#fechaed10" data-toggle="datetimepicker">
									  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
									</div>
								  </div>
								</div>
							  
							</div>
					
								
							<div class="col-sm-12 col-md-12 col-lg-6">
								<div class="form-group">
									<h6>Semana</h6>
					<input type="text" class="form-control" autocomplete="off" placeholder="" id="txtsemanasra"  name="txtsemanasra" readonly=""/>
								</div>
							</div>
							
							<div class="col-sm-12 col-md-12 col-lg-6">
							  <div class="form-group">
									<h6>Total Racimos</h6>
									
					<input type="text" class="form-control" autocomplete="off" placeholder="" id="totalracimospre"  name="totalracimospre"/>
		
							  </div>
							</div>
						
						<div class="col-sm-12 col-md-12 col-lg-12">
							<br>
							<button  type="button" class="btn btn-lg btn-info btn-block actualizar_cuadr ">
								<span id="payment-button-amount">Actualizar</span>  
			<input type="hidden" class="form-control" id="txtidcuadri"  name="txtidcuadri"  >
			
							</button>
						</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	

		
	<!-- MODAL OPERACIONES-->
	<div class="modal fade" id="modal_editar_cuadrilla" data-backdrop="static" data-keyboard="true">
		<div class="modal-dialog modal-ms">
			<div class="modal-content">
			  <div class="card card-primary card-outline">
				<div class="modal-header">
					<h3 class="card-title">
						<i class="fas fa-edit"></i>
					Detalle cuadrilla
					</h3>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>
				
					<div class="modal-body">
						<div class="row">

							<div class="col-sm-12 col-md-12 col-lg-12">
								<div class="form-group">
									<h6>Empleado</h6>
					<input type="text" class="form-control empleadosnot limpiar" autocomplete="off" placeholder="" id="empleadoedita"  name="empleadoedita"/>
								</div>
							</div>
							
							<div class="col-sm-12 col-md-12 col-lg-12">
							  <div class="form-group">
									<h6>Valor</h6>
					<input type="text" class="form-control" autocomplete="off" placeholder="" id="txtvaloredit"  name="txtvaloredit"/>
								</div>
							</div>
								
							<div class="col-sm-12 col-md-12 col-lg-12">
								<div class="form-group">
									<h6>Labor</h6>
									<select id="laboreditar" name="laboreditar" class="form-control" >
										
									</select> 

								</div>
							</div>
							
							
						<div class="col-sm-12 col-md-12 col-lg-12">
							<br>
							<button  type="button" class="btn btn-lg btn-info btn-block actualizar_hacienda ">
								<span id="payment-button-amount">Actualizar</span>  
			<input type="hidden" class="form-control" id="txtidempaque"  name="txtidempaque"  >
			<input type="hidden" class="form-control" id="txtidempledocau"  name="txtidempledocau"  >
			<input type="hidden" class="form-control" id="idlaboredicu"  name="idlaboredicu"  >
							</button>
						</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- MODAL SERVICIOS CLIENTE-->
<div class="modal fade" id="modal_servicios_clientes_trans">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="card card-primary card-outline">
        <div class="modal-header">
          <h3 class="card-title">
            <i class="fas fa-edit"></i>
            Servicios Clientes.
          </h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
		  
		  <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="form-group">
                <label for="txcar">Cliente:</label>
                <input name="txt_cliente_servicio_tr" id="txt_cliente_servicio_tr" type="text" class="form-control uk-input" readonly="true" />
                <span class="help-block"></span>
              </div>

            </div>
		  
		  <!-- FORMULARIO -->
                <div class="card-body">


                  <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="custom-content-below-home-tab-client" data-toggle="pill" href="#custom-content-below-home-client_tr" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Vinculados</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-content-below-profile-tab-client" data-toggle="pill" href="#custom-content-below-profile-client_tr" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Existentes</a>
                    </li>

                  </ul>



                  <div class="tab-content" id="custom-content-below-tabContent">

                    <div class="tab-pane fade show active" id="custom-content-below-home-client_tr" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                      <div class="col-md-12">

                        

                        <div id="monitor_cliente"></div>

                        <div class="step">
                          
						  <div class="col-xs-12">
							  <strong for="checkcaja">Seleccionar Todos</strong>
							  <input type="checkbox" id="checkegreso" />
							  <span class="help-block"></span>
							</div>

						<section class="col-md-12">
						  <table id="table_servicios_clientes_trans" class="table table-striped table-bordered text-rigth tabla_detalle_fp">
							<thead>
							  <tr>
								<td style="width:40px">#</td>
								<td style="width:80px">Modalidad</td>
								<td style="width:80px;">Servicio</td>
                              	<td style="width:80px">Detalle</td>
								<td style="width:80px">Unidad</td>
								<td style="width:120px"></td>
							  </tr>
							</thead>
							<tbody>
							</tbody>
						  </table>
						</section>
						  <div class="modal-footer col-sm-12 uk-text-center">

                                <button type="button" id="btn_cargar_servicio" class="btn btn-outline-info btn-block btn-flat"><i class="fas fa-save"></i> Crear Servicio</button>

                              </div>
						  
                        </div>

                      </div>

                    </div>
                    
                  
                  	<div class="tab-pane fade" id="custom-content-below-profile-client_tr" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">

                      <div class="card-body">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                          <div class="table-responsive demo-x content">

                            <div class="box-body">

                              <table id="table_detalle_servicios_creados_trans" class="table table-striped table-bordered text-rigth tabla_detalle_fp">
                                <thead>
                                  <tr>
                                    <td style="width:40px">#</td>
                                    <td style="width:40px">Fecha</td>
									<td style="width:20px">Semana</td>
									<td style="width:80px">Modalidad</td>
									<td style="width:80px">Servicio</td>
									<td style="width:80px">Contenedor</td>
									<td style="width:80px"></td>
                                  </tr>
                                </thead>
                                <tbody>
                                </tbody>
                              </table>
							  <div class="modal-footer col-sm-12 uk-text-center">

                                <button type="button" id="btn_cargar_servicio_exit" class="btn btn-outline-info btn-block btn-flat"><i class="fas fa-save"></i> Crear Servicio</button>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>

                  </div>



                </div>

                <!-- FIN FORMULARIO -->

            
            

          </div>
        </div>
       
      </div>
      <div class="card-footer">
        Servicios Clientes.
      </div>
    </div>
  </div>

</div>
<!-- MODAL SERVICIOS CLIENTE-->




<!-- MODAL DETALLE DE REQUERIMIENTO-->
<div class="modal fade" id="modal_detalle_req_trans">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="card card-primary card-outline">
        <div class="modal-header">
          <h3 class="card-title">
            <i class="fas fa-edit"></i>
            Detalle de servicios.
          </h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">

            


            <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="form-group">
                <label for="txcar">Cliente:</label>
                <input name="txt_cliente_requerimiento_trans" id="txt_cliente_requerimiento_trans" type="text" class="form-control uk-input" readonly="true" />
                <span class="help-block"></span>
              </div>
            </div>


            <section class="col-md-12">
              <div class="col-lg-12">
                <div class="card card-primary card-outline">
                  <div class="card-header">
                    <h5 class="m-0">Servicios</h5>
                  </div>
                  <div class="card-body">



                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <div class="table-responsive demo-x content">

                        <div class="box-body">
                          <table id="table_detalle_servicos_trans" class="table table-striped table-bordered text-rigth tabla_detalle_fp">
                            <thead>
                              <tr>
                                <td style="width:10px">#</td>
	<th style="width:40px">Fecha&nbsp;&nbsp;&nbsp;</th>
    <th style="width:40px">Semana&nbsp;&nbsp;&nbsp;</th>
	<th style="width:40px">Depósito&nbsp;&nbsp;&nbsp;</th>
	<th style="width:40px">Ciudad&nbsp;&nbsp;&nbsp;</th>
	<th style="width:40px">Fecha turno&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
	<th style="width:40px">Hora turno (24Hrs)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
	<th style="width:40px">Zona de finca&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
	<th style="width:40px">Fecha del proceso&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
	<th style="width:40px">Nombre de la finca&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
	<th style="width:40px">Marca de cajas&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
	<th style="width:40px">Cantidad de cajas&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
	<th style="width:40px">Puerto&nbsp;&nbsp;&nbsp;</th>
	<th style="width:40px">Ciudad&nbsp;&nbsp;&nbsp;</th>
	<th style="width:80px">Booking&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
	<th style="width:80px">Contenedor</th>
	<th style="width:80px">Transportista</th>
	<th style="width:80px">Placa</th>
	<th style="width:80px">Chofer</th>
	<th style="width:80px">Cedula</th>
	<th style="width:80px">Celular</th>
	<th style="width:80px">Generador</th>
    <th style="width:80px">Valor Gen.</th>
	<th style="width:80px">Servicio</th>
	<th style="width:80px">Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
	<th style="width:80px">Comision&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
	<th style="width:80px">Ubicacion</th>
                                
                                <td style="width:80px">Estatus</td>
                              </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>



          </div>
        </div>

      </div>
      <div class="card-footer">
        Detalle Servicios Clientes.
      </div>
    </div>
  </div>

</div>
<!-- MODAL SERVICIOS CLIENTE-->





<!-- MODAL EDITAR ORDEN MANTENIMIENTO -->
<div class="modal fade" id="modal_editar_orden">

  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form id="registro_equipos_edit2">
        <div class="card card-primary card-outline">
          <div class="modal-header">
            <h3 class="card-title">
              <i class="fas fa-edit"></i>
              Editar Requerimiento
            </h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>

<?php 
  $esono ='';
  $esonos ='';
?>
          </div>
          <div class="modal-body">
            <div class="form-group uk-text-center">

              <span style="color:#ff0000; font-size:12px;"> Todos los Campos Con (*) Son Obligatorios</span>

            </div>

            <div class="row">

              <!--  PRIMER DIV   -->
			  
			  <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                   <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Orden de Corte:<span style="color:#ff0000;">*</span> </label>
                        <input name="txt_id_edit" id="txt_id_edit" type="hidden" class="form-control uk-input" placeholder="Equipo..." />
                        <input name="txt_norden_edit" id="txt_norden_edit" type="text" class="form-control uk-input" placeholder="Equipo..." />
                        <span class="help-block"></span>
                      </div>
                    </div>


                  </div>
                </div>
              </section>
              <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <div class="form-group">
                        <label>Fecha:<span style="color:#ff0000;">*</span></label>
                        <div class="input-group date" id="reservationdate" data-target-input="nearest" >
                          <input type="date" id="txt_fecha_edit" name="txt_fecha_edit" class="form-control" value="<?php echo  date('d-m-Y');?>"  onchange="semana_fecha_edit()"/>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>

               <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <div class="form-group">
                        <label>Semana:<span style="color:#ff0000;">*</span></label>
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                          <input type="text" id="txt_semana_req_edit" readonly name="txt_semana_req_edit " class="form-control" />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </section>

              <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <div class="form-group">
                        <label>Semana Exportadora:<span style="color:#ff0000;">*</span></label>
                        <div class="input-group date" >
                          <input type="text" id="txt_semanaexpo_req_edit" name="txt_semanaexpo_req_edit" class="form-control" />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </section>

              <!--  TERCER DIV   -->
              <section class="col-md-6">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Cliente:</label><span style="color:#ff0000;">*</span>
                      <br>
                        <select name="txt_cliente_edit" id="txt_cliente_edit" type="text" style="width:100%; height:150%" class="form-control uk-select select_txtcli">
                        </select>
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
              <!--  TERCER DIV   -->



              <section class="col-md-6">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Productor:</label><span style="color:#ff0000;">*</span>
                        <select name="txt_productor_edit" id="txt_productor_edit" type="text" class="form-control uk-select">
                        </select>
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </section>



              <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Hacienda:</label><span style="color:#ff0000;">*</span>
                        <select name="txt_hacienda_edit" id="txt_hacienda_edit" type="text" class="form-control uk-select">
                        </select>
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </section>

              <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Zona:</label><span style="color:#ff0000;">*</span>
                        <select name="txt_zona_edit" id="txt_zona_edit" type="text" class="form-control uk-select">
                        </select>
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </section>

              <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Marca Caja:</label><span style="color:#ff0000;">*</span>
                        <select name="txt_marcacaja_edit" id="txt_marcacaja_edit" type="text" class="form-control uk-select">
                        </select>
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </section>


              <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Sticker:</label><span style="color:#ff0000;">*</span>
                        <input name="txt_sticker_edit" id="txt_sticker_edit" type="text" class="form-control uk-input" placeholder="..." />
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </section>

              <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="form-group">
                        <label for="txtcar">Peso:</label><span style="color:#ff0000;">*</span>
                        <input name="txt_peso_edit" id="txt_peso_edit" type="text" class="form-control uk-input" placeholder="..." />
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </section>

              <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">                      
                      <div class="form-group">
                        <label for="txtcar">Cupo:<span style="color:#ff0000;">*</span></label>
                        <input name="txt_cupo_edit" id="txt_cupo_edit" type="text" class="form-control uk-input" placeholder="..." />
                        <span class="help-block"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </section>

              <section class="col-md-3">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">                      
                      <div class="form-group">
                        <label for="txtcar">Tipo:<span style="color:#ff0000;">*</span></label>
                        <select name="txt_tipo_req_edit" id="txt_tipo_req_edit" type="text" class="form-control uk-select">
                          <option value="Contenedor">Contenedor</option>
                          <option value="Suelta">Suelta</option>
                          <option value="GRANEL CONTENERIZADA">GRANEL CONTENERIZADA</option>
                          <option value="PALETIZADO CTNER ORITO - ZUNCHO 5KL">PALETIZADO CTNER ORITO - ZUNCHO 5KL</option>
                          <option value="BJO CBTA 48 PALLET 106*124 ESQ.PLAST.220 PROTEC.32*50*1.5">BJO CBTA 48 PALLET 106*124 ESQ.PLAST.220 PROTEC.32*50*1.5</option>
                          <option value="GRANEL">GRANEL</option>
                          <option value="PALLETS 48 BJO CUBIERTA ESQ. PLAST 220 CM PROTEC 50*32*1.5">PALLETS 48 BJO CUBIERTA ESQ. PLAST 220 CM PROTEC 50*32*1.5</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </section>


              <section class="col-md-3" style="display: none;">
                <div class="box box-info">
                  <div class="box-body">
                    <div class="col-lg-12 col-md-12 col-sm-12">                      
                      <div class="form-group">
                        <label for="txtcar">Adjunto:</label>
                        <input type="file" id="txt_adjuntoreq_edit" class="form-control" name="txt_adjuntoreq_edit" >
                      </div>
                    </div>
                  </div>
                </div>
              </section>


            </div>


          </div>
          <div class="modal-footer justify-content-between">
<?php 
 if ($_SESSION["gb_perfil"]==7){ 
 } else {
?>
            <button type="button" id="btn_edit_orden" class="btn btn-outline-info btn-block btn-flat"><i class="fas fa-save"></i> Editar Requerimiento</button>
            <?php } ?>
          </div>
        </div>

      </form>

      <div class="card-footer">
        


      </div>
    </div>
  </div>

</div>
<!-- MODAL EDITAR ORDEN MANTENIMIENTO -->



<!--MODAL ASIGNACIÓN-->
<div class="modal fade" id="modal_asignacion_req">

  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form id="registro_equipos_edit1">
        <div class="card card-primary card-outline">
          <div class="modal-header">
            <h3 class="card-title">
              <i class="fas fa-edit"></i>
              Asignación al Requerimiento
            </h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>


          </div>
          <div class="modal-body">

                      <div class="col-md-12">
                        <div class="form-group uk-text-center">

                          <span style="color:#ff0000; font-size:12px;"> Todos los Campos Con (*) Son Obligatorios</span>

                        </div>
                        <div class="step">
                          <div class="row">
                            <div class="col-lg-12 col-ms-12 col-xs-12">
                              <div class="row">


                                <div class="col-sm-12 col-md-12 col-lg-5">
                                  <div class="form-group">
                                    <h6>Evaluador<span style="color:#ff0000;">*</span></h6>
                                    <input name="txt_id_req_asig" id="txt_id_req_asig" type="hidden" />
                                 <!--   <input type="text" class="form-control labor limpiar_mayordomo_rechazo" id="txt_mayordomo_rechazo" name="txt_mayordomo_rechazo" autofocus placeholder="">
-->
<select name="txt_evaluador_eva" id="txt_evaluador_eva" type="text" class="form-control uk-select">
                        </select>
                                  </div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-3">
                                  <div class="form-group">
                                    <h6>Tipo<span style="color:#ff0000;">*</span></h6>
                                    <select name="txt_tipo_eva" id="txt_tipo_eva" type="text" class="form-control uk-select">
                          <option value="">Seleccione una opción...</option>
                          <option value="Calidad">Calidad</option>
                          <option value="Gancho">Gancho</option>
                          <option value="Peso">Peso</option>
                          <option value="Foto">Foto</option>
                        </select>

                                  </div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-2">
                                  <div class="form-group">
                                    <h6>Encargado<span style="color:#ff0000;">*</span></h6>
                                    <select name="txt_encargado_eva" id="txt_encargado_eva" type="text" class="form-control uk-select">
                          <option value="">Seleccione...</option>
                          <option value="1">Si</option>
                          <option value="0">No</option>                          
                        </select>

                                  </div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-1">
                                  <br>
                                  <button type="button" class="btn  btn-info btn-ms add_racimos_rechazados">
                                    +
                                  </button>

                                </div>

                              </div>
                            </div>


                            <div class="col-lg-12 col-ms-12 col-xs-12">
                              <div class="row">

                                <div class="table-responsive demo-x content">
                                  <div class="box-body">

                                    <table id="table_racimos_rechazo" class="table table-striped table-bordered text-rigth ">
                                      <thead>
                                        <tr>
                                        <td style="width:10%">#</td>  
                                          <td style="width:20%">Evaluador</td>
                                          <td style="width:20%">Tipo</td>
                                          <td style="width:20%">Encargado</td>
                                          <td style="width:20%"></td>

                                        </tr>
                                      </thead>

                                      <tbody>


                                      </tbody>
                                    </table>



                                  </div>
                                </div>
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>
                    </div>


      

<button type="button" id="btn_asignacion_orden" class="btn btn-outline-info btn-block btn-flat"><i class="fas fa-save"></i> Crear Asignación</button>

          </div>


          <div class="col-lg-12 col-ms-12 col-xs-12">
                              <div class="row">

                                <div class="table-responsive demo-x content">
                                  <div class="box-body">
<h3 style="text-align:center">Asignaciones registradas</h3>
                                    <table id="table_racimos_rechazo_2" class="table table-striped table-bordered text-rigth ">
                                      <thead>
                                        <tr>
                                        <td style="width:10%">#</td>  
                                          <td style="width:20%">Evaluador</td>
                                          <td style="width:20%">Tipo</td>
                                          <td style="width:20%">Encargado</td>
                                          <td style="width:20%">Jornada Extra</td>
                                          <td style="width:20%">Multa</td>
                                          <td style="width:20%"></td>

                                        </tr>
                                      </thead>

                                      <tbody>


                                      </tbody>
                                    </table>



                                  </div>
                                </div>
                              </div>
                            </div>
          <div class="modal-footer justify-content-between">

            <button type="button" id="cerrarvista" class="btn btn-outline-secondary  btn-block btn-flat">Cerrar vista</button>
          </div>
        </div>

      </form>

      <div class="card-footer">
        


      </div>
    </div>
  </div>



<!--MODAL SELLOS-->
<div class="modal fade" id="modal_sellos_req">

  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form id="registro_equipos_edit1">
        <div class="card card-primary card-outline">
          <div class="modal-header">
            <h3 class="card-title">
              <i class="fas fa-edit"></i>
              Sellos del Requerimiento
            </h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>


          </div>
          <div class="modal-body">

                      <div class="col-md-12">
                        <div class="form-group uk-text-center">

                          <span style="color:#ff0000; font-size:12px;"> Todos los Campos Con (*) Son Obligatorios</span>

                        </div>
                        <div class="step">
                          <div class="row">
                            <div class="col-lg-12 col-ms-12 col-xs-12">
                              <div class="row">


                                <div class="col-sm-12 col-md-12 col-lg-2">
                                  <div class="form-group">
                                    <h6>Proveedor<span style="color:#ff0000;">*</span></h6>
                                    <input name="txt_id_req_sello" id="txt_id_req_sello" type="hidden" />
                                 <!--   <input type="text" class="form-control labor limpiar_mayordomo_rechazo" id="txt_mayordomo_rechazo" name="txt_mayordomo_rechazo" autofocus placeholder="">
-->
<select name="txt_proveedor_eva" id="txt_proveedor_eva" type="text" class="form-control uk-select">
<option value="">Seleccione...</option>
                            <option value="Patio">Patio</option>
                                <option value="Risk">Risk</option>
                            <option value="Naviera">Naviera</option>
                          <option value="Export">Export</option>
              </select>
                                  </div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-2">
                                  <div class="form-group">
                                    <h6>Proceso<span style="color:#ff0000;">*</span></h6>
                                    <select name="txt_proceso_eva" id="txt_proceso_eva" type="text" class="form-control uk-select">
                          <option value="">Seleccione...</option>
                          <option value="Llegada">Llegada</option>
                          <option value="Salida">Salida</option>
                        </select>

                                  </div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-2">
                                  <div class="form-group">
                                    <h6>Tipo<span style="color:#ff0000;">*</span></h6>
                                    <select name="txt_tipo_sello" id="txt_tipo_sello" type="text" class="form-control uk-select">
                          <option value="">Seleccione...</option>
                          <option value="Caja Satelital">Caja Satelital</option>
                          <option value="Botella">Botella</option>
                          <option value="Plástico">Plástico</option>
                          <option value="Cable">Cable</option>
                          <option value="Sticker">Sticker</option>
                        </select>
                                  </div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-2">
                                  <div class="form-group">
                                    <h6>Número<span style="color:#ff0000;">*</span></h6>
                                 <input type="text" class="form-control" id="txt_num_sello" name="txt_num_sello" placeholder="">
                                  </div>
                                </div>


                                <div class="col-sm-12 col-md-12 col-lg-1">
                                  <br>
                                  <button type="button" class="btn  btn-info btn-ms add_sellos_tbl">
                                    +
                                  </button>

                                </div>

                              </div>
                            </div>


                            <div class="col-lg-12 col-ms-12 col-xs-12">
                              <div class="row">

                                <div class="table-responsive demo-x content">
                                  <div class="box-body">

                                    <table id="table_sellos_tbl" class="table table-striped table-bordered text-rigth ">
                                      <thead>
                                        <tr>
                                        <td style="width:10%">#</td>  
                                          <td style="width:20%">Proveedor</td>
                                          <td style="width:20%">Proceso</td>
                                          <td style="width:15%">Número</td>
                                          <td style="width:15%">Tipo</td>
                                          <td style="width:20%"></td>

                                        </tr>
                                      </thead>

                                      <tbody>


                                      </tbody>
                                    </table>



                                  </div>
                                </div>
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>
                    </div>


      

<button type="button" id="btn_sellos_orden" class="btn btn-outline-info btn-block btn-flat"><i class="fas fa-save"></i> Crear Sellos</button>

          </div>


          <div class="col-lg-12 col-ms-12 col-xs-12">
                              <div class="row">

                                <div class="table-responsive demo-x content">
                                  <div class="box-body">
<h3 style="text-align:center">Sellos registrados</h3>
                                    <table id="table_sellos_tbl_2" class="table table-striped table-bordered text-rigth ">
                                      <thead>
                                        <tr>
                                        <td style="width:10%">#</td>  
                                        <td style="width:20%">Proveedor</td>
                                          <td style="width:20%">Proceso</td>
                                          <td style="width:15%">Número</td>
                                          <td style="width:15%">Tipo</td>
                                          <td style="width:20%"></td>

                                        </tr>
                                      </thead>

                                      <tbody>


                                      </tbody>
                                    </table>



                                  </div>
                                </div>
                              </div>
                            </div>
          <div class="modal-footer justify-content-between">

            <button type="button" id="cerrarvista_sello" class="btn btn-outline-secondary  btn-block btn-flat">Cerrar vista</button>
          </div>
        </div>

      </form>

      <div class="card-footer">
        


      </div>
    </div>
  </div>


</div>






<!--MODAL FOTOS-->
<div class="modal fade" id="modal_fotos_req">

  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form id="registro_fotos_req" action="#" enctype="multipart/form-data">
        <div class="card card-primary card-outline">
          <div class="modal-header">
            <h3 class="card-title">
              <i class="fas fa-edit"></i>
              Fotos al Requerimiento
            </h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>


          </div>
          <div class="modal-body">

                      <div class="col-md-12">
                        <div class="form-group uk-text-center">

                          <span style="color:#ff0000; font-size:12px;"> Todos los Campos Con (*) Son Obligatorios</span>

                        </div>
                        <div class="step">
                          <div class="row">
                            <div class="col-lg-12 col-ms-12 col-xs-12">
                              <div class="row">


                                <div class="col-sm-12 col-md-12 col-lg-6">
                                  <div class="form-group">
                                    <h6>Tipo de foto<span style="color:#ff0000;">*</span></h6>
                                    <input name="txt_id_req_foto" id="txt_id_req_foto" type="hidden" />
<select name="txt_tipofoto" id="txt_tipofoto" type="text" class="form-control uk-select">
                        </select>
                                  </div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-3">
                                  <div class="form-group">
                                    <h6>Foto<span style="color:#ff0000;">*</span></h6>
                                    <input name="image" multiple id="image" type="file" accept="image/*" class="form-control" />  
                                  </div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-1">
                                  <br>
                                  <button type="button" class="btn  btn-info btn-ms add_fotos_temp">
                                    +
                                  </button>

                                </div>

                              </div>
                            </div>


                            <div class="col-lg-12 col-ms-12 col-xs-12">
                              <div class="row">

                                <div class="table-responsive demo-x content">
                                  <div class="box-body">

                                    <table id="table_fotos" class="table table-striped table-bordered text-rigth ">
                                      <thead>
                                        <tr>
                                        <td style="width:10%">#</td>  
                                          <td style="width:20%">Tipo</td>
                                          <td style="width:20%">Foto</td>
                                          <td style="width:20%"></td>

                                        </tr>
                                      </thead>

                                      <tbody>


                                      </tbody>
                                    </table>



                                  </div>
                                </div>
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>
                    </div>


      

<button type="button" id="btn_foto_crear" class="btn btn-outline-info btn-block btn-flat"><i class="fas fa-save"></i> Crear Foto</button>

          </div>


          <div class="col-lg-12 col-ms-12 col-xs-12">
                              <div class="row">

                                <div class="table-responsive demo-x content">
                                  <div class="box-body">
<h3 style="text-align:center">Fotos registradas</h3>
                                    <table id="table_fotos_2" class="table table-striped table-bordered text-rigth ">
                                      <thead>
                                        <tr>
                                        <td style="width:10%">#</td>  
                                          <td style="width:20%">Tipo</td>
                                          <td style="width:20%">Foto</td>
                                          <td style="width:20%"></td>

                                        </tr>
                                      </thead>

                                      <tbody>


                                      </tbody>
                                    </table>



                                  </div>
                                </div>
                              </div>
                            </div>
          <div class="modal-footer justify-content-between">

            <button type="button" id="cerrarvistafoto" class="btn btn-outline-secondary  btn-block btn-flat">Cerrar vista</button>
          </div>
        </div>

      </form>

      <div class="card-footer">
        


      </div>
    </div>
  </div>







<!-- EVALUACION AL REQUERIMIENTO--->


  <div class="modal fade" id="modal_evaluacion_req">

  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form id="registro_equipos_edit">
        <div class="card card-primary card-outline">
          <div class="modal-header">
            <h3 class="card-title" id="numevaluacion">
              <i class="fas fa-edit"></i>
              Formulario de Evaluación 
            </h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>


          </div>
          <div class="modal-body">
<div class="card-body">
			<ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                <li class="nav-item">
	<a class="nav-link active" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Exportación</a>
                </li>
	
                <li class="nav-item">
	<a class="nav-link" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Proceso</a>
                </li>
  

				<li class="nav-item">
	<a class="nav-link " id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-zona" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Contenedor</a>
                </li>

				<li class="nav-item">
	<a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-cargo" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Suelta</a>
                </li>
                
                <li class="nav-item">
	<a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-transporte" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Transporte</a>
                </li>
                <li class="nav-item">
	<a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-observacion" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Observaciones</a>
                </li>
                
            </ul>
		
			<div class="tab-content" id="custom-content-below-tabContent">
			
				<!-- PROCESO DE EVALUACION -->
				<div class="tab-pane fade show" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
						<br>
						<div class="row">
						<div class="col-md-12 col-sm-12 col-lg-12">
						
						  <div class="card card-primary card-outline">
							<div class="card-header">
							  <h5 class="m-0">Proceso</h5>
							</div>
							<div class="card-body">
							  <div class="col-lg-12">
								
                <div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">
									<strong>Hora inicio</strong><span style="color:#ff0000;">*</span>
									<input type="time" class="form-control" id="txt_hinicio_proceso" autocomplete="off" oninput="this.value = this.value.toUpperCase()" />
								  </div>
								</div>
                <div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">
									<strong>Hora fin</strong><span style="color:#ff0000;">*</span>
									<input type="time" class="form-control" id="txt_hfin_proceso" autocomplete="off" oninput="this.value = this.value.toUpperCase()" />
								  </div>
								</div>

                <div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">
									<strong>Cant. cajas</strong><span style="color:#ff0000;">*</span>
									<input type="text"  class="form-control" id="txt_cant_cajas_proceso" autocomplete="off"  />
								  </div>
								</div>

                <div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">
									<strong>Cod. Trazabilidad</strong><span style="color:#ff0000;">*</span>
									<input type="text"  class="form-control" id="txt_cod_traz_proceso" autocomplete="off" oninput="this.value = this.value.toUpperCase()" />
								  </div>
								</div>

                <div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">
									<strong>Cod. MAGAP</strong><span style="color:#ff0000;">*</span>
									<input type="text"  class="form-control" id="txt_cod_mapag_proceso" autocomplete="off" oninput="this.value = this.value.toUpperCase()" />
								  </div>
								</div>
               
                <div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">
									<strong>Tarjeta de Embarque</strong><span style="color:#ff0000;">*</span>
									<input type="text"  class="form-control" id="txt_tarj_embarque_proceso" autocomplete="off" oninput="this.value = this.value.toUpperCase()" />
								  </div>
								</div>

                <div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">
									<strong>Hoja de Evaluación</strong><span style="color:#ff0000;">*</span>
									<input type="text"  class="form-control" id="txt_h_evaluacion_proceso" autocomplete="off" oninput="this.value = this.value.toUpperCase()" />
								  </div>
								</div>
                <div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">
									<strong>Calidad %</strong><span style="color:#ff0000;">*</span>
									<input type="text"  class="form-control" id="txt_calidad_proceso" autocomplete="off" oninput="this.value = this.value.toUpperCase()" />
								  </div>
								</div>

                <div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">
									<strong>Guía de Transporte</strong><span style="color:#ff0000;">*</span>
									<input type="text"  class="form-control" id="txt_guia_proceso" autocomplete="off" oninput="this.value = this.value.toUpperCase()" />
								  </div>
								</div>
                <div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">
									<strong>Guía remisión</strong><span style="color:#ff0000;">*</span>
									<input type="text"  class="form-control" id="txt_guiaremision_proceso" autocomplete="off" oninput="this.value = this.value.toUpperCase()" />
								  </div>
								</div>

                <div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">
									<strong>Calibración</strong><span style="color:#ff0000;">*</span>
									<input type="text"  class="form-control" id="txt_calibracion_proceso" autocomplete="off"  oninput="this.value = this.value.replace(/[^0-9.^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" />
								  </div>
								</div>
                <div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">
									<strong>Largo de Dedo</strong><span style="color:#ff0000;">*</span>
									<input type="text"  class="form-control" id="txt_largodedo_proceso" autocomplete="off"  oninput="this.value = this.value.replace(/[^0-9.^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" />
								  </div>
								</div>


								<div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">

									<br>
									<!--<div class="text-rihgt" id="create_dep">
		<button type="button" id="btn_save_deposito"  class="btn btn-outline-info btn-block btn-flat"><i class="fas fa-save"></i> Crear Productor</button>
									</div>-->
					<input type="hidden" class="form-control" id="txt_id_requerimiento_evaluacion" autocomplete="off" />				


	<!--								<div class="text-rihgt" id="editar_dep" style="display: none;">
	<button type="button" id="btn_editar_deposito"  class="btn btn-warning btn-ms btn-flat"><i class="fas fa-edit"></i> Editar Productor</button>
	<button type="button"  class="btn btn-danger btn-ms btn-flat btn_edit_cancelar"><i class="fas fa-edit"></i> Cancelar</button>
								
									
									</div>
-->
								  </div>
								</div>
							  </div>
							</div>
						  </div>
						</div>
						
					</div>
				</div>



        	<!-- CONTENEDOR  -->
			    <div class="tab-pane fade show " id="custom-content-below-zona" role="tabpanel" aria-labelledby="custom-content-below-profile">
					<br>
						<div class="row">
						<div class="col-md-12 col-sm-12 col-lg-12">
						
						  <div class="card card-primary card-outline">
							<div class="card-header">
							  <h5 class="m-0">Registro Contenedor</h5>
							</div>
							<div class="card-body">
							  <div class="col-lg-12">
							
								<div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">
									<strong>No. Contenedor</strong><span style="color:#ff0000;">*</span>
									<input type="text" class="form-control" id="txt_nocont_contenedor" autocomplete="off" />
								  </div>
								</div>
                <div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">
									<strong>Peso Tara</strong><span style="color:#ff0000;">*</span>
									<input type="text" class="form-control" id="txt_pesotara_contenedor" autocomplete="off" />
								  </div>
								</div>
                <div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">
									<strong>Hora llegada Contenedor</strong><span style="color:#ff0000;">*</span>
									<input type="datetime-local" class="form-control" id="txt_hllegada_contenedor" autocomplete="off" />
								  </div>
								</div>
                <div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">
									<strong>Hora salida Contenedor</strong><span style="color:#ff0000;">*</span>
									<input type="datetime-local" class="form-control" id="txt_hsalida_contenedor" autocomplete="off" />
								  </div>
								</div>
                <div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">
									<strong>Termógrafo</strong><span style="color:#ff0000;">*</span>
									<input type="text"  class="form-control" id="txt_termografo_proceso" autocomplete="off" oninput="this.value = this.value.toUpperCase()" />
								  </div>
								</div>


								<div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">

									<br>
								<!--	<div class="text-rihgt" id="btn_save_zonas">
	<button type="button" id="btn_save_zona"  class="btn btn-outline-info btn-block btn-flat"><i class="fas fa-save"></i> Crear Zona</button>
									</div>-->

								  </div>
								</div>
							  </div>
							</div>
						  </div>
						</div>
						
					</div>
			</div>


				<!-- EXPORTACION -->
				<div class="tab-pane fade show active" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile">
					<br>
						<div class="row">
						<div class="col-md-12 col-sm-12 col-lg-12">
						
						  <div class="card card-primary card-outline">
							<div class="card-header">
							  <h5 class="m-0">Exportación</h5>
							</div>
							<div class="card-body">
							  <div class="col-lg-12">
								
								<div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">
									<strong>Plan</strong><span style="color:#ff0000;">*</span>
									<input type="text" class="form-control" id="txt_plan_exportacion" autocomplete="off"  />
									<!--  		oninput="this.value = this.value.toUpperCase()" 		-->
								  </div>
								</div>

                		
								<div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">
									<strong>Vapor</strong><span style="color:#ff0000;">*</span>
									<input type="text" class="form-control" id="txt_vapor_exportacion" autocomplete="off"  />
									<!--  		oninput="this.value = this.value.toUpperCase()" 		-->
								  </div>
								</div>

                <div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">
									<strong>Booking</strong><span style="color:#ff0000;">*</span>
									<input type="text" class="form-control" id="txt_booking_exportacion" autocomplete="off"  />
									<!--  		oninput="this.value = this.value.toUpperCase()" 		-->
								  </div>
								</div>

							<!--<div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">
									<strong>Tipo de Embarque</strong><span style="color:#ff0000;">*</span>
									<select class="form-control uk-select" id="txt_tipoembarque_exportacion" required name="txt_tipoembarque">
                    <option>Contenedor</option>
                    <option>Suelto</option>
                                  </select>
								  </div>
								</div>-->

								<div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">
									<strong>Puerto Embarque</strong><span style="color:#ff0000;">*</span>
									<select class="form-control uk-select clase1" id="txt_puertoembarque_exportacion" required name="txt_zona_hacienda">
                                  </select>
								  </div>
								</div>
						

                <div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">
									<strong>Destino</strong><span style="color:#ff0000;">*</span>
									<input type="text" class="form-control" id="txt_destino_exportacion" autocomplete="off"  />
									<!--  		oninput="this.value = this.value.toUpperCase()" 		-->
								  </div>
								</div>

								
								<div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">

									<br>
									<!--<div class="text-rihgt" id="create_trasn">
	<button type="button" id="btn_save_export_req"  class="btn btn-outline-info btn-block btn-flat btn_evaluacion_req"><i class="fas fa-save"></i>Registrar/Actualizar Exportación</button>
									</div>-->

								  </div>
								</div>
							  </div>
							</div>
						  </div>
						</div>
						
			
					</div>
				</div>
			
			<!-- SUELTA -->
				<div class="tab-pane fade show " id="custom-content-below-cargo" role="tabpanel" aria-labelledby="custom-content-below-profile">
					<br>
						<div class="row">
						<div class="col-md-12 col-sm-12 col-lg-12">
						
						  <div class="card card-primary card-outline">
							<div class="card-header">
							  <h5 class="m-0">Suelta</h5>
							</div>
							<div class="card-body">
							  <div class="col-lg-12">
								<div class="col-sm-12 col-md-12 col-lg-12">
									  <div class="form-group">
										<strong>Consolidado </strong><span style="color:#ff0000;">*</span>
										<select class="form-control uk-select" id="txt_consolidado_suelta" required>
                      <option value="Sí">Sí</option>
                      <option value="No">No</option>
                    </select>
									  </div>
								  </div>
								  
								<div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">
									<strong>Contenedor</strong><span style="color:#ff0000;">*</span>
									<input type="text" class="form-control" id="txt_contenedor_suelta" autocomplete="off"  />
								  </div>
								</div>
								
								<div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">

									<br>
								<!--	<div class="text-rihgt" id="create_vehiculo">
	<button type="button" id="btn_save_vehiculo"  class="btn btn-outline-info btn-block btn-flat"><i class="fas fa-save"></i> Crear Marca Caja</button>
									</div>-->

								  </div>
								</div>
							  </div>
							</div>
						  </div>
						</div>
						
					</div>
				</div>
				
			<!-- TRANSPORTE -->
				<div class="tab-pane fade show " id="custom-content-below-transporte" role="tabpanel" aria-labelledby="custom-content-below-profile">
					<br>
						<div class="row">
						<div class="col-md-12 col-sm-12 col-lg-12">
						
						  <div class="card card-primary card-outline">
							<div class="card-header">
							  <h5 class="m-0">Transporte</h5>
							</div>
							<div class="card-body">
							  <div class="col-lg-12">
								
								<div class="col-sm-12 col-md-12 col-lg-12">
									  <div class="form-group">
										<strong>Nombre del Chofer </strong><span style="color:#ff0000;">*</span>
                    <input type="text" class="form-control" id="txt_nomchofer_transporte" autocomplete="off" />										
									  </div>
								  </div>

                  <div class="col-sm-12 col-md-12 col-lg-12">
									  <div class="form-group">
										<strong>Cédula </strong><span style="color:#ff0000;">*</span>
										<input type="text" class="form-control" id="txt_cedula_transporte" autocomplete="off" />										
									  </div>
								  </div>
                  <div class="col-sm-12 col-md-12 col-lg-12">
									  <div class="form-group">
										<strong>Teléfono </strong><span style="color:#ff0000;">*</span>
										<input type="text" class="form-control" id="txt_telefono_transporte" autocomplete="off" />										
									  </div>
								  </div>

                  <div class="col-sm-12 col-md-12 col-lg-12">
									  <div class="form-group">
										<strong>Placa</strong><span style="color:#ff0000;">*</span>
                    <input type="text" class="form-control" id="txt_placa_transporte" autocomplete="off" />										
									  </div>
								  </div>


                  <div class="col-sm-12 col-md-12 col-lg-12">
									  <div class="form-group">
										<strong>Hora salida Camión </strong><span style="color:#ff0000;">*</span>
										<input type="time" class="form-control" id="txt_hsalidacamion_transporte" autocomplete="off" />
										</select>
									  </div>
								  </div>
      
                  <div class="col-sm-12 col-md-12 col-lg-12">
									  <div class="form-group">
										<strong>Sello plástico Grafio</strong><span style="color:#ff0000;">*</span>
										<input type="text" class="form-control" id="txt_sellografio_transporte" autocomplete="off" />
										<!--oninput="this.value = this.value.toUpperCase()" -->
										</select>
									  </div>
								  </div>


								<div class="col-sm-12 col-md-12 col-lg-12">
								  <div class="form-group">

									<br>
									<!--<div class="text-rihgt" id="create_chofer">
	<button type="button" id="btn_save_chofer"  class="btn btn-outline-info btn-block btn-flat"><i class="fas fa-save"></i> Crear Foto</button>
									</div>						-->

								  </div>
								</div>
							  </div>
							</div>
						  </div>
						</div>
					</div>
			</div>


      <div class="tab-pane fade show " id="custom-content-below-observacion" role="tabpanel" aria-labelledby="custom-content-below-profile">
					<br>
						<div class="row">
						<div class="col-md-12 col-sm-12 col-lg-12">
						
						  <div class="card card-primary card-outline">
							<div class="card-header">
							  <h5 class="m-0">Observaciones</h5>
							</div>
							<div class="card-body">
							  <div class="col-lg-12">
								
								<div class="col-sm-12 col-md-12 col-lg-12">
									  <div class="form-group">
										<strong>Observaciones</strong>
                    <textarea type="text" cols="5" rows="5" class="form-control" id="txt_observaciones_evaluacion" ></textarea>
									  </div>
								  </div>

							  </div>
							</div>
						  </div>
						</div>
					</div>
			</div>

				
		
		
			</div>
        </div>
          </div>
                   <div class="modal-footer justify-content-between">

            <button type="button" class="btn btn-info btn-block btn-flat" id="btn_registrar_evaluacion"><i class="fas fa-edit"></i>Registrar Información</button>
          </div>
        </div>

      </form>

      <div class="card-footer">
        Evaluación del Requerimiento
      </div>
    </div>
  </div>

</div>







<!--MODAL FACTURACION-->
<div class="modal fade" id="modal_facturaciondetalle">

  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form id="registro_equipos_edit1">
        <div class="card card-primary card-outline">
          <div class="modal-header">
            <h3 class="card-title">
              <i class="fas fa-edit"></i>
              Detalle de Servicios para Facturación
            </h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>


          </div>
          <div class="modal-body">

                    </div>


          <div class="col-lg-12 col-ms-12 col-xs-12">
                              <div class="row">

                                <div class="table-responsive demo-x content">
                                  <div class="box-body">
<h3 style="text-align:center">Evaluadores registrados</h3>
                                    <table id="table_evafact" class="table table-striped table-bordered text-rigth ">
                                      <!--racimos_rechazo_2-->
                                      <thead>
                                        <tr>
                                        <td style="width:10%">#</td>  
                                          <td style="width:20%">Evaluador</td>
                                          <td style="width:20%">Fecha</td>
                                          <td style="width:20%">C Cajas</td>
                                          <td style="width:20%">Rol</td>
                                          <td style="width:20%">Servicio</td>
                                          <td style="width:20%">Extra</td>
                                          <td style="width:20%">$ Servicio</td>
                                          <td style="width:20%">$ Extra</td>
                                          <td style="width:20%">$ Total</td>
                                        </tr>
                                      </thead>

                                      <tbody>


                                      </tbody>
                                    </table>



                                  </div>
                                </div>
                              </div>
                            </div>
          <div class="modal-footer justify-content-between">

          <button type="button" id="btn_save_evaluadores_last"  class="btn btn-outline-info btn-block btn-flat btn_save_evaluadores_last">
            <i class="fas fa-save"></i>Registrar Información</button>
          </div>
        </div>

      </form>

      <div class="card-footer">
        


      </div>
    </div>
  </div>
</div>



<!-- MODAL DEFECTOS-->

<div class="modal fade" id="modal_defectos_req">

  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form id="registro_equipos_edit1">
        <div class="card card-primary card-outline">
          <div class="modal-header">
            <h3 class="card-title">
              <i id="cantidaddefectos" class="fas fa-edit">Ingreso de Defectos</i>
            </h3>

            


            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>


          </div>
          <div class="modal-body">
<form id="formElem" enctype="multipart/form-data" method="post" name="formElem">

                      <div class="col-md-12">


                 



                        <div class="form-group uk-text-center">

                          <span style="color:#ff0000; font-size:12px;"> Todos los Campos Con (*) Son Obligatorios - Ingreso de detalle</span>

                        </div>
                        <button type="button" class="btn  btn-info btn-ms add_detail">
                                    + Guardar
                                  </button>
                        <div class="step">
                          <div class="row">


                          <div class="col-sm-12 col-md-12 col-lg-2">
                                  <div class="form-group">
                                    <h6>PH<span style="color:#ff0000;">*</span></h6>
                                 <input type="text" class="form-control" id="txt_ph" name="txt_ph" autofocus placeholder=""  oninput="this.value = this.value.replace(/[^0-9.^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                                  </div>
                                </div>
            
                                <div class="col-sm-12 col-md-12 col-lg-2">
                                  <div class="form-group">
                                    <h6>Peso Bruto<span style="color:#ff0000;">*</span></h6>
                                 <input type="text" class="form-control" id="txt_pesobruto" name="txt_pesobruto" autofocus placeholder=""  oninput="this.value = this.value.replace(/[^0-9.^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                                  </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-2">
                                  <div class="form-group">
                                    <h6>Fila<span style="color:#ff0000;">*</span></h6>
                                 <input type="text" class="form-control" id="txt_fila" name="txt_fila" autofocus placeholder="" >
                                  </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-2">
                                  <div class="form-group">
                                    <h6>#Cluster<span style="color:#ff0000;">*</span></h6>
                                 <input type="text" class="form-control" id="txt_cluster" name="txt_cluster" autofocus placeholder=""  oninput="this.value = this.value.replace(/[^0-9.^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
                                  </div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-4">
                                <button type="button" class="btn  btn-info btn-ms add_new_detail">
                                  + Agregar Defecto
                                </button>

                              </div>


                                </div>
                              
                            

                            <div class="col-lg-12 col-ms-12 col-xs-12" id="clonpadre">
                              <div class="row" id="clon0">


                                <div class="col-sm-12 col-md-12 col-lg-2">
                                  <div class="form-group">
                                    <h6>Tipo Daño<span style="color:#ff0000;">*</span></h6>
                                    <input name="txt_id_req_sello" id="txt_id_req_sello" type="hidden" />
                       
<select name="txt_tipodano" onchange="cargar_daños(1)" id="txt_tipodano1" type="text" class="form-control uk-select">
<option value="">Seleccione...</option>
                          <option value="Calidad">Calidad</option>
                          <option value="Empaque">Empaque</option>
                          
                        </select>
                                  </div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-4">
                                  <div class="form-group">
                                    <h6>Daño<span style="color:#ff0000;">*</span></h6>
                                    <select name="txt_dano[]" id="txt_dano1" type="text" class="form-control uk-select">
                          <option value="">Seleccione...</option>
                        </select>

                                  </div>
                                </div>


                                <div class="col-sm-12 col-md-12 col-lg-2">
                                  <div class="form-group">
                                    <h6>Cantidad<span style="color:#ff0000;">*</span></h6>
                                 <input type="text" class="form-control" id="txt_cantidad_defecto1" name="txt_cantidad_defecto[]" placeholder="">
                                  </div>
                                </div>



                             
                            </div>

                          </div>
                        </div>
                      </div>
</form>


<div class="col-lg-12 col-ms-12 col-xs-12">
                              <div class="row">

                                <div class="table-responsive demo-x content">
                                  <div class="box-body">

                                    <table id="table_defectos" class="table table-striped table-bordered text-rigth ">
                                      <thead>
                                        <tr>
                                        <td style="width:10%">#</td>  
                                          <td style="width:20%">PH</td>
                                          <td style="width:20%">Peso Bruto</td>
                                          <td style="width:20%">Fila</td>
                                          <td style="width:20%"># Cluster</td>
                                          <td style="width:20%">Cantidad</td>
                                          <td style="width:20%"></td>

                                        </tr>
                                      </thead>

                                      <tbody>


                                      </tbody>
                                    </table>



                                  </div>
                                </div>
                              </div>
                            </div>



                    </div>
                   

      

<!--<button type="button" id="btn_sellos_orden" class="btn btn-outline-info btn-block btn-flat"><i class="fas fa-save"></i> Crear Sellos</button>
 -->
          </div>


        </div>

      </form>

      <div class="card-footer">
        


      </div>
    </div>
  </div>


</div>
