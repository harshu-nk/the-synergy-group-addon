jQuery(document).ready(function($){
    
    $('.date-field').datepicker({
        // multipleDates: 2,
        // multipleDatesSeparator: ' - ',
        // minDate: new Date(),
        language: 'en',
        // dateFormat: 'yyyy-mm-dd',
        // firstDay: 0,
        /*toggleSelected: false,
        range: true,
        timepicker: true,
        minHours: 9,
        maxHours: 17,
        minutesStep: 5,*/
        // view: 'months',
        clearButton: false,
        isMobile: true,
        autoClose: true,
        onSelect(formattedDate, date, inst) {
            inst.hide();
            // alert(date);
        },
        altField: $('#alt'),
        altFieldDateFormat: 'yyyy-mm-dd'
        // position: 'bottom left'
    });

});