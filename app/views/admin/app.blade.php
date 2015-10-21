<div class="container">
    <div class="row headertitle" >
                <p>APP版本管理</p>
    </div>
    <div id="loading">
    	<div class="loading-length" style="width: 1903px;"></div>
    </div>
    <div class="row" style="height: 50px">
    @if(Session::has('message'))
        <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>

        @endif
    </div>



    <table class="table table-hover" >
      <thead style="text-align: center">
        <tr>
        <th>版本号</th>
        <th>保存路径（相对地址）</th>
        <th>客户端</th><th>设备</th>
        <th>最新版本</th>
        <th>操作</th>
        </tr>
      </thead>
      <tbody >
        @foreach($apps as $app )
            <tr>
                <td>{{ $app->appversion }}</td>
                <td>{{ $app->appfile }}</td>
                <td>{{ $app->apptype == 'student' ? '学生端' : "教师端"}}</td>
                <td>{{ $app->equipment == 'phone' ? '手机' : "平板"}}</td>
                <td>{{ $app->isonline == 1 ? "最新" : "已替换" }}</td>
                <td><a class="btn btn-danger" href="{{ URL::to('admin/delapp/'.$app->id) }}">删除</a>


                </td>


            </tr>
        @endforeach
      </tbody>
    </table>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  添加APP新版本
</button>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">添加APP新版本</h4>
                      </div>
                      <form method="POST" accept-charset="UTF-8" action="app" enctype="multipart/form-data">

                          <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                      <div class="modal-body" style="height: 250px">
                      <div class="row">
                         {{ Form::label('版本号',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                                <div class="col-md-8">
                                 {{ Form::text('appversion',null, array('class'=>'form-control ')) }}
                                </div>
                      </div>
                      <div class="row">
                        {{ Form::label('类型',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                           <div class="col-md-8">
                           {{ Form::select('apptype',array('teacher'=>'教师端','student'=>'学生端'), null ,array('class'=>'form-control ')) }}
                          </div>
                      </div>
                      <div class="row">
                         {{ Form::label('设备类型',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                         <div class="col-md-8">
                          {{ Form::select('equipment',array('phone'=>'手机','pad'=>'平板'), null ,array('class'=>'form-control ')) }}
                        </div>
                      </div>
                       <div class="row">
                       {{ Form::label('APP文件',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                                       <div class="col-md-8">
                                       <input type="file" name="appfile" class="form-control"/>
                                       </div>
                       </div>

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        {{ Form::submit('保存',array('class'=>"btn btn-primary")) }}
                      </div>
                        </form>

                    </div>
                  </div>
                </div>