@extends('layouts.app')

@section('content')
     <div id="app" class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    New Task
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->

                    <!-- Form Error List -->
                    <!-- text Validate error 発生時表示-->
                    <div class="alert alert-danger" v-show="errors.has('text')">
                        <strong>Whoops! Something went wrong!</strong>
                        <br><br>
                        <ul>
                            <li>@{{ errors.first('text') }}</li>
                        </ul>
                    </div>
                  

                    <!-- New Task Form -->
                  
                        <!-- Task Name -->
                        <div class="form-group">
                            <label for="task-name" class="col-sm-3 control-label">Task</label>


                            <div class="col-sm-6">
                                <!-- validate(255字以内) required は入力時以外は、addtextが通らないので指定しない。 -->
                                <input type="text" v-model.trim="addtext" placeholder="To do" name="text" v-validate="'max:255'"  class="form-control">
                            </div>
                        </div>

                        <!-- Add Task Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <!-- タスクの追加 (addToDo) -->
                                <button v-on:click="addToDo" type="submit" class="btn btn-default" style="margin-top:10px;">
                                    <i class="fa fa-btn fa-plus">Add Task</i>
                                </button>
                            </div>
                        </div>
                    
                </div>
            </div>

            <!-- Current Tasks -->
            
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Current Tasks
                    </div>
                    
                    <div class="panel-body">
                        <table class="table table-striped task-table">
                            <thead>
                                <th>Task</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                                    <!--追加したToDoをforで回す -->
                                    <tr v-for="todo in todos">
                                        <td class="table-text">@{{todo.text}}</td>

                                        <!-- Task Delete Button (removeToDo)で削除-->
                                        <td>
                                                <button v-on:click="removeToDo(todo)" type="submit" class="btn btn-danger">
                                                    <i class="fa fa-btn fa-trash"></i>Delete
                                                </button>
                    
                                        </td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                   
             </div>
        </div>
    </div>


    <!-- JavaScripts -->
    <script>
        
        Vue.use(VeeValidate);
        //エラーメッセージ （コメントアウト外す->日本語に変更）
        //VeeValidate.Validator.localize('ja');
     


            new Vue({
                el: '#app',
                data: {
                    //入力フォームがaddtextに入る。
                    addtext:'',
                    // todos 追加要素の見込みがある為{}使用
                    todos: [
                        {text:'AM会議'},
                        {text:'見積書提出'}
                    ]
                },
            
                methods: {
                    //validateにエラーがない場合 todosへ追加後　addtextを空にする。その後、ローカルストレージに保存
                    addToDo: function() {
                        //注！！アロー関数(引数)=>{処理}
                        this.$validator.validateAll().then((result) => {
                        if (result) {
                        if (this.addtext) {
                            this.todos.push({ text:this.addtext});
                            this.addtext = '';
                            this.saveTodo();
                        }
                    }
                })
                    },
                    //todo で回した dodosを削除する。その後、ローカルストレージに保存
                    removeToDo: function(todo) {
                        this.todos.splice(this.todos.indexOf(todo),1);
                        this.saveTodo();
                        },
                    //localStorage に保存　（オブジェクトや配列はそのままJSONで扱えないので、stringifyでエンコードする。）
                    saveTodo: function(){
                        localStorage.setItem('todos', JSON.stringify(this.todos));
                    },
                    //localStorageから　ロードする。前回とは逆にJSONから、parseでデコードする。
                    loadTodo: function(){
                        this.todos = JSON.parse( localStorage.getItem('todos') );
                        if( !this.todos ){
                        this.todos = [];
                    } 
                }
            },
            //プラウザで開いた時にloadTodoしてロードするようにする。
            mounted: function(){
                    this.loadTodo();
                },

            })
        </script>
@endsection
