

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h4 class="card-title">Liste des données postées aujourd'hui</h4>
            </div>

            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Manager</th>
                            <th>Hopital</th>
                            <th>Confirmés</th>
                            <th>Hospitalisés</th>
                            <th>Guéris</th>
                            <th>Décès</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($situations as $data)
                            <td>{{$data->created_manager_name}}</td>
                            <td>{{$data->hospital->name}}</td>
                            <td>{{$data->confirmed}}</td>
                            <td>{{$data->sick}}</td>
                            <td>{{$data->healed}}</td>
                            <td>{{$data->dead}}</td>
                            <td>{{$data->created_at}}</td>
                            <td>
                            <a href="{{route('situation_journalier.show', ['situation' => $data->id])}}" class="btn btn-primary btn-sm">
                                <i class="fa fa-eye"></i> &nbsp; Voir plus </a>
                            </td>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="footer clearfix text-center">
                {{$situations->links()}}
            </div>
        </div>
    </div>

</div>
