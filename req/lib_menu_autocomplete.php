<!-- Copyright (c) 2014 YA-androidapp(https://github.com/YA-androidapp) All rights reserved. -->
  // ArtistName
<?php if ( $enable_autocomplete_dir == 1 ) { ?>
  $("#dir").autocomplete({
<?php  if ( stripos($_SERVER['SCRIPT_NAME'], 'music') !== FALSE ) { ?>
   source: "lib_autocomplete_dir.php?bdir=media/musics&id=" + $("#id").val() + "&pw=" + $("#pw").val(),
<?php   } ?>
   delay: 200,
   minLength: 3,
   select: function (e, ui) {
    if (ui.item) { $("#result").html(ui.item.id); }
   }
  });
<?php } ?>

  // Favnum
<?php if ( $enable_autocomplete_favnum == 1 ) { ?>
  $("#favnum").autocomplete({
   source: "lib_autocomplete_favnum.php?id=" + $("#id").val() + "&pw=" + $("#pw").val() + "&pname=<?php echo $pname; ?>",
   delay: 200,
   minLength: 1,
   select: function (e, ui) {
    if (ui.item) { $("#result").html(ui.item.id); }
   }
  });
<?php } ?>
