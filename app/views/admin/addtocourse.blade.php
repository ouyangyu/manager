<div class="container">
    <div class="row headertitle" >
                <p>为<span style="color: #080808">{{ $data['course']->coursename }}</span>添加分部Moodle课程关联</p>
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
              {{ Form::open(array('url'=> 'admin/addtocourse', 'class'=> 'form-inline ')) }}
              <input type="hidden" name="courseid" value="{{ $data['course']->id }}">
          <div class="form-group">
            <label for="exampleInputName2">Moodle平台</label>
            <select name="moodleid" class="form-control">
                @foreach($data['moodles'] as $moodle)
                <option value="{{ $moodle->id }}" >{{ $moodle->moodlename }}</option>
                @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail2">课程名称</label>
            <input type="text" name="coursename" class="form-control" id="exampleInputEmail2" placeholder="课程名称">
          </div>
          <button type="submit" class="btn btn-primary">查询课程</button>
            {{ Form::close() }}
    </div>
    <table class="table table-hover" >
      <thead style="text-align: center">
        <tr>
        <th>Moodle平台</th>
        <th>课程名称</th>
        <th>课程封面</th>
        <th>操作</th>
        </tr>
      </thead>
      <tbody>
      @foreach($data['courses'] as $course)
        <tr>
            <td>{{ Moodle::find($course->moodleid)->moodlename }}</td>
                <td>{{ $course->coursename }}</td>
                <td><img src="{{ empty($course->courseimage) ? URL::asset('images/course.svg') : URL::asset($course->courseimage) }}" alt="" class="img-rounded"></td>
                <td>
                {{ Form::open(array('url'=> 'admin/relatecourse', 'class'=> 'form-horizontal ')) }}
                        {{ Form::input('hidden','bmoodleid',$course->moodleid) }}
                        {{ Form::input('hidden','bcourseid',$course->id) }}
                        {{ Form::input('hidden','mcourseid',$data['course']->id) }}
                        {{ Form::input('hidden','mmoodleid',$data['course']->moodleid) }}
                       @if(in_array($course->id,$data['relate']))
                            @if(in_array($course->id,$data['selfrelate']))
                            <button type="button" class="btn btn-danger ">
                                  已绑定
                            </button>
                            @else
                            <button type="button" class="btn btn-danger ">
                                    已绑定其他课程
                            </button>
                            @endif
                       @else
                        <button type="submit" class="btn btn-primary ">
                           绑定
                       </button>
                        @endif
                {{ Form::close() }}
                </td>
        </tr>
        @endforeach
      </tbody>
    </table>
<!-- Button trigger modal -->

</div>
