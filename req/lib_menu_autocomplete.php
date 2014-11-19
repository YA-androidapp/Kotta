<!-- Copyright (c) 2014 YA-androidapp(https://github.com/YA-androidapp) All rights reserved. -->
  // ArtistName
<?php if ( $enable_autocomplete_dir == 1 ) { ?>
  $("#dir").autocomplete({
   source: "lib_autocomplete_dir.php?id=" + $("#id").val() + "&pw=" + $("#pw").val(),
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
   source: "lib_autocomplete_favnum.php?id=" + $("#id").val() + "&pw=" + $("#pw").val(),
   delay: 200,
   minLength: 1,
   select: function (e, ui) {
    if (ui.item) { $("#result").html(ui.item.id); }
   }
  });
<?php } ?>
