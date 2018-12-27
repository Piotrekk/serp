function time() {
  let currentTime = new Date(),
    resultStr = '',
    hour = currentTime.getHours();

  if (hour < 10) {
    hour = "0" + hour;
  }

  let minute = currentTime.getMinutes();

  if (hour < 10) {
    minute = "0" + minute;
  }

  resultStr = `${hour}:${minute} / ${currentTime.getDate()}.${(currentTime.getMonth() + 1)}.${currentTime.getFullYear()}`;

  document.write(resultStr);
}
