<template>
  <div id="app" class="container">
    <div class="col-sm-offset-2 col-sm-8">

      <!-- クリック後　New Task 表示 -->
      <button @click="openDiv()" type="submit" class="btn title" style="background-color:#f5f5f5; margin-bottom: 2vh; color: black; border-color:#dcdcdc;">
        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> New Task
      </button>

      <!-- クリック後　Deleted task 表示 -->
      <button @click="closeDiv()" type="submit" class="btn title" style="margin-bottom: 2vh; background-color:#E0E0E0; color: black; border-color: #dcdcdc;">
        <i class="fa fa-btn fa-trash"></i>Deleted Task
      </button>

      <!-- New Task  -->
      <div class="panel panel-default" v-if="open==true">
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
              <li>{{ errors.first('text') }}</li>
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

      <!-- Seach task -->
      <div class="panel panel-default" v-if="open==false">
        <div class="panel-heading" style="background-color:#E0E0E0;">
          Seach Task
        </div>
        <div class="panel-body">

          <!-- Display Validation Errors -->

          <!-- Form Error List -->
          <!-- text Validate error 発生時表示-->
          <div class="alert alert-danger" v-show="errors.has('text')">
            <strong>Whoops! Something went wrong!</strong>
            <br><br>
            <ul>
              <li>{{ errors.first('text') }}</li>
            </ul>
          </div>

          <!-- SeachTask Form -->
          <!--   -->
          <div class="form-group">
            <label for="task-name" class="col-sm-3 control-label">Selection&nbsp;&nbsp;:&nbsp;&nbsp;
              <select name="selection" v-model.trim="selection" placeholder="keyword" @click="resetSeachText()">
                <option value="text">Task</option>
                <option value="time">Date</option>
              </select>
            </label>
            <div class="col-sm-6" style="margin-top: 2vh;">
              <!-- validate(255字以内) -->
              <!-- seachするkeywordを指定 -->
              <input type="text" v-if ="selection == 'text' " v-model.trim="seachText" placeholder="keyword" name="text" v-validate="'max:255'"  class="form-control">
              <input type="date" v-if ="selection == 'time' " v-model.trim="seachText" placeholder="keyword" name="text" v-validate="'max:255'"  class="form-control">
            </div>
          </div>

          <!-- Add Task Button -->
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
              <!-- seach の開始　... メソットがまだ作れていないので後から...取り合いずボタンだけ -->
              <button type="submit" class="btn btn-default" v-on:click="seachTodo" style="margin-top:10px;">
                <i class="fa fa-search" aria-hidden="true">Seach Task</i>
              </button>
            </div>
          </div>
        </div>
      </div>



      <!--Current Tasks -->
      <div class="panel panel-default" v-if="open==true">
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
                <td class="table-text">{{todo.text}}</td>

                <!-- Task Delete Button (rcleanToDo)で完了済のitemsに入れる-->
                <td>
                  <button v-on:click="cleanToDo(todo)" type="submit" class="btn btn-danger" style="float: right;">
                    <i class="fa fa-btn fa-trash"></i>Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Deleted Tasks -->
      <div class="panel panel-default" v-if="open==false">
        <div class="panel-heading" style="background-color:#E0E0E0;">
          Deleted task
        </div>
        <div class="panel-body">
          <table class="table table-striped task-table">
            <thead>
              <th @click="sortBy('text')" class="selection">Task</th>
              <th @click="sortBy('time')" class="selection">Time</th>
               <i class="fa fa-refresh" aria-hidden="true" style="float: right;" @click="resetCompTask"></i>
            </thead>
            <tbody>

              <!--追加したToDoをforで回す -->
              <tr v-for="item in sortedItems">
                <td class="table-text">{{item.text}}</td>
                <td class="table-text"><i class="fa fa-clock-o" aria-hidden="true"></i>{{item.time}}</td>

              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</template>

<style>
.title:hover{
  opacity: 0.7;
}

.selection:hover{
  cursor: pointer;
}

.selection:active{
  transform: translateY(0.1875em);
}

button:active{
  transform: translateY(0.1875em);
}

.fa-refresh:hover{
  opacity: 0.7;
  cursor: pointer;
}

.fa-refresh:active{
  transform: translateY(0.1875em);
}


</style>

<script>
  import moment from 'moment';
 
  export default {
    data: function() {
      return {
          //タスク履歴とタスク追加ページの表示切り替え
        open: true,
        //searchするカテゴリ
        selection: 'text',
        //searchする文字列
        keyword: '',
        //seachする
        seachText:'',
        //ソートするアイテム
        sort: {
          key: '',
          isAsc: false,
        },
        //入力フォームがaddtextに入る。
        addtext:'',
        // todos 追加要素の見込みがある為{}使用
        todos: [
          {text:'AM会議'},
          {text:'見積書提出'}
        ],
        compTask:[],
      }
    },
    computed: {
      sortedItems () {
        //サーチした物を一旦itemに入れる。
        var item= this.findBy(this.compTask, this.keyword, this.selection); 
          if (this.sort.key) {
            //クイックソートを使用して並び替え
            item.sort((a, b) => {
              a = a[this.sort.key]
              b = b[this.sort.key]
              return (a === b ? 0 : a > b ? 1 : -1) * (this.sort.isAsc ? 1 : -1)
            });
          }
        return item;
      }
    },
    methods: {
      //validateにエラーがない場合 todosへ追加後　addtextを空にする。その後、ローカルストレージに保存
      addToDo() {
        //注！！アロー関数(引数)=>{処理}
        this.$validator.validateAll().then((result) => {
          if (result) {
            if (this.addtext) {
              this.todos.push({ text:this.addtext});
              this.addtext = '';
              this.saveBy('todos',this.todos);
            }
          }
        })
      },
      seachTodo(){
        this.$validator.validateAll().then((result) => {
        if (result) {
          if(this.selection == 'time'){
            // input deteの中身が YYYY-MM-DD なので、YYYY/MM/DD に置換する！！正規表現
            this.keyword = this.seachText.replace(/-/g, '/');   
          }else{
            this.keyword = this.seachText;
          }
        }
        })
      },
      //todos 完了したタスクをitemsに配置する。                           
      cleanToDo(todo) {
        todo.time = moment(new Date).format('YYYY/MM/DD HH:mm');
        this.compTask.push(todo);
        this.todos.splice(this.todos.indexOf(todo),1);
        this.saveBy('compTask',this.compTask);
        this.saveBy('todos',this.todos);
      },
      //削除履歴のリセット　confirmがokなら削除
      resetCompTask(){
        if(window.confirm('履歴のリセットを行います')){
          localStorage.removeItem('compTask');
          this.loadCompTask();
        }
      },
      //検索ワードのSelectionが変更された時に日付検索にテキストの検索文字が入らないようにするため、切り替わる度にリセットする。
      resetSeachText(){
        this.seachText = '';
      },
      //表示の切り替え　(New Task)
      openDiv(){
        this.open = true ;
      },
      //表示の切り替え　(Delete Task)
      closeDiv(){
        this.open = false ;
      },
      //ソート機能
      sortBy(key) {
        this.sort.isAsc = this.sort.key === key ? !this.sort.isAsc : false;
        this.sort.key = key;
      },
      //検索機能
      findBy(list, value, column) {
        return list.filter((item) => {
        // 入力がない場合は全件表示
        return (item[column].indexOf(value) > -1  || value === '')
        })
      },
      //localStorage に保存　（オブジェクトや配列はそのままJSONで扱えないので、stringifyでエンコードする。）saveBy（保存名、保存するアイテム）
      saveBy(name,item){
        localStorage.setItem(name, JSON.stringify(item));
      },
      //localStorageから　ロードする。前回とは逆にJSONから、parseでデコードする。
      loadTodo(){
        this.todos = JSON.parse( localStorage.getItem('todos') );
          if( !this.todos ){
            this.todos = [];
          } 
        },
      loadCompTask(){
      this.compTask = JSON.parse( localStorage.getItem('compTask') );
        if( !this.compTask ){
          this.compTask = [];
        } 
      }
    },
    //プラウザで開いた時にloadして読み込むようにする。
    mounted(){
      this.loadTodo();
      this.loadCompTask();
    },
  }
</script>