function time() {
  let currentTime = new Date(),
    resultStr = '',
    hour = currentTime.getHours();

  if (hour < 10) {
    hour = "0" + hour;
  }

  let minute = currentTime.getMinutes();

  if (minute < 10) {
    minute = "0" + minute;
  }

  resultStr = `${hour}:${minute}, ${currentTime.getDate()} ${(new Date()).toLocaleString('pl', { month: 'long' })} ${currentTime.getFullYear()}`;

  document.write(resultStr);
}
