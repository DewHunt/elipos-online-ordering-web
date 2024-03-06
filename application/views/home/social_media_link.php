


<ul class="social-icons-wrapper">
    <li><h4>Follow us on:</h4></li>


    <?php
    $social_medias = get_social_media_details();
    $facebook = get_property_value('facebook', $social_medias);
    $tripadvisor = get_property_value('tripadvisor', $social_medias);
    $instagram = get_property_value('instagram', $social_medias);
    $youtube = get_property_value('youtube', $social_medias);
    $twitter= get_property_value('twitter', $social_medias);
    $google= get_property_value('googlePlus', $social_medias);
    if (!empty($facebook)) {
        echo sprintf('<li><a target="_blank" class="facebook" href="%s"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>', $facebook);
    }
    if (!empty($tripadvisor)) {
        echo sprintf('<li><a target="_blank" class="facebook" href="%s"><i class="fa fa-tripadvisor" aria-hidden="true"></i></a></li>', $tripadvisor);
    }
   if (!empty($instagram)) {
        echo sprintf('<li><a target="_blank" class="facebook" href="%s"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>', $instagram);
    }
    if (!empty($twitter)) {
        echo sprintf('<li><a target="_blank" class="facebook" href="%s"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>', $twitter);
    }
      if (!empty($google)) {
        echo sprintf('<li><a target="_blank" class="facebook" href="%s"><i class="fa fa-google" aria-hidden="true"></i></a></li>', $google);
    }
    ?>
</ul>
