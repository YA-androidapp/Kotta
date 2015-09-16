// Copyright (c) 2014-2015 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
$(function () {
 //$('input').blur( function (e){
  $('#favname').autocomplete({
   source: 'autocomplete_name.php?mode=fav&id=' + $('#id').val() + '&pw=' + $('#pw').val(),
   delay: 100,
   minLength: 1
   // select: function (e, ui) { if (ui.item) { $('#favresult').html(ui.item.id); } }
  });
 //});
});
