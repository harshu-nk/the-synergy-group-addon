$('.qtybox .btnqty').on('click', function(){
  var qty = parseInt($(this).parent('.qtybox').find('.quantity-input').val().replace(/[^+\d]/g, ''));
  if($(this).hasClass('qtyplus')) {
    if(qty < 100) {
      qty++;
    }
  }else {
    if(qty > 1) {
      qty--;
    }
  }
  qty = (isNaN(qty)) ? 1 : qty;
  $(this).closest('.qtybox').find('.quantity-input').attr('value','CHF '+ qty + '%');
  $(this).closest('.qtybox').find('.quantity-input').val('CHF '+ qty + '%');
}); 
