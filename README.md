<p>
  <img src=https://img.shields.io/badge/vers%C3%A3o-1.0.1-red />  
</p>

<p>
<img src="https://raw.githubusercontent.com/wueliton/procura/master/images/logo.png" width="40%" />
</p>

# Procura SEO Rank

<p>
  Procura SEO Rank é um projeto para rankeamento de palavras-chave no buscador Google, desenvolvido para medir a performance das técnicas de SEO aplicadas aos Sites, onde é possível visualizar a posição orgânica das palavras chave da 1ª (primeira) página de busca até a 5ª (quinta) página do buscador, também sendo possível verificar a posição das palavras chave em cada página (1ª à 10ª posição orgânica).
</p>

## Como utilizar

Baixa o repositório e cole a pasta em um servidor local (wamp, xampp).

### Pesquisa de Palavras Chave

<p>Após iniciar a aplicação, insira os dados para realizar a pesquisa</p>



* **Endereço do Site:** Insira o endereço do site sem http/https ou www para que a busca localize todos os tipos de ocorrência.
* **Nome do Site:** Nome identificador do site e nome da pasta que receberá uma cópia, em HTML, de todas as páginas localizadas (para conferência do resultado).
* **Palavras Chave:** Digite as palavras chave separando-as por uma quebra de linha (insira o valor exato procurado, pois a ferramenta realiza a busca do texto digitado, simulando   uma pesquisa no Google e localiza a ocorrência).

<p>Após inserir as informações, envie o formulário.</p>

### Localização das Palavras Chave

A aplicação irá simular a busca, abrindo as páginas do Google (simulando a ação do usuário), e tentará localizar a primeira ocorrência, se localizado, é realizada uma cópia do resultado encontrado na pasta **searchs** com o nome do Site buscado.

### Relatório da Busca

No fim da busca é gerado um relatório em Excel, para que o relatório possa ser baixado, é necessário clicar em **Sair**, em seguida será baixado um arquivo com todas as informações da busca.

## Erros

<p>Como a busca é simulada como ações do usuário, a Google bloqueia a alta quantidade de requisições em um pequeno intervalo, para que o problema não ocorra, é definido um intervalo entre as buscas, porém, pode ocorrer o bloqueio por recaptcha, nesse caso, o buscador sinaliza graficamente, e também emite uma notificação no navegador (Chrome + Windows) informando que houve bloqueio recaptcha, caso ocorra, será necessário aguardar um período para realizar uma nova busca.</p>
