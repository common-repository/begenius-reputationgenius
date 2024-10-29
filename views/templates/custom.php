<style type="text/css" scoped>
    .bg-rg-comment {       
        border-color:<?php echo $plugin->options('paper_border_color')->value; ?>;
        background-color: <?php echo $plugin->options('paper_color')->value; ?>;        
    }

    .bg-rg-inner-comment {        
        color: <?php echo $plugin->options('text_color')->value; ?>
    }
        
    .bg-rg-comment-title {        
    }

    .bg-rg-star {        
        color: <?php echo $plugin->options('stars_color')->value; ?>;
    }

    .bg-rg-hidden {
        color: <?php echo $plugin->options('stars_hidden_color')->value; ?>;
    }

    .bg-rg-comment-text {        
    }

    .bg-rg-comment-author {        
    }
</style>
<?php foreach ($comments as $comment): ?>   
	<div class="bg-rg-comment">
	    <div class="bg-rg-inner-comment">                       
	        <div>
	            <h2 class="bg-rg-comment-title">    
	                <?php echo $comment->get_title(); ?>    
	            </h2>   
	            <strong>                                    
	                <?php 
	                  $stars = $comment->get_stars();
	                  
	                  for ($i=0; $i<$stars[0]; $i++): ?>
	                    <span class="bg-rg-star">&#9733;</span>
	                  <?php endfor;  
	                  for ($i=0; $i<$stars[1]; $i++): ?>
	                    <span class="bg-rg-star bg-rg-hidden">&#9733;</span>
	                  <?php endfor; ?>
	            </strong>
	        </div>
	        <h5>
	            <em><?php echo $comment->get_provider_name(); ?></em> - 
	            <?php echo $comment->get_publish_date(); ?>
	        </h5>
	        <p>    
	            <?php echo $comment->get_entry(); ?>
	        </p>
	        <p class="bg-rg-comment-author">
	            <?php echo __('From', 'bgrg') . ' ' . $comment->get_author(); ?>
	        </p>
	        <p class="bg-rg-comment-text">
	            <a class="bgrg-rev-btn" href="<?php echo $plugin->options('landing_page_url')->value; ?>">
	            	<?php echo __('View all comments', 'bgrg'); ?>                 
	            </a>
	        </p>
	    </div>
	</div>     
<?php endforeach; ?>