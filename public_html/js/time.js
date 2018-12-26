function time() {
  let tm = new Date,
    wynikTxt = '',
    godzina = tm.getHours();

  if (godzina < 10) {
    godzina = "0" + godzina;
  }

  let minuta = tm.getMinutes();

  if (godzina < 10) {
    minuta = "0" + minuta;
  }

  wynikTxt += godzina + ":" + minuta + "  /  ";
  wynikTxt += "    " + tm.getDate() + "." + (tm.getMonth() + 1) + "." + tm.getFullYear();

  document.write(wynikTxt);
}
