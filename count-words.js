<script>
/*This is the script to count the words in your textarea field
input_21 is the ID of the textarea field
input_49 is the ID of the simple text box
*/
document.getElementById("input_21").addEventListener("keyup", countWords);

function countWords() {
  var s = document.getElementById('input_21').value; 


  s = s.split(' ').length;

  //Get the ID of the simple text box for the counted words
  document.getElementById("input_49").value = s;

}

</script>
