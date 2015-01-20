
<div class="row">   
   <div class="span12">
      <div class="form-container">
         <div class="message">
         <?php
         if (isset($data) && (isset($data['errors']) || isset($data['message']))){
            if(!empty($data['errors'])) {
               foreach($data['errors'] as $error){
                  if(!empty($error)){   
                     echo '<span>'.array_shift($error).'</span><br/>';
                  }
                  
               }
            }elseif(!empty($data['message'])){
               echo '<span>'.$data['message'].'</span><br/>';
            }elseif(!empty($data['result'])){
               print_r($data);
               echo '<span>'.$data['result'].'</span><br/>';
            }
            echo "<br/>";
         }
         
         ?>
         </div>
         <?php echo Form::open('contact/check');?>
         <!--Name field-->
         <div class="form-title"><?php echo Form::label('name', 'Name');?></div>
         <?php echo Form::text('name');?>
         <!--Email field-->
         <div class="form-title"><?php echo Form::label('email', 'Email'); ?></div>
         <?php echo Form::email('email');
            //echo Form::file('file', $attributes = array());?>
         <!--Country field-->
         <div class="form-title"><?php echo Form::label('country', 'Country'); ?></div>
         <?php echo Form::text('country');?>
         <!--Subject field-->
         <div class="form-title"><?php echo Form::label('subject', 'Subject'); ?></div>
         <?php echo Form::text('subject');?>
         <!--Subject field-->
         <div class="form-title"><?php echo Form::label('message', 'Message'); ?></div>
         <?php echo Form::textarea('message');?>
         
         <!-- Send button -->
         <div class="submit-container"><?php echo Form::submit('Send');?></div>
         <?php echo Form::close();?>
      </div>
   </div>
</div>
