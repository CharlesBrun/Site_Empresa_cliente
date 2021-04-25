function iniciaModal (modalID){

  		const modal = document.getElementById(modalID);
  		modal.classList.add('mostrar');

	}

	const logo = document.getElementById('btnlermais');

	logo.addEventListener('click', function(){
		iniciaModal('modal-recomendacao');
		console.log(logo)
	});
	

