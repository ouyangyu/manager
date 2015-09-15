<div class="container">
    <div class="row headertitle" >
                <p>总部moodle平台：<span style="color: #5e5e5e">{{ $data['course']->coursename }}</span>的课程关联</p>

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
        <th>Moodle名称</th>
        <th>课程名称</th>
        <th>操作</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data['relaCourse'] as $relate)
        <tr>
        <td>{{ Moodle::find($relate->bmoodleid)->moodlename }}</td>
        <td>{{ Course::find($relate->bcourseid)->coursename }}</td>
        <td>
            <a class="btn btn-danger" href="{{ URL::to('admin/deleterelate/'.$relate->id) }}">删除关联</a>
        </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <a class="btn-primary btn" href="{{ URL::to('admin/addtocourse/'.$data['course']->id) }}">添加分部课程关联</a>
</div>