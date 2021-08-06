function cancel(){
      document.getElementById("FN").value="";
      document.getElementById("LN").value="";
      document.getElementById("EM").value="";
}

function submit(){
    if(document.getElementById("FN").value != ""){
      if (hasNumber(document.getElementById("FN").value)) {
          window.alert("First name contains number");
          return 0;
      }
    }
    else{
      window.alert("didnt enter first name");
      return 0;
    }
    if(document.getElementById("LN").value != ""){
      if (hasNumber(document.getElementById("LN").value)) {
          window.alert("Last name contains number");
          return 0;
      }
    }
    else{
      window.alert("didnt enter last name");
      return 0;
    }
    if(document.getElementById("EM").value == ""){
      window.alert("no email entered");
      return 0;
    }
}

function hasNumber(textInp) {
  return /\d/.test(textInp);
}
