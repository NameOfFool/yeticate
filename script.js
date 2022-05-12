'use strict';

flatpickr('#lot-date', {
  enableTime: false,
  dateFormat: "Y-m-d",
  locale: "ru"
});
function start(){
  Timer()
  setInterval(Timer,1000)
}
function Timer(){
  let elements = document.getElementsByClassName("timer");
  let now = new Date();
  let midnight = new Date();
  midnight.setDate(now.getDate()+1);
  midnight.setHours(0);
  midnight.setMinutes(0);
  midnight.setSeconds(0);
  midnight.setMilliseconds(0);
  let diff = new Date(midnight-now);
  let value = diff.getHours() + ":"+ diff.getMinutes();
  for(let element of elements) {
    element.innerHTML = value;
  }
}

