<h3>Requisición de servicio</h3>
<form method="POST" action="addOrder">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        General
                    </h2>
                </div>
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <h2 class="card-inside-title">Tipo de servicio</h2>
                                <div class="demo-checkbox">
                                    <input type="radio" id="moldes" value="moldes" name="service_type[]" />
                                    <label for="moldes">Moldes</label>
                                    <input type="radio" id="mantenimiento" value="mantenimiento" name="service_type[]" />
                                    <label for="mantenimiento">Mantenimiento</label>

                                </div>
                            </div>
                            <div class="form-group">
                                <h2 class="card-inside-title">Departamento solicitante</h2>
                                <div class="demo-checkbox">
                                    <input type="radio" id="procesos" value="procesos" name="department_req" />
                                    <label for="procesos">Procesos</label>
                                    <input type="radio" id="seguridad" value="seguridad" name="department_req" />
                                    <label for="seguridad">Seguridad</label>
                                    <input type="radio" id="calidad" value="calidad" name="department_req" />
                                    <label for="calidad">Calidad</label>
                                    <input type="radio" id="almacen" value="almacen" name="department_req"  />
                                    <label for="almacen">Almacen</label>
                                    <input type="radio" id="planeacion" value="planeacion" name="department_req" />
                                    <label for="planeacion">Planeación</label>
                                    <input type="radio" id="rh" value="rh" name="department_req" />
                                    <label for="rh">RH</label>
                                    <input type="radio" id="produccion" value="produccion" name="department_req" />
                                    <label for="produccion">Produccion</label>
                                    <input type="radio" id="it" value="it" name="department_req" />
                                    <label for="it">IT</label>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Datos del solicitante
                    </h2>
                </div>
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- Lado izquierdo -->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <h2 class="card-inside-title">Nombre</h2>
                                                <div class="form-line">
                                                    <input type="text" class="form-control" placeholder="Introduce tu Nombre" name="name_req" required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <h2 class="card-inside-title">Fecha</h2>
                                                <div class="form-line">
                                                    <input type="date" class="form-control" placeholder="Introduce fecha" name="date_req" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <h2 class="card-inside-title">Hora</h2>
                                                <div class="form-line">
                                                    <input type="time" class="form-control" placeholder="Introduce hora" name="hour_req" required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <h2 class="card-inside-title">Area</h2>
                                                <div class="form-line">
                                                    <input type="text" class="form-control" placeholder="Introduce tu Area" name="area_req" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <h2 class="card-inside-title">Turno</h2>
                                                <div class="form-line">
                                                    <input type="text" class="form-control" placeholder="Introduce tu Turno" name="shift_req" required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <!-- Lado derecho -->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <h2 class="card-inside-title">No. Maquina</h2>
                                                <div class="form-line">
                                                    <input type="text" class="form-control" placeholder="Introduce Maquina" name="machine_no" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <h2 class="card-inside-title">No Molde</h2>
                                                <div class="form-line">
                                                    <input type="text" class="form-control" placeholder="Introduce Molde" name="mold_id" required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <h2 class="card-inside-title">Tipo de maquina</h2>
                                            <div class="demo-checkbox">
                                                <input type="radio" id="inyeccion" value="inyeccion" name="machine_type_id[]" />
                                                <label for="inyeccion">Inyección</label>
                                                <input type="radio" id="HotStamping" value="hotstamping" name="machine_type_id[]" />
                                                <label for="HotStamping">Hot Stamping</label>
                                                <input type="radio" id="PadPrinting" value="padprinting" name="machine_type_id[]" />
                                                <label for="PadPrinting">Pad Printing</label>
                                                <input type="radio" id="HeatStaking" value="heatstaking" name="machine_type_id[]" />
                                                <label for="HeatStaking">Heat Staking</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <h2 class="card-inside-title">Sintoma / Problema / Servicio</h2>
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Introduce Sintoma / Problema / Servicio" name="symptom" />
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

    <button type="submit" class="btn bg-blue btn-block btn-lg waves-effect">Enviar</button>
</form>