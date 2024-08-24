function formu() {
    d = document.getElementById("select_id").value;
    console.log(d);
    if (d==='c'){
        document.getElementById('addRecibo').style.display='none';
        document.getElementById('addCliente').style.display='block';

    }
    else{
        document.getElementById('addCliente').style.display='none';
        document.getElementById('addRecibo').style.display='block';
    }
}

$(document).ready(function() {
    $("#success-alert").hide();
    $("#myWish").click(function showAlert() {
      $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
        $("#success-alert").slideUp(500);
      });
    });
  });

function mostrarRango(){
  if(document.getElementById("searchBox1").style.display == 'block'){
    document.getElementById("searchBox1").style.display = 'none';
    document.getElementById("searchBox2").style.display = 'none';
    document.getElementById("searchBox3").style.display = 'none';
    document.getElementById("searchBox4").style.display = 'none';
    document.getElementById("searchBox5").style.display = 'none';
  }
  else{
    document.getElementById("searchBox1").style.display = 'block';
    document.getElementById("searchBox2").style.display = 'block';
    document.getElementById("searchBox3").style.display = 'block';
    document.getElementById("searchBox4").style.display = 'block';
    document.getElementById("searchBox5").style.display = 'block';
  }
}

