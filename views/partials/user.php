
<div class="container">
    <div class="card card--extend">
        <div class="card-body">
            <a href ="user_show.php?id=<?=h ( $user['id'] ); ?>" class= user-link>
            <?php if ( img_exists( $user['image'] ) ): ?>
            <img src=<?=h( get_image_path( $user['image'] ) ) ?> class="img-circle user-image" alt="...">
            <?php endif; ?>
            <h1 class="card-title"><?=h( $user['user_name'] ); ?></h1>
            <div class="nickname">
                @<?=h( $user['nickname'] ) ?>
            </div>
            <p class="card-body">
            follower:<?=h ( get_user_relationship_count( 'follower' ,$user['id'] ) ); ?><br>
            following:<?=h ( get_user_relationship_count( 'following' ,$user['id'] ) ); ?><br>
            like:<?=h ( get_like_posts( $user['id'], 'count' ) ); ?>
            </a>
            <?php  if( !  is_Current_user( $user['id'] ) ): ?>
            <!-- blockされておらず、自分以外のユーザの場合のみfollowボタンを表示 -->
            <?php if ( is_blocked( $user['id'] ) ): ?>
            <div class="block-text"><?= h ( 'You blocked by @' . $user['nickname'] ) ?></div>
            <?php else: ?>
            <?php if ( ! is_following( $user['id'] ) ): ?>
            <form method="POST">
            <input type="hidden" name="follow_id" value="<?=h ( $user['id'] ) ?>"/>
            <button type="submit" class="btn btn-primary btn-lg" name= "follow" >
            <?=h ( $user['user_name'] ) ?>をフォローする</button>
            </form>

            <?php else: ?>
            <form method="POST">
            <input type="hidden" name="unfollow_id" value="<?=h ( $user['id'] ) ?>"/>
            <button type="submit" class="btn btn-info btn-lg" name= "unfollow" >
            <?=h ( $user['user_name'] ) ?>のフォローを解除する</button>
            </form>
            <?php endif; ?>
            <?php endif; ?>  

            <?php  if ( ! is_block( $user['id'] ) ): ?>
            <!-- blockボタン -->
            <form method="POST">
            <input type="hidden" name="blocked_user_id" value="<?=h ( $user['id'] ) ?>"/>
            <button type="submit" class="btn btn-danger btn-lg" name= "block" >
            <?=h ( $user['user_name'] ) ?>をブロックする</button>
            </form>

            <?php else: ?>
            <form method="POST">
            <input type="hidden" name="blocked_user_id" value="<?=h ( $user['id'] ) ?>"/>
            <button type="submit" class="btn btn-success btn-lg" name= "unBlock" >
            <?=h ( $user['user_name'] ) ?>のブラックを解除する</button>
            </form>
            <?php endif; ?> 
                       
            <?php if ( is_Admin() ): ?>
            <form method="POST" action = "" onsubmit="return check();">
            <input type="hidden" name="delete_id" value="<?=h ( $user['id'] ) ?>"/>
            <button type="submit" class="btn btn-danger btn-lg" name= "action" ><?=h( $user['user_name'] ) ?>を削除する</button>
            </form>
            <?php endif; ?>
            <?php endif; ?>
            </p>
        </div>
    </div>
</div>