<div class="container">
    <div class="row headertitle" >
                <p>Moodle辅导教师列表</p>
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
                <option value="{{ $moodle->id }}" @if(isset($moodleid)){{ $moodleid == $moodle->id ? 'selected="true"':'' }}@endif>{{ $moodle->moodlename }}</option>
                @endforeach
            </select>
          </div>

          <div class="form-group">
                      <label for="exampleInputEmail2">姓名</label>
                      <input type="text" name="name" class="form-control" id="exampleInputEmail2" placeholder="姓名">
          </div>

          <button type="submit" class="btn btn-primary">查询</button>
            {{ Form::close() }}
    </div>


    <table class="table table-hover" >
      <thead style="text-align: center">
        <tr>
        <th>Moodel平台名称</th>
        <th>姓名</th>
        <th>操作</th>
        </tr>
      </thead>
      <tbody>
      @foreach($data['teachers'] as $teacher)
        <tr>
        <td>{{ Moodle::find($teacher->moodleid,array('moodlename'))->moodlename }}</td>
        <td>{{ $teacher->teachername }}</td>

                <td>
                 <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myModal_{{$teacher->id}}">
                 查看关联课程列表
                  </button>
                  <div class="modal fade" id="myModal_{{$teacher->id}}" tabindex="-1" role="dialog" aria-labelledby="addModalClass">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="addModalClass">教师所教课程列表</h4>
                        </div>

                        <div class="modal-body" style="height: 250px">
                            <div class="row" style="height: 130px">
                                @foreach($teacher->courseids as $courseid)
                                    <div class="col-md-6">
                                        <p>{{ Course::find($courseid)->coursename }}</p>
                                    </div>
                                @endforeach
                            </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">确定</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>

        </tr>
        @endforeach
      </tbody>
    </table>
{{ $data['teachers']->links() }}
</div>
