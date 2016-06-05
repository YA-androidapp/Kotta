// Copyright (c) 2014-2016 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.
$(function () {
 //$('input').blur( function (e){
  $('#dirname').autocomplete({
   source: 'autocomplete_name.php?mode=dir&id=' + $('#id').val() + '&pw=' + $('#pw').val(),
   delay: 100,
   minLength: 2
   // select: function (e, ui) { if (ui.item) { $('#dirresult').html(ui.item.id); } }
  });
 //});
});
