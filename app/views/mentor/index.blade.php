<div class="container">
    <div class="row headertitle" >
                <p>Moodle辅导教师管理</p>
    </div>
    <div id="loading">
    	<div class="loading-length" style="width: 1903px;"></div>
    </div>
    <div class="row" style="height: 50px">
    @if(Session::has('message'))
        <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>

        @endif
    </div>
    <div class="row" style="text-align: center;margin-bottom: 20px">
              {{ Form::open(array('url'=> 'class/index', 'class'=> 'form-inline ')) }}
          <div class="form-group">
            <label for="exampleInputName2">Moodle平台</label>
            <select name="moodleid" class="form-control">
                @foreach($data['moodles'] as $moodle)
                <option value="{{ $moodle->id }}" selected="@if(isset($moodleid)){{ $moodleid == $moodle->id ? 'true':'false' }}@endif">{{ $moodle->moodlename }}</option>
                @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail2">登录名</label>
            <input type="text" name="teacher" class="form-control" id="exampleInputEmail2" placeholder="登录名">
          </div>
          <div class="form-group">
                      <label for="exampleInputEmail2">姓名</label>
                      <input type="text" name="name" class="form-control" id="exampleInputEmail2" placeholder="姓名">
          </div>
          <div class="form-group">
               <label for="exampleInputEmail2">手机</label>
               <input type="text" name="phone" class="form-control" id="exampleInputEmail2" placeholder="手机">
          </div>
          <button type="submit" class="btn btn-primary">查询</button>
            {{ Form::close() }}
    </div>


    <table class="table table-hover" >
      <thead style="text-align: center">
        <tr>
        <th>头像</th>
        <th>登录名</th>
        <th>姓名</th>
        <th>登录名</th>
        <th>邮箱</th>
        <th>手机</th>
        <th>专业</th>
        <th>性别</th>
        <th>民族</th>
        <th>身份</th>
        <th>学历</th>
        <th>籍贯</th>

        <th>操作</th>
        </tr>
      </thead>
      <tbody>
      @foreach($data['classes'] as $class)
        <tr>
                <td>{{ $class->name }}</td>
                <td>{{ $class->count }}</td>

                <td>

                        <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myModal_{{$class->id}}">
                          编辑
                        </button>
                        <a class="btn btn-primary" href="{{ URL::to('class/classstudent/'.$class->id.'/'.$class->moodleid) }}">学生管理</a>
                </td>
                <div class="modal fade" id="myModal_{{ $class->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                          <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="ModalLabel">编辑班级</h4>
                                      </div>
                                      {{ Form::open(array('url'=> 'class/update', 'class'=> 'form-horizontal ')) }}
                                      <div class="modal-body" style="height: 250px">
                                      <div class="row">
                                                  {{ FORM::label('Moodle平台',null ,array('class'=>'col-md-3  control-label')) }}
                                                  <div class="col-md-8">
                                                      <select name="moodleid" class="form-control">
                                                        @foreach($data['moodles'] as $moodle)
                                                           <option value="{{ $moodle->id }}">{{ $moodle->moodlename }}</option>
                                                        @endforeach
                                                       </select>
                                                  </div>

                                      </div>
                                      <div class="row">
                                         {{ FORM::label('班级名称',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                                                <div class="col-md-8">
                                                 {{ Form::text('classname',$class->name, array('class'=>'form-control ',  'placeholder'=>'班级名称')) }}
                                                 <input type="hidden" name="classid" value="{{ $class->id }}">
                                                </div>
                                      </div>
                                       <div class="row">
                                       {{ FORM::label('班级公告',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                                                       <div class="col-md-8">
                                                        {{ Form::text('classpublic',$class->public, array('class'=>'form-control ',  'placeholder'=>'班级公告')) }}

                                                       </div>
                                       </div>
                                       <div class="row">
                                              {{ FORM::label('班级备注',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                                                              <div class="col-md-8">
                                                               {{ Form::text('classdescribe',$class->describe, array('class'=>'form-control ',  'placeholder'=>'班级备注')) }}
                                                              </div>
                                       </div>

                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                        {{ Form::submit('保存',array('class'=>"btn btn-primary")) }}
                                      </div>
                                      {{ Form::close() }}
                                    </div>
                          </div>
                </div>

        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="row">
        <button  type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
            添加
        </button>
    </div>
<!-- Button trigger modal -->

</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="addModalClass">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addModalClass">添加辅导教师</h4>
      </div>
      {{ Form::open(array('url'=> 'class/add', 'class'=> 'form-horizontal ')) }}
      <div class="modal-body" style="height: 250px">
      <div class="row">
                  {{ FORM::label('Moodle平台',null ,array('class'=>'col-md-3  control-label')) }}
                  <div class="col-md-8">
                      <select name="moodleid" class="form-control">
                                            @foreach($data['moodles'] as $moodle)
                                            <option value="{{ $moodle->id }}">{{ $moodle->moodlename }}</option>
                                            @endforeach
                                        </select>
                  </div>

      </div>
      <div class="row">
         {{ FORM::label('班级名称',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                <div class="col-md-8">
                 {{ Form::text('name',null, array('class'=>'form-control ', 'id'=>'inputmoodlename', 'placeholder'=>'班级名称')) }}

                </div>
      </div>
       <div class="row">
       {{ FORM::label('班级公告',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                       <div class="col-md-8">
                        {{ Form::text('public',null, array('class'=>'form-control ', 'id'=>'inputmoodleurl', 'placeholder'=>'班级公告')) }}

                       </div>
       </div>
       <div class="row">
              {{ FORM::label('班级备注',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                              <div class="col-md-8">
                               {{ Form::text('describe',null, array('class'=>'form-control ', 'id'=>'inputmoodleurl', 'placeholder'=>'班级备注')) }}
                              </div>
       </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        {{ Form::submit('保存',array('class'=>"btn btn-primary")) }}
      </div>
      {{ Form::close() }}
    </div>
  </div>
</div>