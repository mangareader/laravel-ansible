@extends("master")
@section("title")Inventories - @parent @stop
@section("content")
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">Inventories</h3>

                <div class="box-tools">
                    <div class="input-group input-group-sm" style="width: 50px;">
                        <div class="input-group-btn">
                            <a href="{{route("inventories_add") }}" class="btn btn-default"
                               style="margin-right: 10px;border-radius: 3px;;">
                                <i class="fa fa-plus">Add</i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->


            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <th width="10%">#</th>
                        <th>Name</th>
                        <th width="14%">Date edited</th>
                        <th width="14%">Date created</th>
                        <th width="14%">Action</th>
                    </tr>

                    <?php $i = 1;?>
                    @foreach($invens as $inv)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $inv->name }}</td>
                            <td>{{ $inv->updated_at }}</td>
                            <td>{{ $inv->created_at }}</td>
                            <td>
                                <a href="{{ route("inventories_edit",["id"=>$inv->id]) }}"><i class="fa fa-pencil"></i>
                                </a>&nbsp;&nbsp;
                                <a href=""><i class="fa fa-trash-o"></i> </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">

            </div>
        </div>

    </div>
@endsection("content")
