<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Détails
                </h3>
                <div class="box-tools">
                    <div class="btn-group pull-right">
                        <a href="{{route('situation_journalier')}}" class="btn btn-primary btn-sm">
                            <i class="fa fa-arrow-circle-left"></i> &nbsp; Retour </a>
                    </div>
                </div>
            </div>

            <div class="form-horizontal">
                <div class="box-body">
                    <div class="fields-group">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Manager</label>
                            <div class="col-sm-8">
                                <div class="box box-solid box-default no-margin box-show">
                                    <div class="box-body">
                                        {{$situation->created_manager_name}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Hopital</label>
                            <div class="col-sm-8">
                                <div class="box box-solid box-default no-margin box-show">
                                    <div class="box-body">
                                        {{$situation->hospital->name}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Confirmés</label>
                            <div class="col-sm-8">
                                <div class="box box-solid box-default no-margin box-show">
                                    <div class="box-body">
                                        {{$situation->confirmed}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Hospitalisés</label>
                            <div class="col-sm-8">
                                <div class="box box-solid box-default no-margin box-show">
                                    <div class="box-body">
                                        {{$situation->sick}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Guéris</label>
                            <div class="col-sm-8">
                                <div class="box box-solid box-default no-margin box-show">
                                    <div class="box-body">
                                        {{$situation->healed}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Décès</label>
                            <div class="col-sm-8">
                                <div class="box box-solid box-default no-margin box-show">
                                    <div class="box-body">
                                        {{$situation->dead}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Lits avec mousse occupés:</label>
                            <div class="col-sm-8">
                                <div class="box box-solid box-default no-margin box-show">
                                    <div class="box-body">
                                        {{$situation->occupied_foam_beds}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Lits de réanimation occupés</label>
                            <div class="col-sm-8">
                                <div class="box box-solid box-default no-margin box-show">
                                    <div class="box-body">
                                        {{$situation->occupied_resuscitation_beds}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Respirateurs occupés</label>
                            <div class="col-sm-8">
                                <div class="box box-solid box-default no-margin box-show">
                                    <div class="box-body">
                                        {{$situation->occupied_respirators}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ventilateur de réanimation occupés</label>
                            <div class="col-sm-8">
                                <div class="box box-solid box-default no-margin box-show">
                                    <div class="box-body">
                                        {{$situation->resuscitation_ventilator}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Masques</label>
                            <div class="col-sm-8">
                                <div class="box box-solid box-default no-margin box-show">
                                    <div class="box-body">
                                        {{$situation->masks}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Equipement de protection individuelle</label>
                            <div class="col-sm-8">
                                <div class="box box-solid box-default no-margin box-show">
                                    <div class="box-body">
                                        {{$situation->individual_protection_equipment}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Oxygénérateur</label>
                            <div class="col-sm-8">
                                <div class="box box-solid box-default no-margin box-show">
                                    <div class="box-body">
                                        {{$situation->oxygenator}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Dépistage rapide</label>
                            <div class="col-sm-8">
                                <div class="box box-solid box-default no-margin box-show">
                                    <div class="box-body">
                                        {{$situation->rapid_screening}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Radiographie</label>
                            <div class="col-sm-8">
                                <div class="box box-solid box-default no-margin box-show">
                                    <div class="box-body">
                                        {{$situation->x_ray}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Automate Genexpert</label>
                            <div class="col-sm-8">
                                <div class="box box-solid box-default no-margin box-show">
                                    <div class="box-body">
                                        {{$situation->automate_genexpert}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Gel hydro alcoolique</label>
                            <div class="col-sm-8">
                                <div class="box box-solid box-default no-margin box-show">
                                    <div class="box-body">
                                        {{$situation->gel_hydro_alcoolique}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Check point</label>
                            <div class="col-sm-8">
                                <div class="box box-solid box-default no-margin box-show">
                                    <div class="box-body">
                                        {{$situation->check_point}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Chloroquine</label>
                            <div class="col-sm-8">
                                <div class="box box-solid box-default no-margin box-show">
                                    <div class="box-body">
                                        {{$situation->chloroquine}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Hydrochloroquine</label>
                            <div class="col-sm-8">
                                <div class="box box-solid box-default no-margin box-show">
                                    <div class="box-body">
                                        {{$situation->hydrochloroquine}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Azytromicine</label>
                            <div class="col-sm-8">
                                <div class="box box-solid box-default no-margin box-show">
                                    <div class="box-body">
                                        {{$situation->azytromicine}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Vitamince c</label>
                            <div class="col-sm-8">
                                <div class="box box-solid box-default no-margin box-show">
                                    <div class="box-body">
                                        {{$situation->Vitamince_c}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Date</label>
                            <div class="col-sm-8">
                                <div class="box box-solid box-default no-margin box-show">
                                    <div class="box-body">
                                        {{$situation->created_at}}
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
