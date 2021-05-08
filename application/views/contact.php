<h1><?php echo $title ?></h1>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div id="message"></div>
        <?php echo form_open('pages/contactSubmit', array('id' => 'contactForm')) ?>
        <div class="form-group">
          <input type="text" name="name" id="name" class="form-control" placeholder="Question">
        </div>
       
        <div class="form-group">
            <button type="submit" class="btn btn-info">Send Message</button>
        </div>
        <?php echo form_close() ?>
    </div>
</div>