# Twitterでのエゴサーチを便利にしたかった
TwitterREST APIを用いた検索ツールです
https://shioharu.minibird.jp/twitter/

## エゴサーチ
みなさんはエゴサーチしますか？  
自分は音楽作ったときとかめっちゃします。  
![エゴサーチ](https://github.com/shioharugit/twitter/blob/master/img/image01.jpg)  
ところが作品を作るたび、検索したい項目が増えるので大変です。  
エゴサーチが気軽にできるようなツールがあればなーと思い、  
TwitterREST APIを使用して実現しようとしました。

## 実装
https://shioharu.minibird.jp/twitter/  
![実装](https://github.com/shioharugit/twitter/blob/master/img/image02.jpg)  

- 検索ワードをクッキーに1週間保存するので次回からはブラウザを開いただけで検索可能
- 半角スペースでOR検索対応
- 検索ワード -(ハイフン)検索ワードの結果から非表示にしたいワード　に対応

## 結果
- 通常だと検索範囲が過去1週間しか指定できない仕様の様子
- OR検索がしづらい
- 思いのほか検索精度が低い(?)

## 総評
- TwitterAPIを用いればエゴサが快適化すると思ったがそうでもなかった
- しかしながら検索範囲や検索の指定の仕方を熟考すれば会社や企業アカウントの評判を適切に拾えるのではないか

---
  
ここからエンジニア向け

## 導入方法、参考記事など

- 『Twitter API 登録 (アカウント申請方法) から承認されるまでの手順まとめ　※2019年8月時点の情報』
https://qiita.com/kngsym2018/items/2524d21455aac111cdee  
Twitterのアカウントを取得し、こちらの内容に沿ってTwitterのAPIを使用する申請を行います。  
英語での申請が必要です。以前は手動で許可していたようでめっちゃ時間が掛かったようですが、  
今は自動応答になったらしくすんなり申請が通りました。  

- 『TwistOAuth』  
https://github.com/mpyw-junks/TwistOAuth  
APIの申請が完了したら実際にAPIを使用するわけですが、コード書くのが大変なのでライブラリを使用します。  
Qiitaで有名なmpywさんのTwistOAuthを使います。  
使い方は簡単で、TwistOAuth.pharをrequireしてあげるだけでokです。  
curlを使用しているライブラリなので、phpにcurlを導入するする必要ありです。  
windos環境は導入が面倒なので注意。  

- 『Twitterの検索API & Twitterでの検索術』  
https://gist.github.com/cucmberium/e687e88565b6a9ca7039  
TwitterのAPIで使用できるパラメータがまとまっています。  

- 『Twitter公式/非公式クライアントのコンシューマキー』  
https://gist.github.com/uhfx/3922268  
過去1週間以上の検索を行うにはこちらのコンシューマキーの指定が必要なようです。  
しかしながらこちらを指定したとしても、認証エラーになってしまい過去1週間以上の範囲を検索できませんでした…
