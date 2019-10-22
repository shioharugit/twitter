<?php
require 'TwistOAuth.phar';

$key_word = "";
if (isset($_POST['search_word'])) {
	// ポストに検索ワードがあればキーワードにセット
	$key_word = trim($_POST['search_word']);
} elseif (!empty($_COOKIE['search_word'])) {
	// クッキーに検索ワードがあればキーワードにセット
	$key_word = $_COOKIE['search_word'];
}

if (!empty($key_word)) {
	// TwistOAuth設定
	$consumer_key = '';
	$consumer_secret = '';
	$access_token = '';
	$access_token_secret = '';
	$connection = new TwistOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);

	// 検索ワードをクッキーに1週間保存
	setcookie('search_word', $key_word, time()+60*60*24*7);

	// 検索ワードを整形する
	$search_word_array = make_search_word($key_word);

	// キーワードによるツイート検索
	$tweets = [];
	foreach ($search_word_array as $search_word) {
		if ($search_word !== "") {
			$tweets_params = ['q' => $search_word,'count' => '100'];
			$tweets = array_merge($tweets, $connection->get('search/tweets', $tweets_params)->statuses);
		}
	}

	// 投稿日時の整形
	foreach ($tweets as $key => $value) {
		$tweets[$key]->created_at = date("Y-m-d H:i", strtotime($value->created_at));
	}

	// 投稿日時の降順にソート
	foreach ($tweets as $key => $value) {
		$sort[$key] = $value->created_at;
	}
	array_multisort($sort, SORT_DESC, $tweets);
}

/**
 * 検索ワードを整形する
 * @param string $key_word
 * @return array $result
 */
function make_search_word($key_word)
{
	$explode_word = explode(' ', $key_word);
	$search_word = [];
	$search_minus_word = [];
	$now_search_key = "";
	foreach ($explode_word as $key => $word) {
		$initial = mb_substr($word, 0, 1);
		if ($initial === "-") {
			if (count($search_minus_word[$now_search_key]) > 0) {
				// マイナス検索前に検索ワードがある場合のみ設定
				$search_minus_word[$now_search_key][] = $word;
			}
		} else {
			$now_search_key = $key;
			if (isset($explode_word[(int)$key+1]) && mb_substr($explode_word[(int)$key+1], 0, 1) === "-") {
				// マイナス検索の前の検索ワードの設定
				$search_minus_word[$key][] = $word;
			} else {
				// 検索ワードの設定
				$search_word[] = $word;
			}
		}
	}

	$result = [];
	if (!empty($search_word)) {
		$result[] = implode(' OR ', $search_word);
	}
	foreach ($search_minus_word as $val) {
		$result[] = implode(' ', $val);
	}

	return $result;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="discription" content="Twitterサーチ補助ツールです。エゴサーチに便利です。">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	<title>Twitterサーチ補助ツール</title>
</head>
<body>
	<header>
		<h1 class="m-3 h3">Twitterサーチ補助ツール</h1>
		<form action="/twitter/" method="POST">
			<div class="form-group m-3">
				<textarea class="form-control" name="search_word" rows="4" cols="40"><?php echo $key_word; ?></textarea>
				<input type="submit" class="btn btn-block btn-primary mt-3 mb-5"value="検索" />
			</div>
			
		</form>
	</header>
	<main class="m-3">
		<section>
			<?php if (!empty($tweets)) { ?>
				<?php foreach ($tweets as $tweet) { ?>
					<p>
						<img src="<?php echo $tweet->user->profile_image_url_https; ?>">
						<a href="https://twitter.com/<?php echo $tweet->user->screen_name; ?>" target="_blank"><?php echo $tweet->user->name; ?></a> <label class="small">@<?php echo $tweet->user->screen_name; ?></label>
						<a href="https://twitter.com/i/web/status/<?php echo $tweet->id; ?>" target="_blank">Tweet url</a>
					</p>
					<p><?php echo $tweet->text; ?></p>
					<p class="small"><?php echo $tweet->created_at;?>　<?php echo $tweet->retweet_count; ?>件のリツイート　<?php echo $tweet->favorite_count; ?>件のいいね</p>
					<hr>
				<?php } ?>
			<?php } else { ?>
				検索ワードが指定されていないか、1週間以内の検索結果が0件です
			<?php } ?>
		</section>
	</main>
</body>
</html>