<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package keep_austin_sexy
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area post_comments">

	<?php
	// You can start editing here -- including this comment!

	if ( have_comments() ) :
		?>
		<h2 class="comments-title">
			<?php
			$keep_austin_sexy_comment_count = get_comments_number();
			if ( '1' === $keep_austin_sexy_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One comment on &ldquo;%1$s&rdquo;', 'keep_austin_sexy' ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			} else {
				printf( 
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', $keep_austin_sexy_comment_count, 'comments title', 'keep_austin_sexy' ) ),
					number_format_i18n( $keep_austin_sexy_comment_count ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			}
			?>
		</h2><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'keep_austin_sexy' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

/* 	comment_form(); */
$defaults = [
	'fields'               => [
		'author' => '<p class="comment-form-author">
			<input id="author" name="author" type="text" placeholder="Name *" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . $html_req . ' />
		</p>',
		'email'  => '<p class="comment-form-email">
			<input id="email" placeholder="Email *" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-describedby="email-notes"' . $aria_req . $html_req  . ' />
		</p>',
		],
		'comment_field'        => '<p class="comment-form-comment">
			<textarea id="comment" name="comment" cols="45" rows="8" placeholder="Comment *"  aria-required="true" required="required"></textarea>
		</p>',
		'title_reply'          => __( 'Leave a Comment' ),
		'title_reply_to'       => __( 'Leave a Reply to %s' ),
		'cancel_reply_link'    => __( 'Cancel reply' ),
		'label_submit'         => __( 'Post Comment' ),
	];

comment_form( $defaults );
	?>

</div><!-- #comments -->
