<style>
.modal .row {
    margin-top: 8px;
}
</style>

<div class="container">
    <div class="row headertitle" >
                <p>Moodle班主任管理</p>
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
              {{ Form::open(array('url'=> 'headTeacher/index', 'class'=> 'form-inline ')) }}
          <div class="form-group">
            <label for="exampleInputName2">Moodle平台</label>
            <select id="selectid" name="moodleid" class="form-control">
                @foreach($data['moodles'] as $moodle)
                <option value="{{ $moodle->id }}" @if(isset($moodleid)){{ $moodleid == $moodle->id ? 'selected="true"':'' }}@endif>{{ $moodle->moodlename }}</option>
                @endforeach
            </select>
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
      @foreach($data['teachers'] as $teacher)
        <tr>
                <td><img src="{{ URL::asset($teacher->image) }}" alt="" class="img-circle" style="width: 30px;height: 30px"></td>
                <td>{{ $teacher->teacher }}</td>
                <td>{{ $teacher->name }}</td>
                <td>{{ $teacher->email }}</td>
                <td>{{ $teacher->phone }}</td>
                <td>{{ $teacher->major }}</td>
                <td>{{ $teacher->sex=='1' ? "男" : "女" }}</td>
                <td>{{ $teacher->nation }}</td>
                <td>{{ $teacher->identity }}</td>
                <td>{{ $teacher->education }}</td>
                <td>{{ $teacher->nativeplace }}</td>


                <td>
                        <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myModal_{{$teacher->id}}">
                          编辑
                        </button>
                        <div class="modal fade" id="myModal_{{ $teacher->id }}" tabindex="-1" role="dialog" aria-labelledby="addModalClass">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="addModalClass">编辑班主任</h4>
                              </div>
                            <form method="POST" accept-charset="UTF-8" action="update" enctype="multipart/form-data">
                                   <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                   <input type="hidden" name="id" value="{{ $teacher->id }}" />
                              <div class="modal-body" style="height: 550px">
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
                                       {{ FORM::label('头像',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                                              <div class="col-md-8">
                                                 <input type="file" name="image" class="form-control"/>
                                              </div>
                              </div>
                              <div class="row">
                                 {{ FORM::label('登录名',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                                        <div class="col-md-8">
                                         {{ Form::text('teacher',$teacher->teacher, array('class'=>'form-control ',  'placeholder'=>'登录名')) }}

                                        </div>
                              </div>
                              <div class="row">
                                       {{ FORM::label('Email',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                                              <div class="col-md-8">
                                               {{ Form::text('email',$teacher->email, array('class'=>'form-control ',  'placeholder'=>'邮箱')) }}

                                              </div>
                                    </div>
                               <div class="row">
                                              {{ FORM::label('手机',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                                                     <div class="col-md-8">
                                                      {{ Form::text('phone',$teacher->phone, array('class'=>'form-control ',  'placeholder'=>'手机号')) }}

                                                     </div>
                                </div>
                               <div class="row">
                               {{ FORM::label('姓名',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                                               <div class="col-md-8">
                                                {{ Form::text('name',$teacher->name, array('class'=>'form-control ',  'placeholder'=>'姓名')) }}

                                               </div>
                               </div>
                               <div class="row">
                                      {{ FORM::label('专业',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                                                      <div class="col-md-8">
                                                       {{ Form::text('major',$teacher->major, array('class'=>'form-control ', 'placeholder'=>'专业')) }}
                                                      </div>
                               </div>
                               <div class="row">
                                 {{ FORM::label('性别',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                                   <div class="col-md-8">
                                   <select name="sex" class="form-control">
                                        <option value="1" selected="{{ $teacher->sex == 1 ? 'true':'false' }}">男</option>
                                         <option value="0" selected="{{ $teacher->sex == 0 ? 'true':'false' }}">女</option>

                                     </select>
                                   </div>
                               </div>

                                <div class="row">
                                   {{ FORM::label('民族',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                                  <div class="col-md-8">
                                    {{ Form::text('nation',$teacher->nation, array('class'=>'form-control ', 'placeholder'=>'民族')) }}
                                     </div>
                                </div>
                                 <div class="row">
                                    {{ FORM::label('身份',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                                   <div class="col-md-8">
                                     {{ Form::text('identity',$teacher->identity, array('class'=>'form-control ', 'placeholder'=>'身份')) }}
                                      </div>
                                 </div>
                                <div class="row">
                                    {{ FORM::label('籍贯',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                                   <div class="col-md-8">
                                     {{ Form::text('nativeplace',$teacher->nativeplace, array('class'=>'form-control ', 'placeholder'=>'籍贯')) }}
                                      </div>
                                 </div>
                                <div class="row">
                                     {{ FORM::label('学历',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                                    <div class="col-md-8">
                                      {{ Form::text('education',$teacher->education, array('class'=>'form-control ', 'placeholder'=>'学历')) }}
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
                        <a class="btn btn-primary" href="{{ URL::to('headTeacher/class/'.$teacher->id.'/'.$teacher->moodleid) }}">关联班级</a>
                </td>


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
        <h4 class="modal-title" id="addModalClass">添加班主任</h4>
      </div>
    <form method="POST" accept-charset="UTF-8" action="{{ URL::to('headTeacher/add') }}" enctype="multipart/form-data">
           <input type="hidden" name="_token" value="{{ csrf_token() }}" />
           <input type="hidden" name="type" value="1" />
      <div class="modal-body" style="height: 550px">
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
               {{ FORM::label('头像',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                      <div class="col-md-8">
                         <input type="file" name="image" class="form-control"/>
                      </div>
      </div>
      <div class="row">
         {{ FORM::label('登录名',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                <div class="col-md-8">
                 {{ Form::text('teacher',null, array('class'=>'form-control ',  'placeholder'=>'登录名')) }}

                </div>
      </div>
      <div class="row">
               {{ FORM::label('Email',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                      <div class="col-md-8">
                       {{ Form::text('email',null, array('class'=>'form-control ',  'placeholder'=>'邮箱')) }}

                      </div>
            </div>
       <div class="row">
                      {{ FORM::label('手机',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                             <div class="col-md-8">
                              {{ Form::text('phone',null, array('class'=>'form-control ',  'placeholder'=>'手机号')) }}

                             </div>
        </div>
       <div class="row">
       {{ FORM::label('姓名',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                       <div class="col-md-8">
                        {{ Form::text('name',null, array('class'=>'form-control ',  'placeholder'=>'姓名')) }}

                       </div>
       </div>
       <div class="row">
              {{ FORM::label('专业',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
                              <div class="col-md-8">
                               {{ Form::text('major',null, array('class'=>'form-control ', 'placeholder'=>'专业')) }}
                              </div>
       </div>
       <div class="row">
         {{ FORM::label('性别',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
           <div class="col-md-8">
           <select name="sex" class="form-control">
                <option value="1">男</option>
                 <option value="0">女</option>

             </select>
           </div>
       </div>

        <div class="row">
           {{ FORM::label('民族',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
          <div class="col-md-8">
            {{ Form::text('nation',null, array('class'=>'form-control ', 'placeholder'=>'民族')) }}
             </div>
        </div>
         <div class="row">
            {{ FORM::label('身份',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
           <div class="col-md-8">
             {{ Form::text('identity',null, array('class'=>'form-control ', 'placeholder'=>'身份')) }}
              </div>
         </div>
        <div class="row">
            {{ FORM::label('籍贯',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
           <div class="col-md-8">
             {{ Form::text('nativeplace',null, array('class'=>'form-control ', 'placeholder'=>'籍贯')) }}
              </div>
         </div>
        <div class="row">
             {{ FORM::label('学历',null ,array('class'=>'col-md-2 col-md-offset-1 control-label')) }}
            <div class="col-md-8">
              {{ Form::text('education',null, array('class'=>'form-control ', 'placeholder'=>'学历')) }}
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
<script>
    $("#selectid").change(function(){
        var checkValue=$("#selectid").val();
        $(window.location).attr('href', '{{ URL::to('headTeacher/index') }}'+"/"+checkValue);
    } );
</script>