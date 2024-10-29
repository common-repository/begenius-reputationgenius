<div class="wrap">
    <h1><?php echo $plugin->name(); ?></h1>
    <?php settings_errors(); ?>       
    <form method="post" class="validate" novalidate="novalidate">              
        <table class="form-table">
            
            <?php foreach ($plugin->options() as $option): ?>
         
              <?php if ($option->hidden === false): ?>
           
              <tr class="form-field <?php if (isset($errors[$option->name])): ?>form-invalid<?php endif; ?>" valign="top">
                  <th scope="row">                      
                      <label for="<?php echo $option->name; ?>">
                          <?php echo $option->title; ?>
                          <?php if ($option->required): ?>
                          <span class="description">(<?php echo __('required'); ?>)</span>
                          <?php endif; ?>
                      </label>
                  </th>
                  <td>
                      
                      <?php echo $option->render(); ?>
                      <p>
                        <?php if (isset($errors[$option->name])): ?>
                          <?php foreach ($errors[$option->name] as $error): ?>
                            <?php echo $error->message; ?><br/>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </p>
                  </td>
              </tr>
              <?php endif; ?>
            <?php endforeach; ?>      
        </table>    
        <?php submit_button(); ?>
    </form>
    <?php if ($comments): ?>     
      <h2>
          <?php echo __('Total comments downloaded', 'bgrg') . ': ' .  count($comments); ?>
      </h2>
      <h3>
          <?php echo __('Latest download at', 'bgrg') . ': ' . $plugin->options('latest_comments_download')->value; ?>
      </h3>
      <table class="wp-list-table widefat fixed">
          <thead>
            <th scope="col" class="manage-column">Code</th>
            <th  scope="col" class="manage-column">Provider</th>
            <th  scope="col" class="manage-column">Rating</th>
            <th  scope="col" class="manage-column">Length</th>
            <th  scope="col" class="manage-column">Publish date</th>
          </thead>
          <tbody>
            <?php foreach ($comments as $comment): ?>
                <tr>
                    <td>
                    <?php echo $comment->get_code(); ?>      
                    </td>              
                    <td><?php echo $comment->get_provider_name(); ?></td>
                    <td><?php 
                      $stars = $comment->get_stars();
                      for ($i=0; $i<$stars[0]; $i++) {
                        echo '&#9733; ';
                      }
                      echo '&nbsp;&nbsp;';
                      echo $comment->get_rank();
                    ?>
                    <td><?php echo strlen($comment->get_entry()); ?></td>
                    <td><?php echo $comment->get_publish_date(); ?></td>
                </tr>
            <?php endforeach; ?>
          </tbody>       
      </table>    
    <?php endif; ?>
</div>