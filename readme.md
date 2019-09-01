## Basic Task List
 
[Basic Task List](https://github.com/laravel/quickstart-basic)</blockquote> をベースに作成しました。  
タスクの管理 アプリケーションです。  
このアプリケーションには、新しいタスクと現在のすべてのタスクのリストを追加するためのフォームがあり、  
また削除済みタスク(タスク終了後）の管理を行うこともできます。  
日々の作業にお使い頂けたら幸いです。  

ビューを視覚化できるように、基本的なBootstrap CSSスタイルが適用された完成したアプリケーションのスクリーンショットを次に示します。
<br>
<br>
<br>
<img width="600" alt="スクリーンショット 2019-09-01 2 45 32" src="https://user-images.githubusercontent.com/52533351/64067385-ab0b0c00-cc62-11e9-8fbf-4baf1c710ef1.png">      

 
## 機能

***タスク管理アプリ***
 
- **タスクの追加と削除**（デフォルトの機能をVueで実装しました。）
- **削除後のタスクの管理**（削除済タスクの検索、並び替え、履歴のリセット)
<br>
<br>

## 環境 

**以下の環境で検証しております。**

**OS**
- mac OS/Windows 10

**プラウザ**
- Safari 12.0.1/Google Chrome

**インストール**
- Laravel 5.8
- Composer 1.8
- Vue.js 2.5
- Npm 6.4
- Moment.js 2.24
- Vee-Validate.js 2.2
<br>
<br>

## インストール   


**Installing The Basic Task List**  


このBasic Task Listのソースコードをダウンロードしてローカルマシンで実行する場合は、  
Gitリポジトリのクローンを作成してインストールしてください。 


```
git clone https://github.com/Cafi5613/Basic-Task-List.git  

cd Basic-Task-List  
```
**Composerをインストール。**

`composer install`

**envファイルの作成**

```
cp .env.example .env  

php artisan key:generate  

php artisan config:clear
```   
**moment.jsのインストール（npm)**

`npm install vue-moment`   

**vee-validate.jsのインストール（npm)**

`npm install vee-validate -S`
<br>
<br>

## 起動

**vue.jsのビルド**

`npm run dev`

**laravelプロジェクトの起動**

```
＄ cd SampleProject  

＄ php artisan serveLaravel  

development server started: <http://127.0.0.1:8000>   

```
<br>

## 使い方 DEMO

1. タスク投稿と履歴の切り替え<br>

![swtchout](https://user-images.githubusercontent.com/52533351/64067341-10123200-cc62-11e9-8ff7-976023693c21.gif)



2. タスクの追加<br>
タスクの入力後　**＋Add Task** をクリック後 Current Task に追加される。

![demoout](https://user-images.githubusercontent.com/52533351/64066429-5eb8cf80-cc54-11e9-86cb-b52155b8183f.gif)

3. タスクの削除<br>
**Delete** ボタンをクリックすると Current Task から削除される。

![delout](https://user-images.githubusercontent.com/52533351/64066656-aa20ad00-cc57-11e9-8616-43cba38da483.gif)

4. 削除タスクの管理　並び替え<br>
**task time**  をクリックすると、五十音順、時間順に並び替えされる。
![del2out](https://user-images.githubusercontent.com/52533351/64066687-f10ea280-cc57-11e9-9a9a-1af5babec53f.gif)

5. 削除タスクの管理　検索　削除　日時、テキストで検索  
セレクション［**task time**］ を選択後 keyword 入力し
   **Seach Task** をクリック　一致した項目をDleted Task に表示　
![sech2](https://user-images.githubusercontent.com/52533351/64066820-8199b280-cc59-11e9-8e1a-a988bfb1fc9d.gif)

6. 削除タスクの管理　リセット<br>
リッセットボタンをクリック後、確認画面が表示され ok を選択後、履歴一覧のリセット
![reset2](https://user-images.githubusercontent.com/52533351/64067253-a3e2fe80-cc60-11e9-9515-2fb039f69586.gif)      

# その他

今後の拡張と課題

- タスクをプロジェクト化する。
- タスクプロジェク詳細管理機能を追加する。


# 著者

- &copy; ikegawa 


# 参考
- 資料<br>
[動かして学ぶ！Vue.js開発入門/森巧尚 著](https://www.shoeisha.co.jp/book/detail/9784798158921)</blockquote><br>
[Vue.js&Nuxt.js超入門/	掌田津耶乃 著](https://www.shuwasystem.co.jp/book/9784798056593.html)</blockquote><br>
- Laravelチュートリアル<br>
[quickstart](https://laravel.com/docs/5.2/quickstart)</blockquote>
