function modifyInto() {
    document.getElementById("paragraph").innerHTML="wow, changed.";
}
function checkVal() {
  var num = document.getElementById("num").value;
  if(num>15 || num<10){
    window.alert("input is out of range, not valid");
  }
  else{
    window.alert("input OK");
  }
}
