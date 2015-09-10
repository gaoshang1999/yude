                 <input class="pull-left form-control" type="search" placeholder="用户名或手机号" name="name_phone" id="name_phone"  value="" style="width:400px;"/>
                 <button class="btn btn-primary pull-left" type="button"  id="user_search" onclick="javasctipt:userSearch()" >搜索</button>  
               
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>姓名</th>
                      <th>手机号</th>
                      <th>邮箱</th>
                      <th>类型</th>
                      <th>创建时间</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $user)
                    <tr>
                      <td><label><input type="radio" name="user" value="{{ $user->id }}"/>&nbsp;&nbsp;{{ $user->id }}</label></td>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->phone }}</td>
                      <td>{{ $user->email }}</td>
                      <td>{{ $user->role === 'admin' ? '管理员' : '学员' }}</td>
                      <td>{{ $user->created_at }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>