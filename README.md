## ハッカソン202109

### ビルド

ディレクトリに移動して以下のコマンドを実行してください

```bash
docker-compose build --no-cache
docker-compose up -d
```

### 動作確認

ブラウザで `http://localhost` にアクセスして、正しく画面が表示されているか確認してください

###　　ログインについて

管理者ユーザー：岩村
メールアドレス：email1@email
パスワード：pass

一般ユーザー①：小谷
メールアドレス：email2@email
パスワード：pass

一般ユーザー②：信田
メールアドレス：email2@email
パスワード：pass

一般ユーザー③：のぶ
メールアドレス：email2@email
パスワード：pass

手順
1.ブラウザで `http://localhost` にアクセス,
2.各ユーザーの適当なメールアドレスとパスワードを入力
3.ログインボタンをクリック
4.ログイン完了

### 管理画面からのイベント登録について

手順
①管理者ユーザー（岩村）でログイン
②ヘッダーの管理者画面へのボタンをクリック
③イベント登録をクリック
④各欄に適当な語句を入力
⑤登録ボタンをクリック
⑥イベント登録完了

### ユーザー画面でイベント参加登録

手順
①サイトにログイン（管理者でも一般ユーザーでも構わない）
②参加したいイベントをクリック
③モーダルが出るので参加ボタンをクリック
④参加登録完了

### メール送信サンプルについて

メール送信
ブラウザで `http://localhost/mailtest.php` にアクセスしてください、テストメールが送信されます

メール受信
ブラウザで `http://localhost:8025/` にアクセスしてください、メールボックスが表示されます
