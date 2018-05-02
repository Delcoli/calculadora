# Projeto

O projeto consiste em desenvolvimento de uma calculadora utilizando API e sem o uso de framework

# Requisitos

	Ter instalado no sistema operacional:
	* PHP versão 7.1.9 ou superior 
	* Banco de dados MySQL 5.7.19 ou superior (É necessário que esteja com o case sensitive desativado para evitar erros)

# Preparação do projeto

    Preparação do banco de dados
	    * Crie um novo banco de dados no seu MySQL
	    * Execute o script TABELAS.sql que se encontra na raiz do projeto
	
	Configuração de banco de dados no projeto
	    * Abra o arquivo config.php que se encontra, a partir da raiz do projeto, na pasta API->config
	    * Insira os dados referente ao seu banco de dados conforme a estrutura encontrada no arquivo


# Executando o projeto

    Com o terminal de comando aberto, navegue até a pasta do projeto
    Na raiz do projeto, inicialize o servidor WEB do PHP. (Exemplo: php -S localhost:8080)
    No navegador, insira a URL correspondente ao servidor WEB do PHP. (Exemplo: http://localhost:8080)
    
# Executando os testes unitários

    Com o terminal de comando aberto, navegue para
        * A pasta do projeto
        * Na raiz do projeto, navegue para a pasta API
        * Na pasta API, execute o comando php phpunit.phar e os testes serão executados


# Tela de login

    Para logar na aplicação, insira os dados de email e senha conrrespondente ao usuário e click em entrar
        * Caso esteja com o email ou senha incorreto e caso o usuário não existir, será apresentado a mensagem
        * Caso o login seja realizado com sucesso será apresentado a tela da calculadora
    Para cadastrar um usuário, click no botão de cadastrar usuário e será apresentado a tela de cadastro de usuário
 
# Tela de cadastro de usuário

    O botão retornar ao login, será apresentado a tela de login
    Para cadastrar um novo usuário, insira o nome, email e senha e click no botão gravar
        * Caso o nome não seja informado, será inserido o email no lugar
        * se o email ou senha não for preenchido, apresentará a mensagem de erro
        * se os dados estiver correto, será apresentado a mensagem de sucesso

# Tela da calculadora

    Ao acessar a aplicação, se o usuário estiver logado, será apresentado a calculadora, caso contrário a tela de login
    Para realizar o cálculo, com auxilo do mouse insira a expressão a ser calculada e click no botão igual (botão verde)
        * Caso a expressão esteja incorreta, será apresentado a mensagem de erro no campo resultado.
        * Caso a expressão esteja correta, será apresentado o resultado no campo resultado e será gravado a exprresão
    Funções de alguns botões chave
        * O botão com o simbolo de igual (=) (botão verde) - calcula a expressão
        * O botão com o texto Limpar - limpa a expressão e o resultado
        * O botão com o texto Remover - Remove o último valor inserido na expressão
        * O botão com o texto Sair - Sai da aplicação, e retorna para a tela de login
        * O botão com o texto Relatório - Apresenta a tela de relatório
        
# Tela do relátorio

    Para retornar a calculadora, click em Retornar a calculadora (botão vermelho)
    Para recuperar as expressões, click em Recuperar operações (botão verde)   
        * Caso a primeira data do período estiver preenchida e a segunda data, apresenta mensagem de erro
        * Caso a segunda data do período estiver preenchida e a primeira data, apresenta mensagem de erro
        * Caso a primeira data do período seja menor que a segunda data, apresenta mensagem de erro
        * Caso as duas datas preenchidas, apresenta os dados
        * Caso a primeira data do período seja maior que a segunda data, apresenta os dados        
        
# Documentação da API do sistema
**Ação: Logar na aplicação - Função: Realizar autenticação do usuário na aplicação**

**URL de acesso:** /api/usuario/logar

**exemplo URL:** http://localhost:8080/api/usuario/logar

**Metódo:** POST

**Parâmetros (obrigátorios):** chave: email / chave: senha

**Retornos definidos:**

Código: 403 - Retorno: Email ou senha está incorreto ou usuário não está cadastrado

Código: 200

........................................................................................

**Ação: Salvar usuário - Função: Salvar dados do usuário na aplicação**

**URL de acesso:** /api/usuario/salvar

**exemplo URL:** http://localhost:8080/api/usuario/salvar

**Metódo:** POST

**Parâmetros (obrigátorios):** chave: email / chave: senha

**Parâmetros (opcionais):** chave: nome

**Retornos definidos:**

Código: 403 - Retorno: Já existe um email cadastrado

Código: 200

........................................................................................

**Ação: Calcular - Função: Realizar o cálculo da expressão**

**URL de acesso:** /api/calculadora/calcular

**exemplo URL:** http://localhost:8080/api/calculadora/calcular

**Metódo:** POST

**Parâmetros (obrigátorios):** chave: expressao / chave: email

**Retornos definidos:**

Código: 403 - Retorno: Usuário sem permissão

Código: 403 - Retorno: Divisão por zero

Código: 403 - Retorno: Operação não definida

Código: 403 - Retorno: Expressão incorreta

Código: 200 - Retorno: resultado do cálculo

........................................................................................

**Ação: Relátorio - Função: Retornar todas as operações realizadas**

**URL de acesso:** /api/relatorio/lista

**exemplo URL:** http://localhost:8080/api/relatorio/lista

**Metódo:** POST

**Parâmetros (opcionais):** chave: dataInicial / chave: dataFinal

**Retornos definidos:**

Código: 200 - Retorno: lista em formato json com todas as operações