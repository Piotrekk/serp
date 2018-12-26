<SCRIPT LANGUAGE= "JavaScript" type= "text/javascript">
function time()
{
  var tm = new Date();
  var wynikTxt = '';
  var godzina = tm.getHours();
  if(godzina < 10) godzina = "0" + godzina;
  var minuta = tm.getMinutes();
  if(godzina < 10) minuta = "0" + minuta;
  wynikTxt += godzina + ":"
    + minuta + "  /  ";

  wynikTxt += "    " + tm.getDate() + "." + (tm.getMonth() + 1)
    + "." + tm.getFullYear();
    document.write(wynikTxt);

}
</SCRIPT>
