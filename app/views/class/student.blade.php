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
        <th><input type="checkbox" id="studentbox"></th>
        <th>姓名</th>
        <th>登录名</th>
        <th>邮箱</th>
        <th>手机</th>


        </tr>
      </thead>
      <tbody>
      @foreach($students as $user)
        <tr>
            <td><input name="addstudent" type="checkbox" value="{{ $user->id }}" ></td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
<!-- Button trigger modal -->
{{ $students->links() }}

 <div class="row">
    {{ Form::open(array('url'=>'class/student')) }}
       <input id="jsondata" type="hidden" name="studentids" value="" />
       <input id="jsondata" type="hidden" name="moodleid" value="{{ $students->first()->moodleid }}" />
       <input id="jsondata" type="hidden" name="classid" value="{{ $classid }}" />
       <button class="btn btn-primary" id="addtoclass" >添加到班级</button>
        <a  type="button" class="btn btn-danger" href="{{ URL::to('class/classstudent/'.$classid.'/'.$students->first()->moodleid) }}" >
             返回
        </a>
     {{ Form::close() }}

</div>
</div>
<script>
    $(function() {

           $("#studentbox").click(function() {
                var check = this.checked;
                 $("[name='addstudent']").each(function(){
                             //$(this).attr("checked",check);
                             $(this).prop("checked",check);
                  });

            });

            $("#addtoclass").click(function(){
                var value = new Array();
                                  $("[name='addstudent']").each(function(){
                                        if($(this).prop("checked")) {
                                             value.push($(this).attr('value'));
                                        }
                                  });
                $("#jsondata").val(value);
                $(this).submit();
            });

        });


</script>
