<div class="container">
    <div class="row headertitle" >
                <p>平台用户管理</p>
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
            <label for="exampleInputName2">Moodle平台</label>
            <select name="moodleid" class="form-control">
                @foreach($moodles as $moodle)
                <option value="{{ $moodle->id }}">{{ $moodle->moodlename }}</option>
                @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail2">登录名</label>
            <input type="text" name="username" class="form-control"  placeholder="登录名">
          </div>
          <div class="form-group">
                      <label for="exampleInputEmail2">姓名</label>
                      <input type="text" name="nickname" class="form-control" placeholder="姓名">
          </div>
          <div class="form-group">
                       <label for="exampleInputEmail2">手机号</label>
                       <input type="text" name="phone" class="form-control"  placeholder="手机号">
          </div>
          <button type="submit" class="btn btn-primary">查询</button>
            {{ Form::close() }}
    </div>


    <table class="table table-hover" >
      <thead style="text-align: center">
        <tr>
        <th>姓名</th>
        <th>登录名</th>
        <th>邮箱</th>
        <th>手机</th>


        </tr>
      </thead>
      <tbody>
      @foreach($users as $user)
        <tr>
            <td>{{ $user->lastname.$user->firstname }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ empty($user->phone1) ? $user->phone2 : $user->phone1 }}</td>



        </tr>
        @endforeach
      </tbody>
    </table>
<!-- Button trigger modal -->

</div>
