function create_menu(language)
{
	if (language == 'pt-br') {
		document.write(
			'<table cellpadding="0" cellspaceing="0" border="0" style="width:98%"><tr>' +
			'<td class="td" valign="top">' +
			'<h3>Links</h3>' +
			'<ul>' +
			'<li><a href="../index.html">User Guide Home</a></li>' + 
			'<li><a href="http://code.google.com/p/crud-igniter/">CrudIgniter Home</a></li>' +	
			'<li><a href="http://thiagorigo.com/blog">Blog do Thiago Rigo</a></li>' +
			'</ul>' +	
	
			'</td><td class="td_sep" valign="top">' +
	
			'<h3>Informações Básicas</h3>' +
			'<ul>' +
				'<li><a href="requisitos.html">Requisitos</a></li>' +
				'<li><a href="../LICENSE">Licença</a></li>' +
				'<li><a href="changelog.html">Change Log</a></li>' +
			'</ul>' +	
			
			'</td><td class="td_sep" valign="top">' +
			
			'<h3>Uso Básico</h3>' +
			'<ul>' +
				'<li><a href="configurando.html">Configurando um projeto</a></li>' +
				'<li><a href="gerando-model.html">Gerando uma model</a></li>' +
				'<li><a href="gerando-controller.html">Gerando um controller</a></li>' +
				'<li><a href="gerando-view.html">Gerando uma view</a></li>' +
				'<li><a href="integrando.html">Integrando ao CodeIgniter</a></li>' +
			'</ul>' +
			
			'</td><td class="td_sep" valign="top">' +
			
			'<h3>Funcionalidades Avançadas</h3>' +
			'<ul>' +
				'<li><a href="validacao.html">Validação personalizada</a></li>' +
				'<li><a href="template.html">Customizando os templates</a></li>' +
				'<li><a href="console.html">API de Console</a></li>' +
				'<li><a href="novas-funcionalidades.html">Adicionando novas funcionalidades</a></li>' +
			'</ul>' +	
		
			'</td></tr></table>'
		);
	} else if (language == 'en') {
		document.write(
			'<table cellpadding="0" cellspaceing="0" border="0" style="width:98%"><tr>' +
			'<td class="td" valign="top">' +
			'<h3>Links</h3>' +
			'<ul>' +
			'<li><a href="../index.html">User Guide Home</a></li>' + 
			'<li><a href="http://code.google.com/p/crud-igniter/">CrudIgniter Home</a></li>' +	
			'<li><a href="http://thiagorigo.com/blog">Thiago Rigo\'s Blog</a></li>' +
			'</ul>' +	
	
			'</td><td class="td_sep" valign="top">' +
	
			'<h3>Basic Info</h3>' +
			'<ul>' +
				'<li><a href="requirements.html">Requirements</a></li>' +
				'<li><a href="../LICENSE">License</a></li>' +
				'<li><a href="changelog.html">Change Log</a></li>' +
			'</ul>' +	
			
			'</td><td class="td_sep" valign="top">' +
			
			'<h3>Basic Usage</h3>' +
			'<ul>' +
				'<li><a href="configuring.html">Configuring a project</a></li>' +
				'<li><a href="generating-model.html">Generating a model</a></li>' +
				'<li><a href="generating-controller.html">Generating a controller</a></li>' +
				'<li><a href="generating-view.html">Generating a view</a></li>' +
				'<li><a href="integrating.html">Integrating with CodeIgniter</a></li>' +
			'</ul>' +
			
			'</td><td class="td_sep" valign="top">' +
			
			'<h3>Advanced Features</h3>' +
			'<ul>' +
				'<li><a href="validation.html">Custom validation</a></li>' +
				'<li><a href="template.html">Customizing templates</a></li>' +
				'<li><a href="console.html">Console API</a></li>' +
				'<li><a href="new-features.html">Adding new features</a></li>' +

			'</ul>' +	
		
			'</td></tr></table>'
		);
	}
}