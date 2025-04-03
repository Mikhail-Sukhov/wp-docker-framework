<section class="post post--table">
	<table class="post__wrapper">
		<tbody>
			<tr>
				<th><?php echo esc_html__( 'Heading', '<%= theme %>' ); ?></th>
				<th><?php echo esc_html__( 'Category', '<%= theme %>' ); ?></th>
				<th><?php echo esc_html__( 'Tags', '<%= theme %>' ); ?></th>
				<th><?php echo esc_html__( 'Date', '<%= theme %>' ); ?></th>
			</tr>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<tr class="post__row" id="post__<?php the_ID(); ?>">
					<td class="post__cell"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></td>
					<td class="post__cell"><?php the_category( ', ' ); ?></td>
					<td class="post__cell"><?php the_tags( '', ', ', '' ); ?></td>
					<td class="post__cell"><?php the_time( 'j F Y' ); ?></td>
				</tr>
			<?php endwhile; ?>
		</tbody>
	</table>
</section>