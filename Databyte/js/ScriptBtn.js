function VerMais (){
	var pontos=document.getElementById("pontos");
	var maistexto=document.getElementById("mais");
	var btnLeiaMais=document.getElementById("btnlermais");


	if(pontos.style.display === "none"){
		pontos.style.display="inline";
		maistexto.style.display="none";
		btnLeiaMais.innerHTML="Leia Mais";
	}else{
		pontos.style.display="none";
		maistexto.style.display="inline";
		btnLeiaMais.innerHTML="Leia Menos";
	}
	
}