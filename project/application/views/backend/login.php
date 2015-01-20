
<div class="row">   
   <div class="span12">
      <div class="form-container span4 offset4">
         <div class="message">
         <?php
         if (isset($data) && isset($data['message'])){
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
         <?php echo Form::open('admin-control/login');?>
         <!--Email field-->
         <div class="form-title"><?php echo Form::label('email', 'Email'); ?></div>
         <?php echo Form::email('email');
            //echo Form::file('file', $attributes = array());?>
         <!--Country field-->
         <div class="form-title"><?php echo Form::label('password', 'Password'); ?></div>
         <?php echo Form::password('password');?>
         <!-- Send button -->
         <div class="submit-container"><?php echo Form::submit('Login');?></div>
         <?php echo Form::close();?>
      </div>
   </div>
</div>
