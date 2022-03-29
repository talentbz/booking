let checkInval = $("#start_checkin").val() || moment().format('YYYY-MM-DD'),
    checkOutVal = $("#end_checkout").val() || moment().add('1', 'days').format('YYYY-MM-DD');
$("#start_date_display").html(moment(checkInval).format('DD/MM/YYYY'));
$("#end_date_display").html(moment(checkOutVal).format('DD/MM/YYYY'));

$("#request_checkIn").val(moment(checkInval).format('YYYY-MM-DD'));
$("#request_checkOut").val(moment(checkOutVal).format('YYYY-MM-DD'));
let options = {
  onlyShowCurrentMonth: true,
  showCalendar: false,
  alwaysShowCalendars: false,
  autoApply: true,
  disabledPast: true,
  dateFormat: 'YYYY-MM-DD',
  classNotAvailable: ['disabled', 'off'],
  enableLoading: true,
  showEventTooltip: true,
  autoResponsive: true,
  startDate: moment(checkInval, 'YYYY-MM-DD'),
  endDate: moment(checkOutVal, 'YYYY-MM-DD'),
  opens: 'center',
  drops: 'up'
};

var changeOption = function() {
  checkInval = $("#start_checkin").val() || moment().format('YYYY-MM-DD');
  checkOutVal = $("#end_checkout").val() || moment().add('1', 'days').format('YYYY-MM-DD');
  options = {
    onlyShowCurrentMonth: true,
    showCalendar: false,
    alwaysShowCalendars: false,
    autoApply: true,
    disabledPast: true,
    dateFormat: 'YYYY-MM-DD',
    enableLoading: true,
    showEventTooltip: true,
    customClass: 'hh-search-form-calendar',
    classNotAvailable: ['disabled', 'off'],
    disableHighLight: true,
    autoResponsive: true,
    startDate: moment(checkInval, 'YYYY-MM-DD'),
    endDate: moment(checkOutVal, 'YYYY-MM-DD'),
  };
}

$("#checkinoutfield").daterangepicker(options, function(start, end, label) {
  console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  $("#start_checkin").val(start.format('YYYY-MM-DD'));
  $("#end_checkout").val(end.format('YYYY-MM-DD'));
  $("#request_checkIn").val(start.format('YYYY-MM-DD'));
  $("#request_checkOut").val(end.format('YYYY-MM-DD'));
  $("#start_date_display").html(start.format('DD/MM/YYYY'));
  $("#end_date_display").html(end.format('DD/MM/YYYY'));
});

$("#start_range_date").click(function() {
  $("#checkinoutfield").trigger('click');
});

$("#end_range_date").click(function() {
  $("#checkinoutfield").trigger('click');
});