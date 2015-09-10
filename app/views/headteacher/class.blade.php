<div class="container">
    <div class="row headertitle" >
                <p>班主任关联班级管理</p>
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
        <th>moodle平台</th>
        <th>班级名称</th>
        <th>操作</th>
        </tr>
      </thead>
      <tbody>
      @foreach($data['classes'] as $class)
      {{ Form::open(array('url'=> 'headTeacher/class', 'class'=> 'form-horizontal ')) }}
        {{ Form::input('hidden','moodleid',$class->moodleid) }}
        {{ Form::input('hidden','classid',$class->id) }}
        {{ Form::input('hidden','teacherid',$data['teacherid']) }}
        <tr>
                <td>{{ $data['moodlename'] }}</td>
                <td>{{ $class->name }}</td>
                <td>
                @if(in_array($class->id,$data['inclass']))
                {{ Form::input('hidden','type','delete') }}
                <button type="submit" class="btn btn-danger ">
                          解绑
                 </button>
                 @else
                  {{ Form::input('hidden','type','add') }}
                 <button type="submit" class="btn btn-primary ">
                       绑定
                  </button>
                  @endif
                </td>
        </tr>
        {{ Form::close() }}
        @endforeach
      </tbody>
    </table>

<!-- Button trigger modal -->

</div>
