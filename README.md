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

- 検索ワードをクッキーに1週間保存するので次回からはブラウザを開いただけで検索可能
- 半角スペースでOR検索対応
- 検索ワード -(ハイフン)検索ワードの結果から非表示にしたいワード　に対応

## 結論
- 通常だと検索範囲が過去1週間しか指定できない
- OR検索がしづらい
- 思いのほか検索精度が低い(?)

---
ここからエンジニア向け

## 導入方法など
Twitterのアカウントを取得し、TwitterのAPIを使用するための準備をします。

- Twitter API 登録 (アカウント申請方法) から承認されるまでの手順まとめ　※2019年8月時点の情報
https://qiita.com/kngsym2018/items/2524d21455aac111cdee
英語での申請が必要です。以前は手動で許可していたようでめっちゃ時間が掛かったようですが、  
今は自動っぽくすんなり申請が通りました。

- TwistOAuth
https://github.com/mpyw-junks/TwistOAuth
mpywさんのTwistOAuthを使います。
curlを使用しているライブラリなので、phpにcurlを導入するする必要あり。  
windos環境は導入が面倒なので注意。

- Twitterの検索API & Twitterでの検索術
https://gist.github.com/cucmberium/e687e88565b6a9ca7039

- Twitter公式/非公式クライアントのコンシューマキー
https://gist.github.com/uhfx/3922268
