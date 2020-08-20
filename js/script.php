length = arr.length;
bar_percent = 100/length;
bar_all = 0;
indice = 1;

function searchWords() {
	var item = arr.shift();

	if(item !== undefined) {
		$("#loading_text").html("Pesquisando <span>"+item+"</span>...");
		$.post("includes/readwords.php",{keyword: item, website: website, clientSite: clientSite,i: indice},function(r) {
			if(r=="captcha") {
				$(".loading").addClass("erro");
				$("#loading_text").html("Erro ao pesquisar (Captcha Google), tente novamente mais tarde.");
				$("#form_excel").submit();
				var notification = new Notification("Erro na Busca", {
					icon: 'images/icon.png',
					body: "A busca de palavras de "+clientSite+" no Google foi interrompida, por favor, tente novamente mais tarde."
				});
				notification.onclick = function() {
				    window.focus(); this.close();
				}
			}
			else {
				$(".itens").append(r);
				bar_all = bar_all+bar_percent;
				$(".loading span").width(bar_all+"%");

				indice++;
				setTimeout(searchWords,5000);
			}
		});
	}
	else {
		$("#loading_text").html("Finalizado.");
		var notification = new Notification("Busca Finalizada", {
			icon: 'images/icon.png',
			body: "A busca de palavras de "+clientSite+" no Google foi finalizada."
		});
		notification.onclick = function() {
		    window.focus(); this.close();
		}
		$("#form_excel").submit();
	}
}

searchWords();

/*Notification.requestPermission().then(function(result) {
  if (result === 'denied') {
    console.log('Permission wasn\'t granted. Allow a retry.');
    return;
  }
  if (result === 'default') {
    console.log('The permission request was dismissed.');
    return;
  }
});*/