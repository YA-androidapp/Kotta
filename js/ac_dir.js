// Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
$(function () {
 $('input').blur( function (e){
  $('#dir').autocomplete({
   source: 'autocomplete_name.php?mode=dir&id=' + $('#id').val() + '&pw=' + $('#pw').val(),
   delay: 200,
   minLength: 3,
   select: function (e, ui) {
    if (ui.item) { $('#result').html(ui.item.id); }
   }
  });
 });
});
