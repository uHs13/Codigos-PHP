/* Modelagem física do banco */

CREATE TABLE Cliente(
	nome varchar(50),
	email varchar(100),
	telefone varchar(30),
	endereco varchar(100),
	sexo char(1),
	cpf int(11)/*11 é a quantidade máxima de caracteres que um int suporta, logo pode dar erro. É aconselhado utilizar varchar para tipar números que não vão ser utilizados em cálculos, como CPF, CNPJ; */
);
/*Passos pra criar e usar : */

/*1°*/
Create database nomeDatabase;
Create database Projeto;/*<----- Banco usado no exemplo da tabela acima (table Cliente)*/
/*2°*/
Use nomeDatabase;
/*3°*/
create table nomeTabela(
	/*nomeatributo tipodeDado(tamanho), => vírgula só se não for a última coluna da tabela*/
	nome VARCHAR(30),
	cpf int(11)
);

/* Para ver as tabelas do banco*/
SHOW TABLES; /*TUDO MAIÚSCULO*/

/*Ver uma tabela com detahes*/
DESC nomeTabela;

/*Inserir Dados nas tabelas*/
Insert into nomeTabela values(valores);
Insert into Cliente values("Heitor Souza","heitorhenriquedias@gmail.com","31996584702","Rua do bairro, numero entre 0 e infinito, complemento","m",151778);
/* Passando dessa maneira os valores(parâmetros do values()) têm de vir na exata ordem em que estão dispostos no BD*/

/* Inserir passando as colunas - Insert Declarativo */
Insert into Cliente (cpf,endereco,sexo,email,nome,telefone) values (151778,"Rua do bairro, numero entre 0 e infinito, complemento","m","heitorhenriquedias@gmail.com","Heitor Souza","31996584702");
/* Dessa maneira conseguimos passar os dados na ordem que quisermos já que especificamos em que colunas eles devem ser inseridos. Os argumentos têm de ser passados na exata ordem de especificação das colunas*/

/* Insert Compacto (ele é colado com o pata rachada? não..., apenas conseguimos passar mais de um registro com as informações, basta separá-los por vírgula)*/
insert into Cliente values("Heitor Souza","heitorhenriquedias@gmail.com","31996584702","Rua do bairro, numero entre 0 e infinito, complemento","m",151778),("Hector Sosa","hectorHenrinchSosa@hotmail.com","31999658741","Rua do bairro, numero entre 0 e 13000, complemento","m",121171);
/* Esse método facilita a inserção de dados, porém só é aceito em bancos de dados MySql */

/* SELECT*/
SELECT Now();/* Essa função retorna a Data e a Hora do Banco de Dados*/

SELECT 'Mensagem'; /* O banco mostra a mensagem na tela*/

SELECT 'Mensagem' as 'String'; /* O banco mostra a mensagem na coluna string*/

SELECT nome,email FROM Cliente;/* Retorna nome e email de todas as tuplas da tabela Cliente*/


/*NUNCA USAR ESSE COMANDO!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
SELECT * FROM Cliente;/*Retorna todos os dados de todas as tuplas da tabela Cliente*/


/*A união de colunas nos fornece um registro*/


/*Filtragem de dados*/

SELECT nome,cpf FROM Cliente WHERE sexo='m';/*retorna todos os registros da tabela Cliente que atendem aos requisitos, sexo='m'*/

SELECT nome,cpf from Cliente where cpf=121171;

select nome as nombre from Cliente where nome like='Hector Sosa';

select nome as nombre from Cliente where cpf like '1%';/*Selecionar nome do Cliente onde cpf começa com 1 termina com qualquer coisa */

select nome as nombre from Cliente where cpf like '%1';/* onde cpf começa com qualquer coisa e termina com 1*/

select nome as nombre from Cliente where cpf like '%8%';/*retorna todos que tem 8 no cpf. Mesmo o cpf sendo em números temos que deixar entre aspas para usar o %*/

select count(nome) as nmrClientes from Cliente;/* conta e devolve a quantidade de nomes existentes na tabela cliente. Como cada cliente é obrigado a ter um nome, é valido fazer assim*/

select nome, count(cpf) as 'quantidade' from Cliente group by nome;/* O group by separa, de acordo com o atributo passado, as tuplas retornadas em grupos de semelhantes*/

select nome,email from Cliente where telefone is null;/* retornando tuplas que têm atributos nulos*/

/*Utilizar UPDATE sempre com a cláusula Where*/
update nomeTabela set atributo=valor where condições;
update Cliente set telefone=99854154713 where nome='marreco'; --comentário de uma linha;

--Usar Delete sempre com where;  Quando a tabela tem auto_increment, no id por exemplo, o delete deixa rastro. Se temos 4 registros e deletarmos o registro 4, o próximo a ser cadastrado terá o id 5. A tabela vai ficar (1,2,3,5); 
delete from nomeTabela where condições;
delete from Cliente where nome='Heitor Souza';

/*1ª FORMA NORMAL*/

/*1 - Todo campo vetorizado se tornará outra tabela 

	['Ford','Ferrari','Maserati','Tesla Motors','Mercedes']-> Dados da mesma natureza - Montadoras;
	
	Em um banco de dados essa regra se aplica por exemplo ao atributo telefone. Não é interessante manter dois números em um mesmo espaço na tabela
	, ex.: [998765432 - 992341567], isso geraria erros futuros, não conseguiriamos contar o número total de telefones dentro da nossa base de dados, 
	a query retornaria uma informação errada (errada por culpa de má modelagem, o computador só faz o que a gente manda e ainda faz certo) e informações 
	erradas podem levar uma empresa a falência. A solução seria seguir esse principio da primeira forma normal e criar uma tabela telefone.

*/

/* 2 - todo campo multivalorado se tornará outra tabela - campo divisível - A diferença do campo vetorizado para o multivalorado é que no multivalorado os elementos não são da mesma natureza. No endereço( que é multivalorado ) temos strings e números. No vetor de montadoras( vetorizado ) apenas strings.
	
	Na nossa tabela Cliente temos um exemplo desse tipo de campo, Endereço. Nele estamos armazenando tudo junto 'rua, número e bairro', isso 
	geraria erros de consulta e consequentemente informações erradas. A solução para essa situação é também a criação de uma nova tabela para armazenarmos esses dados.

*/

/* 3 - Toda tabela necessita de pelo menos um campo que idetifique todo o registro como sendo único - Chave Primária PRIMARY KEY
	
	Na nossa tabela Cliente poderiamos falar, ah blz bota o cpf de primary ai e boa. Mas é um principio não modelarmos NUNCA baseados em procedimentos,
	principalmente externos, pois os procedimentos podem sofrer alterações. O cpf é um número que quem controla é a receita federal, se no futuro a regra 
	de numeração mudar, o nosso banco perderia a validade da chave primária, e isso é um problema sério. 
	
	Chave Natural - Dado que provém do que está sendo cadastrado, o cpf por exemplo é um número que já está ''''embutido'''' nos dados do cliente e nenhum outro
	vai ter uma numeração igual, pois é uma regra externa o CPF ser único para identificar um cidadão. Usando chaves naturais corremos o risco da regra externa mudar 
	e termos de refazer todo o banco.
	
	Chave Artificial - Campo criado para a identificação de um registro ( id ou algo assim ).

*/

/* REMODELAGEM CLIENTE - Modelo Físico */

Create database comercio; -- cria o banco;

use comercio; -- após criar temos que nos conectar;

create table cliente(
	idCliente int PRIMARY KEY AUTO_INCREMENT, -- auto_increment o banco controla o número do id;
	nome varchar(30) not null, -- impede o cadastro de um cliente sem nome;
	sexo enum('m','f') not null, --enum são opções pré definidas
	email varchar(50) unique, -- não podemos falar que é not null porque muita gente não tem email. unique fala que o valor tem que ser único na tabela. O email não pode repetir na coluna email;
	cpf varchar(14) unique --14 pra colocar  .   . - ; 
);

create table telefone(

	idTelefone int primary key auto_increment,
	tipo enum('com','res','cel'),
	numero varchar(10),
	ddd char(2),
	id_Cliente int --O tipo é igual ao tipo na tabela de onde a fk veio. O Nome de uma chave estrangeira por convenção tem underline;
	foreign key (id_Cliente)        /* foreign key (nomedaChavenaTabela) references  nomedaTabeladeOndeVeio(nomedaPKNessaTabela)*/
	references cliente(idCliente)	
	
);

create table endereco(

	idEndereco int primary key auto_increment,
	rua varchar(30) not null,
	bairro varchar(30) not null,
	cidade varchar(30) not null,
	estado char(2) not null	
	id_Cliente int unique, -- O Nome de uma chave estrangeira por convenção tem underline. Um cliente não pode ter dois endereços;
	foreign key(id_Cliente)
	references cliente(idCliente)
	
);
/*
	Foreign Key é a chave primária de uma tabela que vai até outra fazer referência
	
	Em relacionamentos 1x1 a chave estrangeira fica na tabela mais fraca, a que não faz sentido existir sem a outra ( Ex.: Endereço sem nenhum cliente );
	
	Em relacionamentos 1xn a chave estrangeira fica na tabela n;
*/

/* Inserts */

--Não convém utilizar o insert compacto ( com vários 'arrays' com values de uma só vez ) porque esse método só é aceito em bancos mysql, ficariamos mal acostumados;
insert into cliente values(null,'joao','m','jaumzin22@gmail.com','98547-6');
insert into cliente values(null,'carlos','m','caca171@hotmail.com','86641-7');
insert into cliente values(null,'ana','f','ahtaldaana@gmail.com','75658-5');
insert into cliente values(null,'clara','f',null,'99754-7');
insert into cliente values(null,'celia','f','celinhadaquebrada@hotmail.com','77558-5');
-- o null no inicio do values é a chave primária, como ela é auto_increment o banco que determina o valor;
insert into endereco values(null,'Belgica','Eldorado','Contagem','MG',2);--esse último número é o id do cliente que o endereço pertence
insert into endereco values(null,'Espanha','Eldorado','Contagem','MG',5);
insert into endereco values(null,'Inglaterra','Eldorado','Contagem','MG',3);
insert into endereco values(null,'Veneza','Eldorado','Contagem','MG',4);
insert into endereco values(null,'Franca','Eldorado','Contagem','MG',1);
--Cliente com mais de um telefone é pra demonstrar e lembrar que podemos cadastrar mais de um telefone pra um cliente;
insert into telefone values(null,'com','985471234','31',1);--esse último número é o id do cliente que o telefone pertence. Isso garante a integridade referencial, temos um registro sempre relacionado com outro existente, um telefone "amarrado" a um cliente;
insert into telefone values(null,'res','978452165','31',3);
insert into telefone values(null,'cel','963987412','31',2);
insert into telefone values(null,'res','912954871','31',5);
insert into telefone values(null,'cel','953867542','31',4);
insert into telefone values(null,'res','954653298','31',1);
insert into telefone values(null,'cel','914253687','31',3);


/* Seleção, projeção e junção */

-- Projeção: Tudo o que queremos mostrar (projetar) na tela;

Select now();--mostra a data e a hora do banco de dados;
Select nome, now() as "data" from cliente;

--Seleção: Banco de dados é teoria dos conjuntos. Seleção seleciona um subconjunto de dados do todo;

/* Where é a cláusula de seleção*/
select nome,sexo from cliente where sexo='f';

update telefone set numero=25674530 where idTelefone=2 and id_Cliente=3;

--Junção: 

--NUNCA FAZER ISSO DESSE JEITO:
select nome,sexo,rua,cidade, now() as "data"
from cliente,endereco
where idCliente = id_Cliente;
--NUNCA FAZER ISSO. WHERE É CLÁUSULA DE SELEÇÃO NÃO DE JUNÇÃO. COMO NÃO EXISTE ENDEREÇO 'SOLTO' ( PRA TER ENDEREÇO PRECISAMOS DE UM CLIENTE ) ESSE WHERE VAI SER SEMPRE VERDADE PRA TODOS OS REGISTROS.
--Relaciona a chave primária de cliente com a estrangeira de endereco.
/* Retorna os dados com a relação idCliente=id_Cliente, ou seja, 
as informações indivíduais de cada cliente*/ 

--JEITO CERTO - COM JOIN:

--2 tabelas ( A do from e a do inner join)
select nome,sexo,rua,cidade,now() as 'data' -- Projeção
from cliente 
inner join endereco -- Junção
on idCliente=id_Cliente 
where sexo='f'; -- Seleção

--3 tabelas:

--temos que especificar de quais tabelas vêm esses dados
select cliente.nome, cliente.sexo, endereco.rua, endereco.cidade, telefone.tipo, telefone.ddd, telefone.numero -- tabela.atributo == ponteiro;
from cliente
inner join endereco
on cliente.idCliente = endereco.id_Cliente
inner join telefone
on cliente.idCliente = telefone.id_Cliente
where cliente.sexo='m';
-- como podemos ter mais de uma tupla de telefone relacionada com o mesmo cliente ( um cliente pode ter mais de um número ) vão ser retornadas mais de uma linha com o mesmo cliente, mas não é erro de redundância ( O computador está sempre certo ).

select c.nome, e.bairro, t.ddd, t.tipo, t.numero
from cliente c -- damos nomes reduzidos para as tabelas para podermos referenciá-las de maneira mais fácil;
inner join endereco e
on c.idCliente = e.id_Cliente
inner join telefone t
on c.idCliente = t.id_Cliente
where c.sexo = 'f';

/* Oficina do José */
/*
	BD chamado projeto
	
	Sr.josé quer modernizar a sua oficina, e por enquanto, cadastrar os carros que entram
	para realizar os serviços e os respectivos donos. Sr josé mencionou que cada cliente
	possui apenas um carro. Um carro possui uma marca. Sr.José também quer saber as
	cores dos carros para ter idéia de qual tinta comprar, e informa que um carro pode ter
	mais de uma cor. Sr josé precisa armazenar os telefones dos clientes, mas não quer
	que eles sejam obrigatórios.
	
*/

create database projeto;

use projeto;

create table cliente(

	idCliente int primary key auto_increment,
	nome varchar(30) not null, --não dar espaço entre o tipo de dado e o outro atributo ( not null nesse caso) não causa erros;
	cpf varchar(14) unique
	
);

create table carro(
	
	idCarro int primary key auto_increment,
	montadora varchar(20) not null,
	modelo varchar(20) not null,
	id_Cliente int unique, -- Usar _ para indicar que é uma chave estrangeira. É uma convenção.
	foreign key (id_Cliente)
	references cliente(idCliente)
	
);

create table servicos(
	
	idServico int primary key auto_increment,
	nome varchar(30) not null,
	descricao varchar(30),
	preco int(5) not null,
	id_Cliente int unique,
	id_Carro int unique,
	
	foreign key (id_Cliente)
	references cliente(idCliente), --vírgula entre chaves diferentes e atributos diferentes;
	
	foreign key (id_Carro)
	references carro(idCarro)
	
);

create table cores(
	
	idCor int primary key auto_increment,
	nome varchar(100) not null,
	id_Carro int unique,
	
	foreign key (id_Carro)
	references carro(idCarro)
	
	
	
);
--números que não vão ser utilizados em cálculos tipá-los como varchar;
create table telefone(
	
	idTelefone int primary key auto_increment,
	ddd int(2),
	numero varchar(10), 
	id_Cliente int unique,
	foreign key (id_Cliente)
	references cliente(idCliente)
	
);

--inserindo clientes       null por causa da chave primária, não podemos dar valor porque é o banco que gerencia;
insert into cliente values(null,'Mario Gallo','789.654-13');
insert into cliente values(null,'Connie Guiseppe','159.753-62');
insert into cliente values(null,'Ezio Auditore','351.953-84');

--inserindo carros       1:1 - 1 cliente só possui 1 carro;
insert into carro values(null,'Lamborghini','Urus',2);
insert into carro values(null,'Alfa Romeo','Giulia Veloce',3);
insert into carro values(null,'Maserati','Levante',1);

--inserindo servicos     
insert into servicos(idServico,nome,preco,id_Cliente,id_Carro) values(null,'Troca de oleo','330',1,3);
insert into servicos(idServico,nome,preco,id_Cliente,id_Carro) values(null,'Substituicao de amortecedor','4000',2,1);
insert into servicos(idServico,nome,preco,id_Cliente,id_Carro) values(null,'Pintura','5520',3,2);

--inserindo cores 
insert into cores values(null,'Carbono Fosco',2);
insert into cores values(null,'Indigo Meia Noite',3);
insert into cores values(null,'Preto perolado em Verde Esmeralda ',1);

--inserindo telefone
insert into telefone values(null,'+39','15445871',1);
insert into telefone values(null,'+39','45876598',2);
insert into telefone values(null,'+39','32548712',3);
-- para inerir mais de um telefone para um cliente é só repetir o processo e colocar o id do cliente a que pertence no final;

--Query
select c.nome as 'Cliente',cr.montadora,cr.modelo,cor.nome as 'Cor',s.nome as 'Servico',s.preco as 'Preco',t.ddd,t.numero
from cliente c
inner join carro cr
on c.idCliente = cr.id_Cliente  
inner join servicos s
on  s.id_Cliente = c.idCliente
inner join cores cor 
on cr.idCarro = cor.id_Carro
inner join telefone t 
on c.idCliente = t.id_Cliente;

/*relação correta: Vem fora de ordem de idCliente porque os serviços estão cadastrados 3 1 2 - ezio, mario, connie;
	
	Mario - Maserati - Levante - Indigo Meia Noite - Troca de óleo - 330 - +39 - 15445871
	
	Connie - Lamborghini - Urus - Preto perolado em verde esmaralda - Substituição de amortecedor - 4000 - +39 - 45876598
	
	Ezio  - Alfa Romeo - Guilia Veloce - Carbono Fosco - Pintura - 5520 - +39 - 32548712
	
	+-----------------+-------------+---------------+------------------------------------+-----------------------------+-------+------+----------+
	| Cliente         | montadora   | modelo        | Cor                                | Servico                     | Preco | ddd  | numero   |
	+-----------------+-------------+---------------+------------------------------------+-----------------------------+-------+------+----------+
	| Ezio Auditore   | Alfa Romeo  | Giulia Veloce | Carbono Fosco                      | Pintura                     |  5520 |   39 | 32548712 |
	| Mario Gallo     | Maserati    | Levante       | Indigo Meia Noite                  | Troca de oleo               |   330 |   39 | 15445871 |
	| Connie Guiseppe | Lamborghini | Urus          | Preto perolado em Verde Esmeralda  | Substituicao de amortecedor |  4000 |   39 | 45876598 |
	+-----------------+-------------+---------------+------------------------------------+-----------------------------+-------+------+----------+
	
 */
 
 --Correção de preço como string:
 update servicos set preco=330 where id_Cliente=1;
 update servicos set preco=4000 where id_Cliente=2;
 update servicos set preco=5520 where id_Cliente=3;
 
 
 /* Voltando pro banco comércio */
 
 select c.nome,c.email,t.ddd,t.numero 
 from cliente c
 inner join telefone t
 on c.idCliente = t.id_Cliente
 inner join endereco e
 on c.idCliente = e.id_Cliente
 where e.bairro = 'eldorado' and e.rua='Belgica' or e.rua='Franca'; -- se colocar and no lugar do or não retorna nada porque não tem cliente com dois endereços( A regra de negócio não permite ), somente dois telefones;
/* 
	+--------+---------------------+------+-----------+
	| nome   | email               | ddd  | numero    |
	+--------+---------------------+------+-----------+
	| carlos | caca171@hotmail.com | 31   | 963987412 |
	| joao   | jaumzin22@gmail.com | 31   | 985471234 |
	| joao   | jaumzin22@gmail.com | 31   | 33920530  |
	+--------+---------------------+------+-----------+

*/

select c.nome, c.email, t.ddd , t.numero
from cliente c
inner join telefone t
on c.idCliente = t.id_Cliente
inner join endereco e -- Chama a tabela endereço mesmo ela não sendo usada na projeção porque ela é usada na seleção, onde o bairro for 'Eldorado'. 
on c.idCliente = e.id_Cliente
where c.sexo='f' and bairro='eldorado';

/*
	+-------+-------------------------------+------+-----------+
	| nome  | email                         | ddd  | numero    |
	+-------+-------------------------------+------+-----------+
	| celia | celinhadaquebrada@hotmail.com | 31   | 33922239  |
	| ana   | ahtaldaana@gmail.com          | 31   | 25674530  |
	| ana   | ahtaldaana@gmail.com          | 31   | 914253687 |
	| clara | NULL                          | 31   | 953867542 |
	+-------+-------------------------------+------+-----------+

*/

-- Função Ifnull() - recebe como parâmetro a coluna que pode retornar um valor nulo e um valor para substituir o null caso ele seja retornado; 

select c.nome, 
	   ifnull(c.email,' - ') as Email, -- tem que colocar o alias pra não ficar a função e os parâmetros como nome da coluna; 
	   t.ddd,
	   t.numero
from cliente c
inner join telefone t
on c.idCliente = t.id_Cliente
inner join endereco e 
on c.idCliente = e.id_Cliente
where c.sexo='f' and bairro='eldorado';

/*
	Quando temos um relacionamento :n (0:n ou 1:n) os relacionamentos da primeira ponta podem se repetir caso tenha mais de um registro relacionado com uma mesma
	chave primária da primeira ponta. Nesse caso ana se repete porque ela tem mais de um telefone cadastrado no seu nome;
	+-------+-------------------------------+------+-----------+
	| nome  | Email                         | ddd  | numero    |
	+-------+-------------------------------+------+-----------+
	| celia | celinhadaquebrada@hotmail.com | 31   | 33922239  |
	| ana   | ahtaldaana@gmail.com          | 31   | 25674530  |
	| ana   | ahtaldaana@gmail.com          | 31   | 914253687 |
	| clara |  -                            | 31   | 953867542 |
	+-------+-------------------------------+------+-----------+
	O email da clara foi substituido de null para - como informado na função ifnull(c.email,' - ')
*/

-- VIEWS - Em questão de performance a view é lenta, na view estamos acessando uma query através de outra;

--Criar o nome da view com v_ para direfenciá-las das tabelas;  NÃO CONSEGUIMOS EXCLUIR NEM INSERIR DADOS EM VIEWS;
create view v_oficina as
select c.nome as 'Cliente',cr.montadora,cr.modelo,cor.nome as 'Cor',s.nome as 'Servico',s.preco as 'Preco',t.ddd,t.numero
from cliente c
inner join carro cr
on c.idCliente = cr.id_Cliente  
inner join servicos s
on  s.id_Cliente = c.idCliente
inner join cores cor 
on cr.idCarro = cor.id_Carro
inner join telefone t 
on c.idCliente = t.id_Cliente;

/*Pequena observação: usar select * from tabela é ruim e lento. Embora tenhamos que digitar mais passando coluna por coluna, a query fica mais rápida;
	
	select * from v_oficina;
	+-----------------+-------------+---------------+------------------------------------+-----------------------------+-------+------+----------+
	| Cliente         | montadora   | modelo        | Cor                                | Servico                     | Preco | ddd  | numero   |
	+-----------------+-------------+---------------+------------------------------------+-----------------------------+-------+------+----------+
	| Ezio Auditore   | Alfa Romeo  | Giulia Veloce | Carbono Fosco                      | Pintura                     |  5520 |   39 | 32548712 |
	| Mario Gallo     | Maserati    | Levante       | Indigo Meia Noite                  | Troca de oleo               |   330 |   39 | 15445871 |
	| Connie Guiseppe | Lamborghini | Urus          | Preto perolado em Verde Esmeralda  | Substituicao de amortecedor |  4000 |   39 | 45876598 |
	+-----------------+-------------+---------------+------------------------------------+-----------------------------+-------+------+----------+
	3 rows in set (0.08 sec) <---
	
	//CONSULTANDO OS DADOS DA VIEW;
	
	select Cliente,montadora,modelo,Cor,Servico,Preco,ddd,numero from v_oficina;
	+-----------------+-------------+---------------+------------------------------------+-----------------------------+-------+------+----------+
	| Cliente         | montadora   | modelo        | Cor                                | Servico                     | Preco | ddd  | numero   |
	+-----------------+-------------+---------------+------------------------------------+-----------------------------+-------+------+----------+
	| Ezio Auditore   | Alfa Romeo  | Giulia Veloce | Carbono Fosco                      | Pintura                     |  5520 |   39 | 32548712 |
	| Mario Gallo     | Maserati    | Levante       | Indigo Meia Noite                  | Troca de oleo               |   330 |   39 | 15445871 |
	| Connie Guiseppe | Lamborghini | Urus          | Preto perolado em Verde Esmeralda  | Substituicao de amortecedor |  4000 |   39 | 45876598 |
	+-----------------+-------------+---------------+------------------------------------+-----------------------------+-------+------+----------+
	3 rows in set (0.00 sec) <---
		
*/

--Conseguimos fazer filtros normalmente dentro de views:

select Cliente,montadora,modelo from oficina
where Preco = 4000; 
/*
	+-----------------+-------------+--------+
	| Cliente         | montadora   | modelo |
	+-----------------+-------------+--------+
	| Connie Guiseppe | Lamborghini | Urus   |
	+-----------------+-------------+--------+
*/
-- Apagando a view
drop view nomeview;

/*ORDER BY
	
	Os dados retornados do banco por uma query são chamados de DataSet.
	O order by serva para ordenar esse data set;
*/

select c.nome, c.email,c.cpf, t.ddd, t.numero, e.bairro, e.rua
from cliente c
inner join telefone t
on c.idCliente = t.id_Cliente
inner join endereco e
on c.idCliente = e.id_Cliente
order by c.nome;

/*

	+--------+-------------------------------+---------+------+-----------+----------+------------+
	| nome   | email                         | cpf     | ddd  | numero    | bairro   | rua        |
	+--------+-------------------------------+---------+------+-----------+----------+------------+
	| ana    | ahtaldaana@gmail.com          | 75658-5 | 31   | 25674530  | Eldorado | Inglaterra |
	| ana    | ahtaldaana@gmail.com          | 75658-5 | 31   | 914253687 | Eldorado | Inglaterra |
	| carlos | caca171@hotmail.com           | 86641-7 | 31   | 963987412 | Eldorado | Belgica    |
	| celia  | celinhadaquebrada@hotmail.com | 77558-5 | 31   | 33922239  | Eldorado | Espanha    |
	| clara  | NULL                          | 99754-7 | 31   | 953867542 | Eldorado | Veneza     |
	| joao   | jaumzin22@gmail.com           | 98547-6 | 31   | 985471234 | Eldorado | Franca     |
	| joao   | jaumzin22@gmail.com           | 98547-6 | 31   | 33920530  | Eldorado | Franca     |
	+--------+-------------------------------+---------+------+-----------+----------+------------+

*/

-- podemos também colocar o ASC junto ao order by para mostrar que queremos algum atributo de maneira ascendente ( menor pro maior );

select c.nome, c.email,c.cpf, t.ddd, t.numero, e.bairro, e.rua
from cliente c
inner join telefone t
on c.idCliente = t.id_Cliente
inner join endereco e
on c.idCliente = e.id_Cliente
order by t.numero asc; -- pedindo pra ordenar por número de celular de maneira ascendente ( não faz muito sentido ordenar por celular, mas é o atributo que mais mexe na ordem da tabela. Ordenar por cpf ficaria muito parecido com o exemplo de cima.

/*
	+--------+-------------------------------+---------+------+-----------+----------+------------+
	| nome   | email                         | cpf     | ddd  | numero    | bairro   | rua        |
	+--------+-------------------------------+---------+------+-----------+----------+------------+
	| ana    | ahtaldaana@gmail.com          | 75658-5 | 31   | 25674530  | Eldorado | Inglaterra |
	| joao   | jaumzin22@gmail.com           | 98547-6 | 31   | 33920530  | Eldorado | Franca     |
	| celia  | celinhadaquebrada@hotmail.com | 77558-5 | 31   | 33922239  | Eldorado | Espanha    |
	| ana    | ahtaldaana@gmail.com          | 75658-5 | 31   | 914253687 | Eldorado | Inglaterra |
	| clara  | NULL                          | 99754-7 | 31   | 953867542 | Eldorado | Veneza     |
	| carlos | caca171@hotmail.com           | 86641-7 | 31   | 963987412 | Eldorado | Belgica    |
	| joao   | jaumzin22@gmail.com           | 98547-6 | 31   | 985471234 | Eldorado | Franca     |
	+--------+-------------------------------+---------+------+-----------+----------+------------+
*/

--ordenando por duas colunas:

select c.nome, c.email,c.cpf, t.ddd, t.numero, e.bairro, e.rua
from cliente c
inner join telefone t
on c.idCliente = t.id_Cliente
inner join endereco e
on c.idCliente = e.id_Cliente
order by c.nome, t.numero asc;

/*
	Nos clientes com mais de um número ( ana e joão que se repetem) a prioridade passa a ser o número menor ('res' antes do 'cel');
	+--------+-------------------------------+---------+------+-----------+----------+------------+
	| nome   | email                         | cpf     | ddd  | numero    | bairro   | rua        |
	+--------+-------------------------------+---------+------+-----------+----------+------------+
	| ana    | ahtaldaana@gmail.com          | 75658-5 | 31   | 25674530  | Eldorado | Inglaterra |
	| ana    | ahtaldaana@gmail.com          | 75658-5 | 31   | 914253687 | Eldorado | Inglaterra |
	| carlos | caca171@hotmail.com           | 86641-7 | 31   | 963987412 | Eldorado | Belgica    |
	| celia  | celinhadaquebrada@hotmail.com | 77558-5 | 31   | 33922239  | Eldorado | Espanha    |
	| clara  | NULL                          | 99754-7 | 31   | 953867542 | Eldorado | Veneza     |
	| joao   | jaumzin22@gmail.com           | 98547-6 | 31   | 33920530  | Eldorado | Franca     |
	| joao   | jaumzin22@gmail.com           | 98547-6 | 31   | 985471234 | Eldorado | Franca     |
	+--------+-------------------------------+---------+------+-----------+----------+------------+
*/

-- Podemos dar um order by no número da coluna. Vai ordenar pela coluna referente ao número:

select c.nome, c.email,c.cpf, t.ddd, t.numero, e.bairro, e.rua
from cliente c
inner join telefone t
on c.idCliente = t.id_Cliente
inner join endereco e
on c.idCliente = e.id_Cliente
order by 7; -- Ordena a coluna rua;

/*
	+--------+-------------------------------+---------+------+-----------+----------+------------+
	| nome   | email                         | cpf     | ddd  | numero    | bairro   | rua        |
	+--------+-------------------------------+---------+------+-----------+----------+------------+
	| carlos | caca171@hotmail.com           | 86641-7 | 31   | 963987412 | Eldorado | Belgica    |
	| celia  | celinhadaquebrada@hotmail.com | 77558-5 | 31   | 33922239  | Eldorado | Espanha    |
	| joao   | jaumzin22@gmail.com           | 98547-6 | 31   | 985471234 | Eldorado | Franca     |
	| joao   | jaumzin22@gmail.com           | 98547-6 | 31   | 33920530  | Eldorado | Franca     |
	| ana    | ahtaldaana@gmail.com          | 75658-5 | 31   | 25674530  | Eldorado | Inglaterra |
	| ana    | ahtaldaana@gmail.com          | 75658-5 | 31   | 914253687 | Eldorado | Inglaterra |
	| clara  | NULL                          | 99754-7 | 31   | 953867542 | Eldorado | Veneza     |
	+--------+-------------------------------+---------+------+-----------+----------+------------+
*/

/* DELIMITADOR E ESTADO DO SERVIDOR
	
   STATUS -> retorna informações sobre o servidor;
   
   DELIMITER símbolo -> troca o delimitador pelo símbolo passado;

*/

/* PROCEDURES */
/* O delimitador foi trocado de ; para $ */

--estrutura básica das procedures:
create procedure nome()
begin
	comandos;
end
$

create procedure allData()
begin

select c.nome,c.sexo,ifnull(c.email,' - ')as 'email',c.cpf,t.tipo,t.ddd,t.numero,e.rua,e.bairro,e.cidade,e.estado
from cliente c
inner join telefone t
on c.idCliente = t.id_Cliente
inner join endereco e
on c.idCliente = e.id_Cliente
order by c.nome;

end
$

/* Chamando a procedure*/

call nomeProcedure()$

call allData()$

/* Apagagando a procedure*/
drop procedure nome$
drop procedure allData$

/* Procedure com parâmetros */
                         --colocar o p_ na frente para indicar que é um parâmetro
create procedure allData(p_sexo char)
begin

select c.nome,c.sexo,ifnull(c.email,' - ')as 'email',c.cpf,t.tipo,t.ddd,t.numero,e.rua,e.bairro,e.cidade,e.estado
from cliente c
inner join telefone t
on c.idCliente = t.id_Cliente
inner join endereco e
on c.idCliente = e.id_Cliente
where c.sexo = p_sexo --Só retorna os clientes com o sexo determinado no parâmetro;
order by c.nome;

end
$

/* Tabela Produto*/
--Não precisa colocar not null em primary key que já é auto_increment, toda vez que cadastrar o banco já vai colocar um valor automaticamente;
create table produto(
	
	idProduto int primary key auto_increment,
	nome varchar(20) not null,
	valor float(5,2) not null
	
);

/* Tabela Compra*/
create table compra(
	
	idCompra int primary key auto_increment,
	valor float(10,2) not null,
	dtCompra timestamp not null default current_timestamp, --current_timestamp retorna a data e hora atuais. Nesse caso vai registrar a data e a hora que o registro foi inserido no banco; 
	id_Produto int not null,
	id_Cliente int unique not null,
	
	foreign key (id_Produto)
	references produto(idProduto),
	
	foreign key (id_Cliente)
	references cliente(idCliente)
	
);

/* Inserts */

insert into produto(nome,valor) values ('margarina',5);
insert into produto(nome,valor) values ('arroz',16);
insert into produto(nome,valor) values ('feijao',8);
insert into produto(nome,valor) values ('pao',9.99);

insert into compra(valor,id_Produto,id_Cliente) values (50,1,2);
insert into compra(valor,id_Produto,id_Cliente) values (160,2,1);
insert into compra(valor,id_Produto,id_Cliente) values (6.50,4,3);
insert into compra(valor,id_Produto,id_Cliente) values (80,3,4);

/* Query*/


/* Procedure para cadastrar uma compra*/              --colocar o p_ na frente para indicar que é um parâmetro;
create procedure newPurchase(p_moneySpent float(10,2),p_productId int(3),p_clientId int(3))
begin
	insert into compra(valor,id_Produto,id_Cliente) values (p_moneySpent,p_productId,p_clientId);
end
$

call newPurchase(200,4,5);

/* Procedure para visualizar as compras*/
create procedure showPurchases()
begin
	select c.nome,p.nome as 'Produto',cm.valor as 'Total da Compra',cm.dtCompra as 'Data'
	from cliente c
	inner join compra cm
	on c.idCliente = cm.id_Cliente
	inner join produto p
	on p.idProduto = cm.id_Produto
	order by c.nome;
end
$

call showPurchases();

/* FUNÇÕES DE AGREGAÇÃO */

/* MAX(coluna) retorna o maior valor da coluna especificada*/
select max(cp.valor) as 'Maior compra' 
from compra cp;

--Retorna o valor da maior compra e o nome do cliente que a fez
set @mx = (select max(cp.valor) from compra cp);
select @mx as 'Maior compra',c.nome
    from compra cp
    inner join cliente c
    on cp.id_Cliente = c.idCliente
	where cp.valor = @mx;
	/*
		+--------------+-------+
		| Maior compra | nome  |
		+--------------+-------+
		|          200 | celia |
		+--------------+-------+
	*/


/* MIN(coluna) retorna o menor valor da coluna especificada*/
select min(cp.valor) as 'Menor compra' 
from compra cp;

-- Retorna o valor da menor compra e o nome do cliente que a fez
set @mx = (select min(cp.valor) from compra cp);
select @mx as 'Menor compra',c.nome
    from compra cp
    inner join cliente c
    on cp.id_Cliente = c.idCliente
	where cp.valor = @mx;
	
	/*
		+--------------+------+
		| Menor compra | nome |
		+--------------+------+
		|          6.5 | ana  |
		+--------------+------+	
	*/
		

/* AVG(coluna) retorna a média de todos os valores da coluna específicada*/
--truncate(valor,casas decimais) -> retona o valor com o número de casas decimais específicadas;
select truncate(avg(cp.valor),2) as 'Media de gastos'
from compra cp;

	/*
		+-----------------+
		| Media de gastos |
		+-----------------+
		|           99.30 |
		+-----------------+
	*/

/* SUM(coluna) retorna todos os valores somados */
select sum(cp.valor) as 'Total de gastos' 
from compra cp;

	/*
		+-----------------+
		| Total de gastos |
		+-----------------+
		|          496.50 |
		+-----------------+

	*/
	
/* Um banco de dados serve para pegar dados e gerar informações com esses dados*/

/*Valor gasto por sexo*/
select c.sexo, sum(cp.valor)  as 'Gastos'
from compra cp
inner join cliente c
on c.idCliente = cp.id_Cliente
group by c.sexo;

	/*
		+------+--------+
		| sexo | Gastos |
		+------+--------+
		| m    | 210.00 |
		| f    | 286.50 |
		+------+--------+
	*/
	
	
/*Quem gastou mais que a média */
set @md = (select avg(cp.valor) from compra cp);
select c.nome, cp.valor, @md as 'Media de compra' 
from cliente c
inner join compra cp
on c.idCliente = cp.id_Cliente
where cp.valor > @md
order by c.nome;

	/* 
		+-------+--------+-----------------+
		| nome  | valor  | Media de compra |
		+-------+--------+-----------------+
		| celia | 200.00 |            99.3 |
		| joao  | 160.00 |            99.3 |
		+-------+--------+-----------------+
	*/

--Usando subQuery

select c.nome, cp.valor, @md as 'Media de compra' -- Outer query  - Query de fora
from cliente c
inner join compra cp
on c.idCliente = cp.id_Cliente
where cp.valor > (select avg(cp.valor) from compra cp) -- ( Inner query ) query dentro de outra query - subSelect;
order by c.nome;
	/*
		+-------+--------+-----------------+
		| nome  | valor  | Media de compra |
		+-------+--------+-----------------+
		| celia | 200.00 |            99.3 |
		| joao  | 160.00 |            99.3 |
		+-------+--------+-----------------+
	*/

/* Operações na linha */
select c.nome, 
	   cp.valor,
	  (cp.valor *.3) as 'Desconto de 30%',
	  (cp.valor - (cp.valor *.3)) as 'Total a pagar'
from cliente c
inner join compra cp
on c.idCliente = cp.id_Cliente  --sempre colocar o on; 
where cp.valor > (select avg(cp.valor) from compra cp);

	/*
		+-------+--------+-----------------+---------------+
		| nome  | valor  | Desconto de 30% | Total a pagar |
		+-------+--------+-----------------+---------------+
		| joao  | 160.00 |           48.00 |        112.00 |
		| celia | 200.00 |           60.00 |        140.00 |
		+-------+--------+-----------------+---------------+

	*/
	
/* Reescrevendo a procedure showPurchases() */
create procedure showPurchases()
begin
	select c.nome, 
		   cp.valor,
	      (cp.valor *.3) as 'Desconto de 30%',
	      (cp.valor - (cp.valor *.3)) as 'Total a pagar'
    from cliente c
    inner join compra cp
    on c.idCliente = cp.id_Cliente   
    where cp.valor > (select avg(cp.valor) from compra cp);
end
$

/* ALTERANDO TABELAS */
create table Colunas(
	coluna1 varchar(30),
	coluna2 varchar(30),
	coluna3 varchar(30)
);

--Adicionando uma chave primária:
alter table nomeTabela
add primary key (nome_coluna);

alter table Colunas
add primary key (coluna1); -- Não dá pra colocar auto_increment quando colocamos a primary key por fora ( com alter table ), só na hora de criar;

--Adicionando uma coluna sem posição específica ( Fazendo desta maneira, por padrão, a coluna vai pra última posição da tabela ):
alter table nomeTabela
add nomeColuna tipodeDado(tamanho) --Sempre coolocar o tipo de dado;

alter table Colunas
add coluna varchar(30);

alter table colunas
add coluna13 int;

--Adicionando uma coluna com posição específica:
alter table colunas
add coluna11 varchar(30) not null unique 
after coluna;

--Modificando o tipo de um campo:
alter table nomeTabela
modify nomeColuna novoTipodeDado(tamanho) not null unique;

alter table colunas 
modify coluna13 varchar(30) not null; --para modificar a estrutura de um campo os valores têm de ser compatíveis ( uma coluna char ou varchar com o valor 'carl' não pode ser modificada pra int. Mas uma coluna char com o valor '13' pode ser trocado pra int ) ou então o campo tem que estar vazio, sem nenhum dado cadastrado;

--Adicionando uma FK:

--Como a FK tem que ser do mesmo tipo da PK da tabela que vai ser importada e não temos um campo int, vamos realterar a coluna 13;
alter table colunas
modify coluna13 int(2);

alter table colunas
add foreign key (coluna13)
references cliente(idCliente);

--Renomeando a tabela:
alter table Colunas
rename coluna;

--Ver as chaves de uma tabela:
SHOW CREATE TABLE nomeTabela;

SHOW CREATE TABLE coluna;

/* Convenção de criação de PK e FK -  Constraints ( Regra de integridade referencial ) */
-- A PK garante que o registro seja único na tabela e a FK garante que não vamos ter nenhum registro solto ou 'orfão';



/* Não é uma boa prática criarmos as chaves ( PK e FK ) juntamente com a tabela.  */


create database convencao;

use convencao;

create table cliente(
	
	idCliente int,
	nome varchar(10) not null
	
);

create table telefone(

	idTelefone int,
	tipo enum('cel','res','com') not null,
	numero varchar(10) not null,
	id_Cliente int
	
);

alter table cliente add constraint pk_cliente  -- Adicionando PK e FK a parte;
primary key (idCliente);

alter table telefone add constraint fk_cliente_telefone
foreign key (id_Cliente) references cliente(idCliente);

show create table telefone;

/*  
| telefone | CREATE TABLE `telefone` (
  `idTelefone` int(11) DEFAULT NULL,
  `tipo` enum('cel','res','com') NOT NULL,
  `numero` varchar(10) NOT NULL,
  `id_Cliente` int(11) DEFAULT NULL,
  KEY `fk_cliente_telefone` (`id_Cliente`),
  CONSTRAINT `fk_cliente_telefone` FOREIGN KEY (`id_Cliente`) REFERENCES `cliente` (`idCliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci |
*/

/* Acessando dicionário de dados*/

use information_schema; --Banco com as informações de todos os bancos criados;

desc table_constraints; --Tabela com as constraints ( regras ) de todos os bancos;

select constraint_schema as "Banco de Origem", --projeção
	   table_name as "Tabela",
	   constraint_name as "Nome da Regra",
	   constraint_type as "Tipo de Chave"
	   from table_constraints
	   where constraint_schema='projeto'; -- seleção;
	   

/*
	+-----------------+----------+---------------------+---------------+
	| Banco de Origem | Tabela   | Nome da Regra       | Tipo de Chave |
	+-----------------+----------+---------------------+---------------+
	| convencao       | cliente  | PRIMARY             | PRIMARY KEY   |
	| convencao       | telefone | fk_cliente_telefone | FOREIGN KEY   |
	+-----------------+----------+---------------------+---------------+
*/

/* Apagando Constraints*/

use convencao

alter table telefone
drop foreign key fk_cliente_telefone;



