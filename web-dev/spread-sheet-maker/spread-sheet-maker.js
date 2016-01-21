// The objective of this program is to make an extenible table that can be used on the web

function collums(){
  var anchor = document.getElementById("anchor");
  var tr = document.createElement("tr");
  var t = document.createTextNode("tr");
  tr.appendChild(t);
  anchor.appendChild(tr);
}
function rows(){
  var anchor = document.getElementByID('anchor');
}
function number(numOfCollums, numOfRows){
  for(i=0;i<numOfCollums;i++){
    collums();
  }
   for(i=0;i<numOfRows;i++){
    rows();
  }
}
number(3,0);
