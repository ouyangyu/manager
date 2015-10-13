<div class="container">
    <div class="row headertitle" >
                <p>辅学资源列表</p>

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
        <th>资源名称</th>
        <th>资源封面</th>
        <th>资源类型</th>

        <th>操作</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data['resources'] as $resource)
        <tr>
            <th>{{ $resource->resourcename }}</th>
            <td><img src="{{ empty($resource->resourceimage) ? URL::asset('images/course.svg') : URL::asset($resource->resourceimage) }}" alt="" class="img-rounded"></td>
            <th>{{ $resource->resourcetype }}</th>

            <th>
            <a class="btn btn-danger">删除</a>
            <a class="btn btn-primary" href="#">编辑</a>
            </th>
        </tr>
        @endforeach
      </tbody>
    </table>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  添加新资源
</button>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">新增辅学资源</h4>
      </div>
      <form method="POST" accept-charset="UTF-8" action="{{ URL::to('source/index') }}" enctype="multipart/form-data">

       <input type="hidden" name="_token" value="{{ csrf_token() }}" />
      <div class="modal-body" style="height: 400px">
      <div class="row">
         {{ Form::label('资源名称',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                <div class="col-md-8">
                 {{ Form::text('resourcename',null, array('class'=>'form-control ', 'placeholder'=>'资源名称')) }}

                </div>
      </div>
       <div class="row">
          {{ Form::label('资源封面',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                 <div class="col-md-8">
                     <input type="file" name="resourceimage" class="form-control"/>
                 </div>
       </div>
         <div class="row">
                {{ Form::label('资源类型',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                  <div class="col-md-8">
                    {{ Form::select('resourcetype', array('word'=>'word','ppt'=>'ppt','pdf'=>'pdf','mp4'=>'mp4'), null,array('class'=>'form-control ',  'placeholder'=>'资源类型')) }}
                  </div>
                </div>
            <div class="row">
                {{ Form::label('资源ID',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                                <div class="col-md-8">
                                 {{ Form::text('resourceid',null, array('class'=>'form-control ',  'placeholder'=>'资源类型')) }}
                                </div>
            </div>
            <div class="row">
               {{ Form::label('资源售卖',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                <div class="col-md-8">
                   {{ Form::text('resourceurl',null, array('class'=>'form-control ',  'placeholder'=>'资源类型')) }}
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