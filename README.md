# Twitterでのエゴサーチを便利にしたかった
TwitterREST APIを用いた検索ツールです
※2023年5月頃のTwitterのAPI仕様変更に伴い、現在は使用できません…
跡地として残しておきます。

## エゴサーチ
みなさんはエゴサーチしますか？  
自分は音楽作ったときとかめっちゃします。  
![エゴサーチ](https://github.com/shioharugit/twitter/blob/master/img/image01.jpg)  

## 問題点
ところが作品を作るたび、検索したい項目が増えるので大変です。  
エゴサーチが気軽にできるようなツールがあればなーと思い、  
TwitterREST APIを使用して実現しようとしました。

## 導入方法

- 『Twitter API 登録 (アカウント申請方法) から承認されるまでの手順まとめ　※2019年8月時点の情報』
https://qiita.com/kngsym2018/items/2524d21455aac111cdee  
Twitterのアカウントを取得し、こちらの内容に沿ってTwitterREST APIを使用する申請を行います。  
英語での申請が必要です。  
以前は公式が申請の許可を手動で行っていたようで申請後めっちゃ時間が掛かったようですが、  
今は自動応答になったらしくすんなり申請が通りました。  

- 『TwistOAuth』  
https://github.com/mpyw-junks/TwistOAuth  
APIの申請が完了したら実際にAPIを使用するわけですが、コード書くのが大変なのでライブラリを使用します。  
Qiitaで有名なmpywさんのTwistOAuthを使います。  
使い方は簡単で、ライブラリーをダウンロード後、TwistOAuth.pharをrequireしてあげるだけでokです。  
curlを使用しているライブラリなので、phpにcurlを導入するする必要ありです。  
windos環境はcurl導入が面倒なので注意。  

## 実装
- 検索ワードをクッキーに1週間保存するので次回からはブラウザを開いただけで検索可能
- 半角スペースでOR検索対応
- 検索ワード -(ハイフン)検索ワードの結果から非表示にしたいワード　(いわゆるマイナス検索)に対応

![実装](https://github.com/shioharugit/twitter/blob/master/img/image02.jpg)  

## 結果
- 通常だと検索範囲が過去1週間しか指定できない仕様の様子 ※参考記事にて補足
- 思いのほか検索精度が低い(?)
- マイナス検索＋複数ワード検索に対応するため、  
複数回APIにリクエストするという無理やりな実装になってしまった

## 総評
- TwitterREST APIを用いれば自分のエゴサが快適化すると思ったがそうでもなかった
- しかしながら検索範囲や検索の指定の仕方を熟考して実装すれば、  
会社や企業アカウントの評判を適切に拾うなど業務にも利用できるのではないか

## 参考記事

- 『Twitter API 登録 (アカウント申請方法) から承認されるまでの手順まとめ　※2019年8月時点の情報』
https://qiita.com/kngsym2018/items/2524d21455aac111cdee  

- 『TwistOAuth』  
https://github.com/mpyw-junks/TwistOAuth   

- 『Twitterの検索API & Twitterでの検索術』  
https://gist.github.com/cucmberium/e687e88565b6a9ca7039  
TwitterのAPIで使用できるパラメータがまとまっています。  

- 『Twitter公式/非公式クライアントのコンシューマキー』  
https://gist.github.com/uhfx/3922268  
過去1週間以上の検索を行うにはこちらのコンシューマキーの指定が必要なようです。  
しかしながらこちらを指定したとしても、認証エラーになってしまい過去1週間以上の範囲を検索できませんでした…
