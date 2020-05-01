<?php
$release_url = get_post_meta(get_the_ID(), "release_url", true);
$release_author = get_post_meta(get_the_ID(), "release_author", true);
$content = get_the_content();
?>

<div id="content" role="main">
    <div class="release-main">
        <div class="release-author"><?=$release_author?></div>
        <div class="release-url"><?=$release_url?></div>
        <div class="release-content"><?=the_content()?></div>
    </div>
</div>