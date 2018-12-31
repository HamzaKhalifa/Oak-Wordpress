<section class="contact">

    <h1 class="contact_title">Contact</h1>

    <?php global $wp; ?>
    
    <form action="<?php echo ( home_url( $wp->request ) ); ?>">
        <label for="email">Email</label>
        <input type="text" name="email" value="<?php echo( $_GET['email'] ); ?>">

        <label for="subject">subject</label>
        <input type="text" name="subject" value="<?php echo ( $_GET['subject'] ); ?>">

        <label for="content">Content</label>
        <textarea name="content" id="oak-contact-content" cols="30" rows="10"><?php echo( $_GET['content'] ); ?></textarea>

        <input type="submit" value="Send Email">
    </form>
</section>