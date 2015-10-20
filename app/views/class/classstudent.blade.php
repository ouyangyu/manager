<div class="container">
    <div class="row headertitle" >
                <p>班级学生管理</p>
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
              {{ Form::open(array('url'=> 'admin/moodle', 'class'=> 'form-inline ')) }}

          <div class="form-group">
            <label for="exampleInputEmail2">登录名</label>
            <input type="text" name="username" class="form-control"  placeholder="登录名">
          </div>
          <div class="form-group">
                      <label for="exampleInputEmail2">姓名</label>
                      <input type="text" name="nickname" class="form-control" placeholder="姓名">
          </div>

          <button type="submit" class="btn btn-primary">查询</button>
            {{ Form::close() }}
    </div>


    <table class="table table-hover" >
      <thead style="text-align: center">
        <tr>
        <th><input type="checkbox" id="studentbox"></th>
        <th>姓名</th>
        <th>登录名</th>
        <th>邮箱</th>
        <th>手机</th>


        </tr>
      </thead>
      <tbody>
      @foreach($classstudent as $user)
        <tr>
            <td><input type="checkbox" value="{{ $user->id }}"></td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
<!-- Button trigger modal -->
{{ $classstudent->links() }}

 <div class="row">
       <a class="btn btn-primary" href="{{ URL::to('class/student/'.$classid.'/'.$moodleid) }}">添加学生</a>

        <button  type="button" class="btn btn-danger" >
             移出班级
        </button>
</div>
</div>
